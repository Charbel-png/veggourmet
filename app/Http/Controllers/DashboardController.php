<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Pedido;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para ver el dashboard.');
        }

        // Métricas sencillas (puedes refinarlas después)
        $totalProductos         = Producto::count();
        $totalPedidos           = Pedido::count();
        $productosStockBajo     = Inventario::whereColumn('stock', '<', 'stock_minimo')->count();

        // Lista de productos con menos stock (simula "próximos a caducar")
        $proximos = Inventario::with('producto')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $ingresosHoy = 0; // placeholder, luego lo puedes calcular con montos de pedidos

        return view('admin.dashboard', compact(
            'user',
            'totalProductos',
            'totalPedidos',
            'productosStockBajo',
            'proximos',
            'ingresosHoy'
        ));
    }
}
