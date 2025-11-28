<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    // Solo texto, SIN view()
    return 'Inicio VegGourmet';
});

// Ruta simple para probar que el controlador funciona
Route::get('/productos', [ProductoController::class, 'index']);
