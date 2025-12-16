<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    // GET /productos
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para ver productos.');
        }

        $query = Producto::with(['categoria', 'inventario']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                  ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }

        $productos = $query
            ->orderBy('nombre')
            ->paginate(20);

        return view('productos.index', compact('productos'));
    }

    // GET /productos/create
    public function create()
    {
        $user = auth()->user();
        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Acceso restringido');
        }

        $categorias = Categoria::orderBy('nombre')->get();
        $producto   = new Producto(); // objeto vacío para el form

        return view('productos.create', compact('categorias', 'producto'));
    }

    // POST /productos
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Acceso restringido');
        }

        $data = $request->validate([
            'id_categoria'   => ['required', 'exists:categorias,id_categoria'],
            'nombre'         => ['required', 'string', 'max:120'],
            'descripcion'    => ['nullable', 'string'],
            'precio_venta'   => ['required', 'numeric', 'min:0'],
            'estado'         => ['required', 'boolean'],
            // opcional: URL o ruta escrita a mano
            'imagen'         => ['nullable', 'string', 'max:255'],
            // archivo subido (para que salga el botón EXAMINAR)
            'imagen_archivo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // 1) Ruta base (lo que haya en el campo de texto)
        $rutaImagen = $data['imagen'] ?? null;

        // 2) Si suben archivo, tiene prioridad
        if ($request->hasFile('imagen_archivo')) {
            $file = $request->file('imagen_archivo');

            // nombre único sencillo
            $filename = time() . '_' . $file->getClientOriginalName();

            // se guarda en public/img/productos
            $file->move(public_path('img/productos'), $filename);

            // esto es lo que se guarda en la BD
            $rutaImagen = 'img/productos/' . $filename;
        }

        Producto::create([
            'id_categoria' => $data['id_categoria'],
            'nombre'       => $data['nombre'],
            'descripcion'  => $data['descripcion'] ?? null,
            'precio_venta' => $data['precio_venta'],
            'estado'       => $data['estado'],
            'imagen'       => $rutaImagen,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    // GET /productos/{producto}/edit
    public function edit(Producto $producto)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Acceso restringido');
        }

        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    // PUT /productos/{producto}
    public function update(Request $request, Producto $producto)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'Acceso restringido');
        }

        $data = $request->validate([
            'nombre'         => ['required', 'string', 'max:120'],
            'id_categoria'   => ['required', 'exists:categorias,id_categoria'],
            'descripcion'    => ['nullable', 'string', 'max:255'],
            'imagen'         => ['nullable', 'string', 'max:255'],  // URL o ruta manual
            'precio_venta'   => ['required', 'numeric', 'min:0'],
            'estado'         => ['required', 'boolean'],
            'imagen_archivo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // Ruta base: lo que venga en el campo de texto o lo que ya tenía
        $rutaImagen = $data['imagen'] ?? $producto->imagen;

        // Si suben un archivo nuevo, sustituye a lo anterior
        if ($request->hasFile('imagen_archivo')) {
            $file = $request->file('imagen_archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/productos'), $filename);

            $rutaImagen = 'img/productos/' . $filename;
        }

        $producto->update([
            'nombre'       => $data['nombre'],
            'id_categoria' => $data['id_categoria'],
            'descripcion'  => $data['descripcion'] ?? null,
            'precio_venta' => $data['precio_venta'],
            'estado'       => $data['estado'],
            'imagen'       => $rutaImagen,
        ]);

        // OJO: aquí ya NO tocamos inventario, solo se ve; el stock se edita en Inventario

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    // DELETE /productos/{producto}
    public function destroy(Producto $producto)
    {
        $user = auth()->user();
        if (!$user || $user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede eliminar registros.');
        }

        // Baja lógica: solo se marca inactivo
        $producto->estado = 0;
        $producto->save();

        return redirect()->route('productos.index')
            ->with('success', 'Producto dado de baja correctamente.');
    }

    // Catálogo para cliente
    public function catalogoCliente()
    {
        $productos = Producto::with(['categoria', 'inventario'])
            ->where('estado', 1) // solo activos
            ->orderBy('nombre')
            ->get();

        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['precio'] * $item['cantidad']);

        return view('clientes.productos', compact('productos', 'cart', 'total'));
    }
}
