<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\EstadoPedido;
use App\Models\Inventario;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // ==========================
    // LISTAR PEDIDOS (ADMIN/OPERADOR)
    // ==========================
    public function index()
    {
        $this->ensureAdminOperador();

        $pedidos = DB::table('pedidos as p')
            ->leftJoin('clientes as c', 'c.id_cliente', '=', 'p.id_cliente')
            ->leftJoin('estados_pedido as e', 'e.id_estado', '=', 'p.id_estado')
            ->select(
                'p.id_pedido',
                'p.fecha',
                'p.id_estado',
                'c.nombre as cliente',
                'e.nombre as estado',
                'p.tipo'
            )
            ->orderByDesc('p.fecha')
            ->get();

        $totales = DB::table('pedidos_detalle as d')
            ->join('productos as pr', 'pr.id_producto', '=', 'd.id_producto')
            ->selectRaw('d.id_pedido, SUM(d.cantidad * pr.precio_venta) as total')
            ->groupBy('d.id_pedido')
            ->pluck('total', 'd.id_pedido');

        foreach ($pedidos as $p) {
            $p->total = $totales[$p->id_pedido] ?? 0;
        }

        $estados = EstadoPedido::orderBy('nombre')->get();

        return view('pedidos.index', compact('pedidos', 'estados'));
    }

    // ==========================
    // CREAR PEDIDO MANUAL (ADMIN)
    // ==========================
    public function create()
    {
        $this->ensureAdminOperador();

        $clientes     = Cliente::orderBy('nombre')->get();
        $estados      = EstadoPedido::orderBy('nombre')->get();
        $fechaDefault = now()->format('Y-m-d\TH:i');

        return view('pedidos.create', compact('clientes', 'estados', 'fechaDefault'));
    }

    public function store(Request $request)
    {
        $this->ensureAdminOperador();

        $data = $request->validate([
            'id_cliente' => ['nullable', 'exists:clientes,id_cliente'],
            'fecha'      => ['required', 'date'],
            'id_estado'  => ['required', 'exists:estados_pedido,id_estado'],
            'tipo'       => ['required', 'string', 'max:20'],
        ]);

        Pedido::create([
            'id_cliente'       => $data['id_cliente'] ?? null,
            'fecha'            => $data['fecha'],
            'id_estado'        => $data['id_estado'],
            'tipo'             => $data['tipo'],
            'id_empleado_toma' => null,
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    // ==========================
    // EDITAR / ACTUALIZAR PEDIDO
    // ==========================
    public function edit(Pedido $pedido)
    {
        $this->ensureAdminOperador();

        $clientes     = Cliente::orderBy('nombre')->get();
        $estados      = EstadoPedido::orderBy('nombre')->get();
        $fechaDefault = date('Y-m-d\TH:i', strtotime($pedido->fecha));

        return view('pedidos.edit', compact('pedido', 'clientes', 'estados', 'fechaDefault'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $this->ensureAdminOperador();

        $data = $request->validate([
            'id_cliente' => ['nullable', 'exists:clientes,id_cliente'],
            'fecha'      => ['required', 'date'],
            'id_estado'  => ['required', 'exists:estados_pedido,id_estado'],
            'tipo'       => ['required', 'string', 'max:20'],
        ]);

        $pedido->update([
            'id_cliente' => $data['id_cliente'] ?? null,
            'fecha'      => $data['fecha'],
            'id_estado'  => $data['id_estado'],
            'tipo'       => $data['tipo'],
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    // ==========================
    // ELIMINAR PEDIDO
    // ==========================
    public function destroy(Pedido $pedido)
    {
        $this->ensureAdminOperador();

        $pedido->delete();

        return back()->with('success', 'Pedido eliminado correctamente.');
    }

    public function show($id)
    {
        $this->ensureAdminOperador();

        // Datos generales del pedido
        $pedido = DB::table('pedidos as p')
            ->leftJoin('clientes as c', 'c.id_cliente', '=', 'p.id_cliente')
            ->leftJoin('estados_pedido as e', 'e.id_estado', '=', 'p.id_estado')
            ->select(
                'p.id_pedido',
                'p.fecha',
                'p.tipo',
                'c.nombre',
                'c.ap_paterno',
                'c.ap_materno',
                'e.nombre as estado_nombre'
            )
            ->where('p.id_pedido', $id)
            ->first();

        if (! $pedido) {
            abort(404, 'Pedido no encontrado.');
        }

        // Detalle de productos
        $detalles = DB::table('pedidos_detalle as d')
            ->join('productos as pr', 'pr.id_producto', '=', 'd.id_producto')
            ->where('d.id_pedido', $id)
            ->select(
                'pr.nombre as producto',
                'd.cantidad',
                'pr.precio_venta as precio_unitario',
                DB::raw('d.cantidad * pr.precio_venta AS importe')
            )
            ->get();

        $subtotal = $detalles->sum('importe');
        $total    = $subtotal; // por ahora sin IVA/descuentos

        return view('pedidos.show', compact('pedido', 'detalles', 'subtotal', 'total'));
    }

    public function updateEstado(Request $request, $id)
    {
        $this->ensureAdminOperador();

        $request->validate([
            'id_estado' => 'required|integer|exists:estados_pedido,id_estado',
        ]);

        $pedido = Pedido::findOrFail($id);
        $estadoNuevo = EstadoPedido::find($request->id_estado);

        if (! $estadoNuevo) {
            return back()->with('error', 'Estado no válido.');
        }

        // Regla: No se puede cancelar un pedido entregado
        $estadoActual = EstadoPedido::find($pedido->id_estado);
        if ($estadoActual && strtolower($estadoActual->nombre) === 'entregado' &&
            strtolower($estadoNuevo->nombre) === 'cancelado') {
            return back()->with('error', 'No se puede cancelar un pedido entregado.');
        }

        // Si se cancela o devuelve → restaurar stock
        if (in_array(strtolower($estadoNuevo->nombre), ['cancelado', 'devuelto'])) {
            $this->restaurarStockPedido($pedido->id_pedido);
        }

        if (in_array(strtolower($estadoActual->nombre), ['cancelado', 'devuelto']) &&
            !in_array(strtolower($estadoNuevo->nombre), ['cancelado', 'devuelto'])) {
            return back()->with('error', 'No se puede modificar un pedido cancelado o devuelto.');
        }

        $pedido->id_estado = $estadoNuevo->id_estado;
        $pedido->save();

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Estado del pedido actualizado correctamente.');
    }

    // ==========================
    // CONFIRMAR PEDIDO DESDE EL CARRITO (CLIENTE)
    // ==========================
    public function confirmarDesdeCarrito(Request $request)
    {
        $this->ensureSoloCliente();

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('clientes.carrito')
                ->with('error', 'Tu carrito está vacío.');
        }

        $user = auth()->user();
        $idCliente = $user->id_cliente ?? null;

        DB::beginTransaction();

        try {
            $estadoPendiente = EstadoPedido::where('nombre', 'Pendiente')->first();
            $idEstado = $estadoPendiente ? $estadoPendiente->id_estado : 1;

            $pedido = Pedido::create([
                'id_cliente'       => $idCliente,
                'fecha'            => now(),
                'id_estado'        => $idEstado,
                'tipo'             => 'online',
                'id_empleado_toma' => null,
            ]);

            foreach ($cart as $item) {
                $idProducto = $item['id_producto'] ?? null;
                $cantidad = $item['cantidad'] ?? 0;

                if (!$idProducto || $cantidad <= 0) continue;

                DetallePedido::create([
                    'id_pedido'   => $pedido->id_pedido,
                    'id_producto' => $idProducto,
                    'cantidad'    => $cantidad,
                ]);
            }

            $this->descontarStockPedido($pedido->id_pedido);

            session()->forget('cart');

            DB::commit();

            return redirect()->route('clientes.pedidos.index')
                ->with('success', 'Pedido confirmado y stock actualizado correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()->route('clientes.carrito')
                ->with('error', 'Ocurrió un problema al confirmar tu pedido: ' . $e->getMessage());
        }
    }

    // ==========================
    // DESCONTAR STOCK DE INVENTARIO
    // ==========================
    protected function descontarStockPedido(int $idPedido): void
    {
        $detalles = DetallePedido::where('id_pedido', $idPedido)->get();

        foreach ($detalles as $detalle) {
            $inventario = Inventario::where('id_producto', $detalle->id_producto)->lockForUpdate()->first();

            if (!$inventario) {
                throw new \Exception("No hay inventario registrado para el producto #{$detalle->id_producto}.");
            }

            $stockActual = (float) $inventario->stock;
            $cantidad = (float) $detalle->cantidad;

            if ($cantidad > $stockActual) {
                throw new \Exception(
                    "Stock insuficiente para el producto #{$detalle->id_producto}. ".
                    "Quedan {$stockActual} en inventario y se intentan descontar {$cantidad}."
                );
            }

            $inventario->stock = $stockActual - $cantidad;
            $inventario->save();
        }
    }

    // ==========================
    // VALIDADORES DE ROL
    // ==========================
    protected function ensureSoloCliente()
    {
        $user = auth()->user();
        if (!$user || $user->tipo !== 'cliente') {
            abort(403, 'Solo los clientes pueden realizar esta acción.');
        }
    }

    protected function ensureAdminOperador()
    {
        $user = auth()->user();
        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Solo el personal autorizado puede gestionar pedidos.');
        }
    }

    protected function restaurarStockPedido(int $idPedido): void
    {
        $detalles = DetallePedido::where('id_pedido', $idPedido)->get();

        if ($detalles->isEmpty()) {
            return;
        }

        foreach ($detalles as $detalle) {
            $inventario = Inventario::where('id_producto', $detalle->id_producto)->first();

            if (! $inventario) {
                continue;
            }

            $inventario->stock += $detalle->cantidad; // devolvemos el stock
            $inventario->save();
        }
    }
}
