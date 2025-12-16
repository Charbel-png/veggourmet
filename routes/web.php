<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClientePedidoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\InventarioController;

Route::get('/', function () {
    return redirect()->route('login');
});

// ------------------- Autenticación -------------------
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro',  [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------- Rutas protegidas -------------------
Route::middleware(['auth'])->group(function () {

    // Dashboards
    Route::get('/admin/dashboard',    [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/operador/dashboard', [DashboardController::class, 'index'])
        ->name('operador.dashboard');

    Route::get('/clientes/dashboard', function () {
        return redirect()->route('clientes.productos');
    })->name('clientes.dashboard');

    // ------------ Cliente: catálogo y carrito ------------
    Route::get('/clientes/productos', [ProductoController::class, 'catalogoCliente'])
        ->name('clientes.productos');

    Route::get('/clientes/carrito', [CartController::class, 'index'])
        ->name('clientes.carrito');

    Route::post('/clientes/carrito/agregar/{producto}', [CartController::class, 'add'])
        ->name('clientes.carrito.add');

    Route::post('/clientes/carrito/eliminar/{producto}', [CartController::class, 'remove'])
        ->name('clientes.carrito.remove');

    Route::post('/clientes/carrito/vaciar', [CartController::class, 'clear'])
        ->name('clientes.carrito.clear');

    Route::post('/clientes/carrito/confirmar', [CartController::class, 'confirm'])
        ->name('clientes.carrito.confirmar');

    // ----------- Historial de pedidos del cliente -----------
    Route::get('/clientes/pedidos', [ClientePedidoController::class, 'index'])
        ->name('clientes.pedidos.index');

    Route::get('/clientes/pedidos/{pedido}', [ClientePedidoController::class, 'show'])
        ->name('clientes.pedidos.show');

    Route::post('/clientes/pedidos/{pedido}/cancelar', [ClientePedidoController::class, 'cancelar'])
        ->name('clientes.pedidos.cancelar');

    // ------------ Inventario (solo listar / editar) ------------
    Route::resource('inventario', InventarioController::class)
        ->only(['index', 'edit', 'update']);

    // ------------ Solicitudes de acceso (admin) ------------
    Route::get('/admin/solicitudes', [AdminUserController::class, 'index'])
        ->name('admin.solicitudes');

    Route::post('/admin/solicitudes/{user}/aprobar', [AdminUserController::class, 'aprobar'])
        ->name('admin.solicitudes.aprobar');

    Route::post('/admin/solicitudes/{user}/rechazar', [AdminUserController::class, 'rechazar'])
        ->name('admin.solicitudes.rechazar');

    // ------------ CRUDs principales ------------
    Route::resource('productos',  ProductoController::class)->except(['show']);
    Route::resource('categorias', CategoriaController::class)->except(['show']);
    Route::resource('clientes',   ClienteController::class)->except(['show']);

    Route::resource('empleados',  EmpleadoController::class)->except(['show']);
    Route::patch('/empleados/{empleado}/aprobar', [EmpleadoController::class, 'aprobar'])
        ->name('empleados.aprobar');
    Route::patch('/empleados/{empleado}/rechazar', [EmpleadoController::class, 'rechazar'])
        ->name('empleados.rechazar');

    // ------------ Pedidos (admin / operador) ------------
    Route::resource('pedidos', PedidoController::class);

    // Cambiar estado de un pedido (CANCELAR, ENVIADO, DEVUELTO, etc.)
    // Cambiar estado de un pedido (admin / operador)
    Route::post('/pedidos/{id}/estado', [PedidoController::class, 'updateEstado'])
        ->name('pedidos.estado');

    // Movimientos de compras
    Route::resource('compras', CompraController::class);

    // ------------ Recetas por producto ------------
    Route::prefix('productos/{producto}')->group(function () {
        Route::get('recetas',                    [RecetaController::class, 'index'])->name('recetas.index');
        Route::get('recetas/create',             [RecetaController::class, 'create'])->name('recetas.create');
        Route::post('recetas',                   [RecetaController::class, 'store'])->name('recetas.store');
        Route::get('recetas/{ingrediente}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
        Route::put('recetas/{ingrediente}',      [RecetaController::class, 'update'])->name('recetas.update');
        Route::delete('recetas/{ingrediente}',   [RecetaController::class, 'destroy'])->name('recetas.destroy');
    });
});
