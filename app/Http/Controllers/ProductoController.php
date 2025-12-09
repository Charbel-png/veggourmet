<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    // GET /productos
    public function index()
    {
        $user = auth()->user();

       if (! $user || ! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para ver productos.');
        }

        $productos = Producto::with(['categoria', 'inventario'])
            ->orderBy('nombre')
            ->paginate(20);

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
            'nombre'       => 'required|string|max:120',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'descripcion'  => 'nullable|string|max:255',
            'estado'       => 'required|in:0,1',
            'descripcion'   => 'nullable|string|max:255',
        'imagen'        => 'nullable|string|max:255',
        'precio_venta'  => 'required|numeric|min:0',
        'stock'         => 'required|numeric|min:0',
        'stock_minimo'  => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {
        $producto = Producto::create([
            'nombre'       => $data['nombre'],
            'id_categoria' => $data['id_categoria'],
            'descripcion'  => $data['descripcion'] ?? null,
            'imagen'       => $data['imagen'] ?? null,
            'precio_venta' => $data['precio_venta'],
            // 'estado' se ajusta con el trigger según el stock
        ]);

        Inventario::create([
            'id_inventario' => $producto->id_producto,
            'stock'         => $data['stock'],
            'stock_minimo'  => $data['stock_minimo'],
        ]);
    });

    return redirect()->route('productos.index')
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
        'nombre'        => 'required|string|max:120',
        'id_categoria'  => 'required|exists:categorias,id_categoria',
        'descripcion'   => 'nullable|string|max:255',
        'imagen'        => 'nullable|string|max:255',
        'precio_venta'  => 'required|numeric|min:0',
        'stock'         => 'required|numeric|min:0',
        'stock_minimo'  => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($producto, $data) {
        $producto->update([
            'nombre'       => $data['nombre'],
            'id_categoria' => $data['id_categoria'],
            'descripcion'  => $data['descripcion'] ?? null,
            'imagen'       => $data['imagen'] ?? null,
            'precio_venta' => $data['precio_venta'],
        ]);

        $inv = $producto->inventario;
        if ($inv) {
            $inv->update([
                'stock'        => $data['stock'],
                'stock_minimo' => $data['stock_minimo'],
            ]);
        } else {
            Inventario::create([
                'id_inventario' => $producto->id_producto,
                'stock'         => $data['stock'],
                'stock_minimo'  => $data['stock_minimo'],
            ]);
        }
    });

    return redirect()->route('productos.index')
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
        $productos = Producto::with(['categoria', 'inventario'])
            ->where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        return view('cliente.productos', compact('productos', 'cart', 'total'));
    }
}
