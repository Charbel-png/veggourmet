<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Receta;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecetaController extends Controller
{
    // GET /productos/{producto}/recetas
    public function index(Producto $producto)
    {
        $recetas = Receta::with('ingrediente')
            ->where('id_producto', $producto->id_producto)
            ->orderBy('id_ingrediente')
            ->get();

        return view('recetas.index', compact('producto', 'recetas'));
    }

    // GET /productos/{producto}/recetas/create
    public function create(Producto $producto)
    {
        $ingredientes = Ingrediente::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        return view('recetas.create', compact('producto', 'ingredientes'));
    }

    // POST /productos/{producto}/recetas
    public function store(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'id_ingrediente' => [
                'required',
                'exists:ingredientes,id_ingrediente',
                // evitar duplicar ingrediente para el mismo producto
                Rule::unique('recetas')->where(function ($q) use ($producto) {
                    return $q->where('id_producto', $producto->id_producto);
                }),
            ],
            'cantidad' => 'required|numeric|min:0.001',
        ], [
            'id_ingrediente.unique' => 'Ese ingrediente ya forma parte de la receta de este producto.',
        ]);

        $data['id_producto'] = $producto->id_producto;

        Receta::create($data);

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Ingrediente agregado a la receta.');
    }

    // GET /productos/{producto}/recetas/{ingrediente}/edit
    public function edit(Producto $producto, $ingrediente)
    {
        $receta = Receta::where('id_producto', $producto->id_producto)
            ->where('id_ingrediente', $ingrediente)
            ->firstOrFail();

        $ingredienteModel = Ingrediente::findOrFail($ingrediente);

        return view('recetas.edit', [
            'producto'    => $producto,
            'receta'      => $receta,
            'ingrediente' => $ingredienteModel,
        ]);
    }

    // PUT /productos/{producto}/recetas/{ingrediente}
    public function update(Request $request, Producto $producto, $ingrediente)
    {
        $receta = Receta::where('id_producto', $producto->id_producto)
            ->where('id_ingrediente', $ingrediente)
            ->firstOrFail();

        $data = $request->validate([
            'cantidad' => 'required|numeric|min:0.001',
        ]);

        $receta->update($data);

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Cantidad actualizada correctamente.');
    }

    // DELETE /productos/{producto}/recetas/{ingrediente}
    public function destroy(Producto $producto, $ingrediente)
    {
        Receta::where('id_producto', $producto->id_producto)
            ->where('id_ingrediente', $ingrediente)
            ->delete();

        return redirect()
            ->route('recetas.index', $producto)
            ->with('success', 'Ingrediente eliminado de la receta.');
    }
}
