<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\PedidoController;

// Inicio → redirige al dashboard del admin
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Dashboard admin → por ahora, lista de productos
Route::get('/admin/dashboard', [ProductoController::class, 'index'])
    ->name('admin.dashboard');

// CRUD de productos
Route::resource('productos', ProductoController::class);

Route::get('/pedidos',PedidoController::class);

// CRUD de clientes
Route::resource('clientes', ClienteController::class);

// Recetas anidadas dentro de productos (lo llenamos en la parte 2)
Route::prefix('productos/{producto}')->group(function () {
    Route::get('recetas',                 [RecetaController::class, 'index'])->name('recetas.index');
    Route::get('recetas/create',          [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('recetas',                [RecetaController::class, 'store'])->name('recetas.store');
    Route::get('recetas/{ingrediente}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('recetas/{ingrediente}',      [RecetaController::class, 'update'])->name('recetas.update');
    Route::delete('recetas/{ingrediente}',   [RecetaController::class, 'destroy'])->name('recetas.destroy');
});
