<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\EstadoPedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientePedidoController extends Controller
{
    /**
     * Obtiene el registro de clientes ligado al usuario autenticado
     * mediante el email. Si no existe, lanza 403.
     */
    protected function getClienteOrFail()
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Debes iniciar sesión.');
        }

        // Buscamos en "clientes" por el mismo correo del usuario
        $cliente = DB::table('clientes')
            ->where('email', $user->email)
            ->first();

        if (! $cliente) {
            abort(403, 'Tu usuario no está ligado a un registro de cliente.');
        }

        return $cliente;
    }

    // Historial de pedidos del cliente autenticado
    public function index()
    {
        $cliente = $this->getClienteOrFail();

        $pedidos = DB::table('pedidos as p')
            ->join('estados_pedido as e', 'p.id_estado', '=', 'e.id_estado')
            ->where('p.id_cliente', $cliente->id_cliente)
            ->orderByDesc('p.fecha')
            ->select(
                'p.id_pedido',
                'p.fecha',
                'e.nombre as estado',
                'p.tipo'
            )
            ->get();

        return view('clientes.pedidos.index', compact('pedidos'));
    }

    // Ver detalle de un pedido específico
    public function show($id)
    {
        $cliente = $this->getClienteOrFail();

        $pedido = DB::table('pedidos as p')
            ->join('estados_pedido as e', 'p.id_estado', '=', 'e.id_estado')
            ->where('p.id_cliente', $cliente->id_cliente)
            ->where('p.id_pedido', $id)
            ->select(
                'p.id_pedido',
                'p.fecha',
                'e.nombre as estado',
                'p.tipo'
            )
            ->first();

        if (! $pedido) {
            abort(403, 'No tienes acceso a este pedido.');
        }

        $detalles = DB::table('pedidos_detalle as d')
            ->join('productos as pr', 'pr.id_producto', '=', 'd.id_producto')
            ->where('d.id_pedido', $id)
            ->select(
                'pr.nombre',
                'd.cantidad',
                'pr.precio_venta',
                DB::raw('d.cantidad * pr.precio_venta AS importe')
            )
            ->get();

        $total = $detalles->sum('importe');

        return view('clientes.pedidos.show', compact('pedido', 'detalles', 'total'));
    }

    // Cancelar pedido (solo si aún no está entregado / devuelto / cancelado)
    public function cancelar($id)
    {
        $cliente = $this->getClienteOrFail();

        $pedido = Pedido::where('id_cliente', $cliente->id_cliente)
            ->findOrFail($id);

        // Tomamos el estado actual desde la tabla estados_pedido
        $estadoActual = EstadoPedido::find($pedido->id_estado);
        $nombreActual = strtolower($estadoActual->nombre ?? '');

        if (in_array($nombreActual, ['entregado', 'cancelado', 'devuelto'])) {
            return back()->with(
                'error',
                'No se puede cancelar un pedido entregado, devuelto o cancelado.'
            );
        }

        $estadoCancelado = EstadoPedido::where('nombre', 'Cancelado')->first();
        $pedido->id_estado = $estadoCancelado ? $estadoCancelado->id_estado : 5;
        $pedido->save();

        return redirect()
            ->route('clientes.pedidos.index')
            ->with('success', 'Pedido cancelado correctamente.');
    }
}
