<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // GET /productos
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('id_producto', 'ASC')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }

    // GET /productos/create
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.create', compact('categorias'));
    }

    // POST /productos
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'nombre'       => 'required|string|max:120|unique:productos,nombre',
            'descripcion'  => 'nullable|string|max:255',
            'estado'       => 'required|in:0,1',
        ]);

        Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    // GET /productos/{producto}/edit
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    // PUT /productos/{producto}
    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'nombre'       => 'required|string|max:120|unique:productos,nombre,' . $producto->id_producto . ',id_producto',
            'descripcion'  => 'nullable|string|max:255',
            'estado'       => 'required|in:0,1',
        ]);

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    // DELETE /productos/{producto}
    public function destroy(Producto $producto)
    {
        $producto->delete(); // ojo con FKs, si truena ya vemos borrar lógico

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
