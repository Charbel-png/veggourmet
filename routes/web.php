<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\ProveedorController;
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

// Página de login (incluye el formulario de registro de cliente)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Procesar login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Procesar registro de cliente (el formulario está en la misma vista que login)
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren estar autenticado)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboards según tipo (la lógica de tipo se valida dentro de los controladores)
    Route::get('/admin/dashboard', [ProductoController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/operador/dashboard', [ProductoController::class, 'index'])
        ->name('operador.dashboard');

    Route::get('/cliente/dashboard', function () {
        // Siempre mandamos al catálogo de productos del cliente
        return redirect()->route('cliente.productos');
    })->name('cliente.dashboard');

    // Catálogo de productos para cliente
    Route::get('/cliente/productos', [ProductoController::class, 'catalogoCliente'])
        ->name('cliente.productos');

        // Formulario para crear operador (solo admin)
    Route::get('/admin/operadores/nuevo', [AuthController::class, 'showOperatorForm'])
        ->name('operadores.create');

    // Guardar nuevo operador (solo admin)
    Route::post('/admin/operadores', [AuthController::class, 'storeOperator'])
        ->name('operadores.store');

    // ---------------- CRUDs principales (admin / operador) ----------------
    // La validación de tipo ('admin', 'operador', 'cliente') la haces dentro
    // de cada método del controlador con auth()->user()->tipo

    Route::resource('productos',    ProductoController::class);
    Route::resource('categorias',   CategoriaController::class)->except(['show']);
    Route::resource('ingredientes', IngredienteController::class);
    Route::resource('proveedores',  ProveedorController::class)->except(['show']);
    Route::resource('clientes',     ClienteController::class)->except(['show']);
    Route::resource('empleados',    EmpleadoController::class)->except(['show']);

    // Movimientos
    Route::resource('pedidos', PedidoController::class);
    Route::resource('compras', CompraController::class);

    // ---------------- Recetas por producto (rutas anidadas) ----------------
    Route::prefix('productos/{producto}')->group(function () {
        Route::get('recetas',                    [RecetaController::class, 'index'])->name('recetas.index');
        Route::get('recetas/create',             [RecetaController::class, 'create'])->name('recetas.create');
        Route::post('recetas',                   [RecetaController::class, 'store'])->name('recetas.store');
        Route::get('recetas/{ingrediente}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
        Route::put('recetas/{ingrediente}',      [RecetaController::class, 'update'])->name('recetas.update');
        Route::delete('recetas/{ingrediente}',   [RecetaController::class, 'destroy'])->name('recetas.destroy');
    });
});
