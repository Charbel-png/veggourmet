<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // ADMIN y OPERADOR ven el dashboard
        if (in_array($user->tipo, ['admin', 'operador'])) {
            $data = $this->buildDashboard();     // <─ ahora sí existe
            return view('dashboard.index', $data);
        }

        // CLIENTE se va a su catálogo
        if ($user->tipo === 'cliente') {
            return redirect()->route('cliente.productos');
        }

        abort(403);
    }

    /**
     * Arma todos los datos que necesita el panel.
     */
    protected function buildDashboard(): array
    {
        // Tarjetas de resumen
        $productosTotal = DB::table('productos')->count();
        $clientesTotal  = DB::table('clientes')->count();
        $pedidosTotal   = DB::table('pedidos')->count();

        // Productos con menor stock (un collection, NO un count)
        $productosMenorStock = DB::table('productos')
            ->join('inventario', 'productos.id_producto', '=', 'inventario.id_inventario')
            ->select(
                'productos.id_producto',
                'productos.nombre',
                'inventario.stock',
                'inventario.stock_minimo'
            )
            ->orderBy('inventario.stock', 'asc')
            ->limit(5)
            ->get();

        return [
            // nombres que usará la vista
            'totalProductos'     => $productosTotal,
            'totalClientes'      => $clientesTotal,
            'totalPedidos'       => $pedidosTotal,
            'productosMenorStock'=> $productosMenorStock,
        ];
    }
}
