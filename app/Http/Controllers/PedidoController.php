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

        $pedidos = Pedido::with(['cliente', 'estado'])
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('pedidos.index', compact('pedidos'));
    }

    // GET /pedidos/create
    public function create()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para crear pedidos.');
        }

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

        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}
