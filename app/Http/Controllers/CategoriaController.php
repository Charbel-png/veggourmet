<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403);
        }

        $categorias = Categoria::orderBy('nombre')->paginate(15);

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $categoria = new Categoria();

        return view('categorias.create', compact('categoria'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:80', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        Categoria::create($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        $user = auth()->user();
        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $user = auth()->user();
        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'nombre'      => [
                'required',
                'string',
                'max:80',
                'unique:categorias,nombre,' . $categoria->id_categoria . ',id_categoria',
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $categoria->update($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $user = auth()->user();
        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
