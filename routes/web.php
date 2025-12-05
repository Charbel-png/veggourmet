<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\RecetaController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/admin/dashboard', [ProductoController::class, 'index'])
    ->name('admin.dashboard');

Route::resource('productos', ProductoController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('pedidos', PedidoController::class);  // 👈 SOLO ESTA para pedidos

Route::prefix('productos/{producto}')->group(function () {
    Route::get('recetas',                 [RecetaController::class, 'index'])->name('recetas.index');
    Route::get('recetas/create',          [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('recetas',                [RecetaController::class, 'store'])->name('recetas.store');
    Route::get('recetas/{ingrediente}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('recetas/{ingrediente}',      [RecetaController::class, 'update'])->name('recetas.update');
    Route::delete('recetas/{ingrediente}',   [RecetaController::class, 'destroy'])->name('recetas.destroy');
});