<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        // El carrito solo se puede usar estando autenticado
        $this->middleware('auth');
    }

    /**
     * Mostrar el carrito del cliente.
     */
    public function index()
    {
        // Obtenemos el carrito desde la sesión
        $cart = session('cart', []);

        // Total del carrito
        $total = collect($cart)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });

        // Vista sugerida: resources/views/cliente/carrito.blade.php
        return view('clientes.carrito', compact('cart', 'total'));
    }

    /**
     * Añadir un producto al carrito.
     */
    public function add(Request $request, Producto $producto)
    {
        $cantidad = max(1, (int) $request->input('cantidad', 1));

        $cart = session('cart', []);

        // Ajusta si tu PK tiene otro nombre, pero por lo que has mostrado es id_producto
        $id = $producto->id_producto;

        if (isset($cart[$id])) {
            // Si ya existe en el carrito, sumamos cantidad
            $cart[$id]['cantidad'] += $cantidad;
        } else {
            // Nuevo ítem
            $cart[$id] = [
                'id'       => $id,
                'nombre'   => $producto->nombre,
                // Cambia "precio_venta" si tu columna se llama diferente
                'precio'   => $producto->precio_venta ?? 0,
                'cantidad' => $cantidad,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Eliminar un producto puntual del carrito.
     */
    public function remove(Producto $producto)
    {
        $cart = session('cart', []);
        $id   = $producto->id_producto;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vaciar todo el carrito.
     */
    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Carrito vaciado.');
    }
}
