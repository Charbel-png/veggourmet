<?php

namespace App\Http\Controllers;

use App\Models\Producto;    // 👈 importante
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Ya NO regresamos el texto:
        // return 'Hola desde index de productos';

        // Traer todos los productos de la BD
        $productos = Producto::all();

        // Enviar los productos a la vista productos/index.blade.php
        return view('productos.index', compact('productos'));
    }
}
