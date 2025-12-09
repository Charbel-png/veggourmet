<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\RecetaController;

/*
|--------------------------------------------------------------------------
| Rutas públicas (sin iniciar sesión)
|--------------------------------------------------------------------------
*/

// Inicio -> redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Registro (cliente / operador / admin)
Route::get('/registro',  [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --------- Dashboards ---------
    // Admin y operador usan el mismo método, el controlador decide según el tipo
    Route::get('/admin/dashboard',    [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/operador/dashboard', [DashboardController::class, 'index'])->name('operador.dashboard');

    // Cliente -> siempre mandamos al catálogo
    Route::get('/cliente/dashboard', function () {
        return redirect()->route('cliente.productos');
    })->name('cliente.dashboard');

    // --------- Catálogo y carrito de cliente ---------

    // Catálogo de productos para cliente
    Route::get(
        '/cliente/productos',
        [ProductoController::class, 'catalogoCliente']
    )->name('cliente.productos');

    // Carrito del cliente
    Route::get(
        '/cliente/carrito',
        [CartController::class, 'index']
    )->name('cart.index');

    Route::post(
        '/cliente/carrito/agregar/{producto}',
        [CartController::class, 'add']
    )->name('cliente.carrito.add');

    Route::post(
        '/cliente/carrito/eliminar/{producto}',
        [CartController::class, 'remove']
    )->name('cliente.carrito.remove');

    Route::post(
        '/cliente/carrito/vaciar',
        [CartController::class, 'clear']
    )->name('cliente.carrito.clear');

    // --------- Solicitudes de acceso (solo admin, se valida en el controlador) ---------
    Route::get('/admin/solicitudes', [AdminUserController::class, 'index'])
        ->name('admin.solicitudes');

    Route::post('/admin/solicitudes/{user}/aprobar', [AdminUserController::class, 'aprobar'])
        ->name('admin.solicitudes.aprobar');

    Route::post('/admin/solicitudes/{user}/rechazar', [AdminUserController::class, 'rechazar'])
        ->name('admin.solicitudes.rechazar');

    // --------- CRUDs principales ---------
    Route::resource('productos',  ProductoController::class)->except(['show']);
    Route::resource('categorias', CategoriaController::class)->except(['show']);
    Route::resource('clientes',   ClienteController::class)->except(['show']);
    Route::resource('empleados',  EmpleadoController::class)->except(['show']);

    // Movimientos
    Route::resource('pedidos', PedidoController::class);
    Route::resource('compras', CompraController::class);

    // --------- Recetas por producto (rutas anidadas) ---------
    Route::prefix('productos/{producto}')->group(function () {
        Route::get('recetas',                    [RecetaController::class, 'index'])->name('recetas.index');
        Route::get('recetas/create',             [RecetaController::class, 'create'])->name('recetas.create');
        Route::post('recetas',                   [RecetaController::class, 'store'])->name('recetas.store');
        Route::get('recetas/{ingrediente}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
        Route::put('recetas/{ingrediente}',      [RecetaController::class, 'update'])->name('recetas.update');
        Route::delete('recetas/{ingrediente}',   [RecetaController::class, 'destroy'])->name('recetas.destroy');
    });
});
