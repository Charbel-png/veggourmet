<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return 'Inicio VegGourmet';
});

// CRUD REST de productos
Route::resource('productos', ProductoController::class);
