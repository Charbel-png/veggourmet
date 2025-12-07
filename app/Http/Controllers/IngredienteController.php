<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    // GET /ingredientes
    public function index()
    {
        $ingredientes = Ingrediente::with('unidad')
            ->orderBy('nombre')
            ->paginate(10);

        return view('ingredientes.index', compact('ingredientes'));
    }

    // GET /ingredientes/create
    public function create()
    {
        $unidades = UnidadMedida::orderBy('nombre')->get();

        return view('ingredientes.create', compact('unidades'));
    }

    // POST /ingredientes
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:120',
            'id_unidad' => 'required|exists:unidades_medida,id_unidad',
            'activo'    => 'required|in:0,1',
        ]);

        Ingrediente::create($data);

        return redirect()
            ->route('ingredientes.index')
            ->with('success', 'Ingrediente creado correctamente.');
    }

    // GET /ingredientes/{ingrediente}/edit
    public function edit(Ingrediente $ingrediente)
    {
        $unidades = UnidadMedida::orderBy('nombre')->get();

        return view('ingredientes.edit', compact('ingrediente', 'unidades'));
    }

    // PUT /ingredientes/{ingrediente}
    public function update(Request $request, Ingrediente $ingrediente)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:120',
            'id_unidad' => 'required|exists:unidades_medida,id_unidad',
            'activo'    => 'required|in:0,1',
        ]);

        $ingrediente->update($data);

        return redirect()
            ->route('ingredientes.index')
            ->with('success', 'Ingrediente actualizado correctamente.');
    }

    // DELETE /ingredientes/{ingrediente}
    public function destroy(Ingrediente $ingrediente)
    {
        $ingrediente->delete();

        return redirect()
            ->route('ingredientes.index')
            ->with('success', 'Ingrediente eliminado correctamente.');
    }
}
