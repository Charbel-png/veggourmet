<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Listado de inventario.
     */
    public function index(Request $request)
    {
        // Consultamos inventario junto con el producto y su categoría
        $query = Inventario::with(['producto.categoria']);

        // Filtro por texto (nombre del producto)
        if ($request->filled('q')) {
            $busqueda = $request->input('q');
            $query->whereHas('producto', function ($q2) use ($busqueda) {
                $q2->where('nombre', 'like', "%{$busqueda}%");
            });
        }

        $inventarios = $query
            ->orderBy('stock', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('inventario.index', compact('inventarios'));
    }

    /**
     * Formulario para editar stock / stock mínimo.
     */
    public function edit(Inventario $inventario)
    {
        // $inventario ya viene con el registro
        $inventario->load('producto');

        return view('inventario.edit', compact('inventario'));
    }

    /**
     * Actualizar inventario.
     */
    public function update(Request $request, Inventario $inventario)
    {
        $data = $request->validate([
            'stock'        => ['required', 'numeric', 'min:0'],
            'stock_minimo' => ['required', 'numeric', 'min:0'],
        ]);

        $inventario->update($data);

        return redirect()
            ->route('inventario.index')
            ->with('success', 'Inventario actualizado correctamente.');
    }
}
