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
    // GET /pedidos (panel administración)
    public function index()
    {
        $this->ensureAdminOperador();

        $pedidos = Pedido::with(['cliente', 'estado'])
            ->orderByDesc('fecha')
            ->paginate(20);

        return view('pedidos.index', compact('pedidos'));
    }

    // GET /pedidos/create (panel administración)
    public function create()
    {
        $this->ensureAdminOperador();

        $clientes     = Cliente::orderBy('nombre')->get();
        $estados      = EstadoPedido::orderBy('nombre')->get();
        $fechaDefault = now()->format('Y-m-d\TH:i');

        return view('pedidos.create', compact('clientes', 'estados', 'fechaDefault'));
    }

    // POST /pedidos (panel administración)
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
            'id_empleado_toma' => null, // por ahora no se usa
        });

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    // GET /pedidos/{pedido}/edit (panel administración)
    public function edit(Pedido $pedido)
    {
        $this->ensureAdminOperador();

        $clientes     = Cliente::orderBy('nombre')->get();
        $estados      = EstadoPedido::orderBy('nombre')->get();
        $fechaDefault = date('Y-m-d\TH:i', strtotime($pedido->fecha));

        return view('pedidos.edit', compact('pedido', 'clientes', 'estados', 'fechaDefault'));
    }

    // PUT /pedidos/{pedido} (panel administración)
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

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    // DELETE /pedidos/{pedido} (panel administración)
    public function destroy(Pedido $pedido)
    {
        $this->ensureAdminOperador();

        $pedido->delete();

        return back()->with('success', 'Pedido eliminado correctamente.');
    }

    // GET /pedidos/{id} - detalle del pedido
    public function show($id)
    {
        $user = auth()->user();

        // Pedido + cliente + estado + detalles con producto
        $query = Pedido::with([
                'cliente',
                'estado',
                'detalles.producto',
            ])
            ->where('id_pedido', $id);

        // Reglas de acceso:
        //  - admin / operador: cualquier pedido
        //  - cliente: solo sus propios pedidos
        if ($user && $user->tipo === 'cliente') {
            $clienteId = $user->id_cliente ?? null;
            $query->where('id_cliente', $clienteId);
        }

        $pedido = $query->firstOrFail();

        // Cálculo de totales (usando precio_venta del producto)
        $subtotal = 0;

        foreach ($pedido->detalles as $detalle) {
            $precio   = $detalle->producto->precio_venta ?? 0;
            $cantidad = (float) $detalle->cantidad;
            $importe  = $cantidad * (float) $precio;

            // Propiedad "virtual" solo para la vista
            $detalle->importe_calculado = $importe;

            $subtotal += $importe;
        }

        $total = $subtotal; // aquí luego puedes sumar IVA, descuentos, etc.

        return view('pedidos.show', compact('pedido', 'subtotal', 'total'));
    }

    /**
     * Confirmar pedido a partir del carrito del cliente
     * y descontar stock del inventario.
     *
     * Ruta: POST /cliente/pedido/confirmar
     */
    public function confirmarDesdeCarrito(Request $request)
    {
        $this->ensureSoloCliente();

        // Carrito almacenado en sesión
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $user      = auth()->user();
        $idCliente = $user->id_cliente ?? null;

        DB::beginTransaction();

        try {
            // Buscar estado "Pendiente" (fallback al id 1 si no existe)
            $estadoPendiente = EstadoPedido::where('nombre', 'Pendiente')->first();
            $idEstado        = $estadoPendiente ? $estadoPendiente->id_estado : 1;

            // 1) Crear pedido
            $pedido = Pedido::create([
                'id_cliente'       => $idCliente,
                'fecha'            => now(),
                'id_estado'        => $idEstado,
                'tipo'             => 'online',
                'id_empleado_toma' => null,
            ]);

            // 2) Crear un detalle por cada producto del carrito
            foreach ($cart as $item) {
                // 🔴 IMPORTANTE:
                // Aquí asumimos que cada elemento del carrito
                // tiene las claves 'id_producto' y 'cantidad'.
                $idProducto = $item['id_producto'] ?? null;
                $cantidad   = $item['cantidad'] ?? null;

                if (! $idProducto || ! $cantidad || $cantidad <= 0) {
                    continue;
                }

                DetallePedido::create([
                    'id_pedido'   => $pedido->id_pedido,
                    'id_producto' => $idProducto,
                    'cantidad'    => $cantidad,
                ]);
            }

            // 3) Descontar stock del inventario según ese pedido
            $this->descontarStockPedido($pedido->id_pedido);

            // 4) Vaciar carrito
            session()->forget('cart');

            DB::commit();

            return redirect()
                ->route('pedidos.show', $pedido->id_pedido)
                ->with('success', 'Pedido confirmado y stock actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return redirect()
                ->route('cart.index')
                ->with('error', 'Ocurrió un problema al confirmar tu pedido. Intenta de nuevo.');
        }
    }

    /**
     * Descuenta stock del inventario según el detalle del pedido.
     */
    protected function descontarStockPedido(int $idPedido): void
    {
        $detalles = DetallePedido::where('id_pedido', $idPedido)->get();

        if ($detalles->isEmpty()) {
            return;
        }

        foreach ($detalles as $detalle) {
            $inventario = Inventario::where('id_producto', $detalle->id_producto)->first();

            // Si no hay inventario registrado para ese producto, lo ignoramos
            if (! $inventario) {
                continue;
            }

            $stockActual = (float) $inventario->stock;
            $cantidad    = (float) $detalle->cantidad;

            // Nuevo stock (no dejamos que sea negativo)
            $nuevoStock = max(0, $stockActual - $cantidad);

            $inventario->stock = $nuevoStock;
            $inventario->save();
        }
    }

    /**
     * Solo clientes (para flujo de carrito / cliente).
     */
    protected function ensureSoloCliente()
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'cliente') {
            abort(403, 'Solo los clientes pueden realizar esta acción.');
        }
    }

    /**
     * Solo admin u operador (para panel de administración).
     */
    protected function ensureAdminOperador()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Solo el personal del restaurante puede gestionar pedidos.');
        }
    }
}
