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
use App\Http\Controllers\AdminPedidoController;


/* ================================
| 🏠 HOME
================================ */
Route::get('/', [HomeController::class, 'index'])->name('home');


/* ================================
| 🛵 CATÁLOGO PÚBLICO
================================ */


// Detalle del producto (lleva a detalle.blade.php)
Route::get('/motos/detalle/{moto}', [MotoPublicController::class, 'show'])->name('motos.show');


/* ================================
| ⭐ REVIEWS (NECESITA LOGIN)
================================ */
Route::middleware('auth')
    ->post('/motos/{moto}/review', [MotoPublicController::class, 'review'])
    ->name('moto.review');


/* ================================
| 📂 CATEGORÍAS LEGACY (REDIRECCIÓN)
================================ */
// Para que URLs antiguas como /categoria/bicimotos sigan funcionando
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
| 🔧 ADMIN PANEL
================================ */
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('motos', AdminMoto::class);
    Route::resource('pedidos', PedidoController::class)->only(['index', 'show']);

    Route::resource('cupones', CuponController::class)->parameters([
        'cupones' => 'cupon'
    ]);

    Route::resource('usuarios', UsuarioController::class)->only(['index']);
    Route::resource('sedes', SedeController::class)->except(['create', 'edit', 'show']);

    Route::get('/config/redes', [ConfigController::class, 'redes'])->name('config.redes');
    Route::post('/config/redes', [ConfigController::class, 'updateRedes'])->name('config.redes.update');

    Route::get('/config/pagos', [ConfigController::class, 'pagos'])->name('config.pagos');
    Route::post('/config/pagos', [ConfigController::class, 'updatePagos'])->name('config.pagos.update');
});


/* ================================
| 🔐 AUTH (Breeze/Fortify)
================================ */
require __DIR__.'/auth.php';

Route::get('/dashboard', fn() =>
    auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home')
)->middleware(['auth'])->name('dashboard');

/* ================================
| 🛵 CATÁLOGO PÚBLICO
================================ */

// Catálogo general
Route::get('/motos', [MotoPublicController::class, 'index'])->name('motos.index');

// Catálogo por categoría o subcategoría
Route::get('/motos/categoria/{categoria}', [MotoPublicController::class, 'catalog'])->name('motos.categoria');

// Detalle del producto
Route::get('/motos/detalle/{moto}', [MotoPublicController::class, 'show'])->name('motos.show');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('admin.pedidos.index');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('admin.pedidos.show');
});

Route::get('/reset-carrito', function () {
    session()->forget(['carrito', 'cupon', 'cupon_data']);
    return "Carrito reseteado ✔";
});

Route::middleware(['auth'])->group(function () {

    Route::get('/mis-pedidos', [PedidoController::class, 'index'])
        ->name('perfil.pedidos');
});

Route::middleware(['auth'])->group(function () {
    
    Route::post('/admin/pedidos/{pedido}/estado', [AdminPedidoController::class, 'actualizarEstado'])
        ->name('admin.pedidos.estado');

});

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('admin.pedidos.index');

    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('admin.pedidos.show');

    Route::post('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])
        ->name('admin.pedidos.estado');

});

Route::delete('/admin/pedidos/{pedido}', [PedidoController::class, 'destroy'])
    ->name('admin.pedidos.destroy');

Route::middleware('auth')->get('/mis-pedidos', function () {
    $pedidos = auth()->user()->pedidos()->latest()->get();
    return view('perfil.pedidos', compact('pedidos'));
})->name('perfil.pedidos');

Route::get('/pedido/{pedido}', function(App\Models\Pedido $pedido){
    abort_if($pedido->user_id !== auth()->id(), 403);
    return view('pedidos.detalle', compact('pedido'));
})->middleware('auth')->name('orden.detalle');

Route::get('/pedido/{pedido}', function(App\Models\Pedido $pedido){
    abort_if($pedido->user_id !== auth()->id(), 403);
    return view('pedidos.detalle', compact('pedido'));
})->middleware('auth')->name('orden.detalle');
