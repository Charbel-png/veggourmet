<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\EstadoPedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // GET /pedidos
    public function index()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para ver pedidos.');
        }

        $this->ensureAdminOperador(); // o comenta esto si también quieres que cliente vea aquí

    $pedidos = Pedido::with('cliente')
        ->orderByDesc('fecha')
        ->paginate(20);

    return view('pedidos.index', compact('pedidos'));
    }

    // GET /pedidos/create
    public function create()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para crear pedidos.');
        }

        $this->ensureSoloCliente();

        $clientes = Cliente::orderBy('nombre')->get();
        $estados  = EstadoPedido::orderBy('nombre')->get();

        // fecha actual por defecto
        $fechaDefault = now()->format('Y-m-d\TH:i');

        return view('pedidos.create', compact('clientes', 'estados', 'fechaDefault'));
    }

    // POST /pedidos
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403);
        }

        $this->ensureSoloCliente();

        $request->validate([
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'fecha'      => 'required|date',
            'id_estado'  => 'required|exists:estados_pedido,id_estado',
            'tipo'       => 'required|string|max:20',
        ]);

        Pedido::create([
            'id_cliente'       => $request->id_cliente ?: null,
            'fecha'            => $request->fecha,
            'id_estado'        => $request->id_estado,
            'tipo'             => $request->tipo,
            // por ahora no usamos empleado_toma
            'id_empleado_toma' => null,
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    // GET /pedidos/{pedido}/edit
    public function edit(Pedido $pedido)
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403);
        }

        $this->ensureSoloCliente();

        $clientes = Cliente::orderBy('nombre')->get();
        $estados  = EstadoPedido::orderBy('nombre')->get();

        $fechaDefault = date('Y-m-d\TH:i', strtotime($pedido->fecha));

        return view('pedidos.edit', compact('pedido', 'clientes', 'estados', 'fechaDefault'));
    }

    // PUT /pedidos/{pedido}
    public function update(Request $request, Pedido $pedido)
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403);
        }

        $request->validate([
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'fecha'      => 'required|date',
            'id_estado'  => 'required|exists:estados_pedido,id_estado',
            'tipo'       => 'required|string|max:20',
        ]);

        $pedido->update([
            'id_cliente' => $request->id_cliente ?: null,
            'fecha'      => $request->fecha,
            'id_estado'  => $request->id_estado,
            'tipo'       => $request->tipo,
        ]);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    // DELETE /pedidos/{pedido}
    public function destroy(Pedido $pedido)
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403);
        }

        $this->ensureAdminOperador();

    $pedido->delete();

    return back()->with('success', 'Pedido eliminado correctamente.');
    }

    protected function ensureSoloCliente()
    {
        if (auth()->user()->tipo !== 'cliente') {
            abort(403, 'Solo los clientes pueden crear o modificar pedidos.');
        }
    }

    protected function ensureAdminOperador()
    {
        if (!in_array(auth()->user()->tipo, ['admin', 'operador'])) {
            abort(403, 'Solo el personal del restaurante puede gestionar pedidos.');
        }
    }
    public function show($id)
    {
        $user = auth()->user();

        // Base de la consulta: pedido + cliente + estado + detalles con producto
        $query = Pedido::with([
            'cliente',
            'estado',
            'detalles.producto',
        ])->where('id_pedido', $id);

        // Reglas de acceso:
        //  - admin / operador: pueden ver cualquier pedido
        //  - cliente: solo sus propios pedidos
        if ($user->tipo === 'cliente') {
            // Ajusta este campo si tu User está ligado de otra forma al cliente
            $clienteId = $user->id_cliente ?? null;
            $query->where('id_cliente', $clienteId);
        }

        $pedido = $query->firstOrFail();

        // Cálculo de totales (usando precio_venta del producto)
        $subtotal = 0;

        foreach ($pedido->detalles as $detalle) {
            $precio = $detalle->producto->precio_venta ?? 0;
            $importe = (float) $detalle->cantidad * (float) $precio;

            // Propiedad "virtual" solo para la vista
            $detalle->importe_calculado = $importe;

            $subtotal += $importe;
        }

        $total = $subtotal; // aquí luego podrías sumar IVA o descuentos

        return view('pedidos.show', compact('pedido', 'subtotal', 'total'));
    }
}
