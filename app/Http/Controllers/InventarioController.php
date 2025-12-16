<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    // ================================
    // INDEX: Mostrar todos los productos + stock
    // ================================
    public function index(Request $request)
    {
        $this->ensureAdminOperador();

        $q = $request->input('q');

        // Trae todos los productos, incluso los que no están en inventario
        $query = DB::table('productos as p')
            ->leftJoin('inventario as i', 'i.id_producto', '=', 'p.id_producto')
            ->leftJoin('categorias as c', 'c.id_categoria', '=', 'p.id_categoria')
            ->select(
                'p.id_producto',
                'p.nombre as producto_nombre',
                'c.nombre as categoria_nombre',
                DB::raw('IFNULL(i.stock, 0) as stock'),
                DB::raw('IFNULL(i.stock_minimo, 0) as stock_minimo')
            );

        if ($q) {
            $query->where('p.nombre', 'like', "%{$q}%");
        }

        $inventarios = $query
            ->orderBy('p.nombre', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('inventario.index', compact('inventarios'));
    }

    // ================================
    // EDIT: Editar o crear registro de stock
    // ================================
    public function edit($id_producto)
    {
        $this->ensureAdminOperador();

        $producto = DB::table('productos')->where('id_producto', $id_producto)->first();

        if (!$producto) {
            abort(404, 'Producto no encontrado');
        }

        $inventario = DB::table('inventario')
            ->where('id_producto', $id_producto)
            ->first();

        return view('inventario.edit', compact('producto', 'inventario'));
    }

    // ================================
    // UPDATE: Guardar cambios o crear registro
    // ================================
    public function update(Request $request, $id_producto)
    {
        $this->ensureAdminOperador();

        $data = $request->validate([
            'stock' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
        ]);

        $existe = DB::table('inventario')->where('id_producto', $id_producto)->exists();

        if ($existe) {
            DB::table('inventario')
                ->where('id_producto', $id_producto)
                ->update([
                    'stock' => $data['stock'],
                    'stock_minimo' => $data['stock_minimo'],
                ]);
        } else {
            DB::table('inventario')->insert([
                'id_producto' => $id_producto,
                'stock' => $data['stock'],
                'stock_minimo' => $data['stock_minimo'],
            ]);
        }

        return redirect()
            ->route('inventario.index')
            ->with('success', 'Inventario actualizado correctamente.');
    }

    // ================================
    // Helper para roles
    // ================================
    protected function ensureAdminOperador()
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Solo el personal del restaurante puede ver o modificar inventario.');
        }
    }
}
