<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    // Lista de ingredientes de la receta de un producto
    public function index(Producto $producto)
    {
        $producto->load('ingredientes.unidad');

        return view('recetas.index', compact('producto'));
    }

    // Formulario para agregar ingrediente a la receta
    public function create(Producto $producto)
    {
        $ingredientes = Ingrediente::with('unidad')
            ->orderBy('nombre')
            ->get();

        return view('recetas.create', compact('producto', 'ingredientes'));
    }

    // Guardar nuevo ingrediente de la receta
    public function store(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente',
            'cantidad'       => 'required|numeric|min:0.001',
        ]);

        // Evita duplicar: si ya existe, solo actualiza la cantidad
        $producto->ingredientes()->syncWithoutDetaching([
            $data['id_ingrediente'] => ['cantidad' => $data['cantidad']],
        ]);

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Ingrediente agregado/actualizado en la receta.');
    }

    // Editar la cantidad de un ingrediente de la receta
    public function edit(Producto $producto, Ingrediente $ingrediente)
    {
        // Traer la cantidad actual desde el pivot
        $pivot = $producto->ingredientes()
            ->where('ingredientes.id_ingrediente', $ingrediente->id_ingrediente)
            ->firstOrFail()
            ->pivot;

        return view('recetas.edit', [
            'producto'    => $producto,
            'ingrediente' => $ingrediente,
            'pivot'       => $pivot,
        ]);
    }

    // Actualizar la cantidad
    public function update(Request $request, Producto $producto, Ingrediente $ingrediente)
    {
        $data = $request->validate([
            'cantidad' => 'required|numeric|min:0.001',
        ]);

        $producto->ingredientes()
            ->updateExistingPivot($ingrediente->id_ingrediente, [
                'cantidad' => $data['cantidad'],
            ]);

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Cantidad actualizada correctamente.');
    }

    // Quitar un ingrediente de la receta
    public function destroy(Producto $producto, Ingrediente $ingrediente)
    {
        $producto->ingredientes()->detach($ingrediente->id_ingrediente);

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Ingrediente eliminado de la receta.');
    }
}