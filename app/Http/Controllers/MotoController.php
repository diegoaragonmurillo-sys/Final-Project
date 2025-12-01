<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotoPublicController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MotoController as AdminMoto;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\CuponController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\SedeController;
use App\Http\Controllers\Admin\ConfigController;


/* ================================
| 🏠 HOME
================================ */
Route::get('/', [HomeController::class, 'index'])->name('home');


/* ================================
| 🛵 CATÁLOGO PÚBLICO
================================ */

// Catálogo general
Route::get('/motos', [MotoPublicController::class, 'catalog'])->name('motos.index');

// Catálogo filtrado por categoría(Subcategoría incluida)
Route::get('/motos/categoria/{categoria}', [MotoPublicController::class, 'catalog'])->name('motos.categoria');

// Detalle del producto
Route::get('/motos/detalle/{moto}', [MotoPublicController::class, 'show'])->name('motos.show');


/* ================================
| ⭐ REVIEWS (NECESITA LOGIN)
================================ */
Route::middleware('auth')
    ->post('/motos/{moto}/review', [MotoPublicController::class, 'review'])
    ->name('moto.review');


/* ================================
| 📂 CATEGORÍAS LEGACY
================================ */
Route::get('/categoria/{categoria}', fn($categoria) =>
    redirect()->route('motos.categoria', $categoria)
);


/* ================================
| ❤️ FAVORITOS
================================ */
Route::middleware('auth')->group(function () {
    Route::post('/favorito/{moto}', [FavoriteController::class, 'toggle'])->name('favorito.toggle');
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favoritos.index');
});


/* ================================
| 🛒 CARRITO
================================ */
Route::prefix('carrito')->group(function () {
    Route::get('/', [CarritoController::class, 'index'])->name('carrito.index');
    Route::get('/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/actualizar/{key}/{accion}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::get('/eliminar/{key}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::get('/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
});


/* ================================
| 📦 ÓRDENES
================================ */
Route::middleware('auth')->get('/orden/confirmar', [OrderController::class, 'confirmar'])->name('orden.confirmar');


/* ================================
| 🔧 PANEL ADMIN
================================ */
Route::prefix('admin')->middleware(['auth','is_admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('motos', AdminMoto::class);
    Route::resource('pedidos', PedidoController::class)->only(['index','show']);

    Route::resource('cupones', CuponController::class)->parameters(['cupones'=>'cupon']);

    Route::resource('usuarios', UsuarioController::class)->only(['index']);
    Route::resource('sedes', SedeController::class)->except(['create','edit','show']);

    Route::get('/config/redes', [ConfigController::class, 'redes'])->name('config.redes');
    Route::post('/config/redes', [ConfigController::class, 'updateRedes'])->name('config.redes.update');

    Route::get('/config/pagos', [ConfigController::class, 'pagos'])->name('config.pagos');
    Route::post('/config/pagos', [ConfigController::class, 'updatePagos'])->name('config.pagos.update');
});


/* ================================
| 🔐 AUTH
================================ */
require __DIR__.'/auth.php';

Route::get('/dashboard', fn() =>
    auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home')
)->middleware(['auth'])->name('dashboard');
