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
        $user = auth()->user();
        if (!in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $productos = Producto::with('categoria')
            ->where('estado', 1)          // 👈 solo activos
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.index', compact('productos'));
    }
    // GET /productos/create
    public function create()
    {
        $user=auth()->user();
        if(!in_array($user->tipo,['admin','operador']))
        {
            abort(403,'Acceso restringido');
        }
        $categorias = Categoria::orderBy('nombre')->get();
        $producto   = new Producto(); // objeto vacío para el form

        return view('productos.create', compact('categorias', 'producto'));
    }

    // POST /productos
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria', // 👈 categorias
            'nombre'       => 'required|string|max:120',
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
        $user=auth()->user();
        if(!in_array($user->tipo,['admin','operador']))
        {
            abort(403,'Acceso restringido');
        }
        $categorias = Categoria::orderBy('nombre')->get();

        // OJO: aquí debe ser 'categorias', no 'categororias'
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // PUT /productos/{producto}
    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria', // 👈 categorias
            'nombre'       => 'required|string|max:120',
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
        $user = auth()->user();
        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede eliminar registros.');
        }

        // BAJA LÓGICA: no se borra, solo se marca como inactivo
        $producto->estado = 0;
        $producto->save();   // 👈 aquí MySQL actualiza automáticamente `actualizado_en`

        return redirect()->route('productos.index')
            ->with('success', 'Producto dado de baja correctamente.');
    }
    public function catalogoCliente()
    {
        $user = auth()->user();
        if ($user->tipo !== 'cliente') {
            abort(403, 'No tienes permisos para ver el catálogo de cliente.');
        }

        $productos = Producto::where('estado', 1)->paginate(12);

        return view('clientes.productos', compact('productos'));
    }
}
