<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;


// 🏠 Página principal
Route::get('/', function () {
    return view('home');
})->name('home');


// 🛵 Catálogo de motos
Route::get('/motos', [MotoController::class, 'index'])->name('motos.index');
Route::get('/motos/{moto}', [MotoController::class, 'show'])->name('motos.show');


// 🛒 Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

// 🔥 Ruta correcta para agregar producto con variante
Route::get('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');

// Eliminar artículo del carrito
Route::get('/carrito/eliminar/{key}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');


// 🔐 Rutas protegidas (requieren login)
Route::middleware(['auth'])->group(function () {
    Route::get('/orden/confirmar', [OrderController::class, 'confirmar'])->name('orden.confirmar');
});


// ⚙️ Panel administrativo (solo administradores)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    Route::resource('/admin/motos', MotoController::class)->except(['index','show']);
});

Route::get('/carrito/actualizar/{key}/{accion}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');

Route::get('/favorito/{moto}', [MotoController::class, 'favorito'])->name('moto.favorito');

Route::post('/motos/{moto}/review', [MotoController::class,'review'])->name('moto.review');

Route::post('/motos/{moto}/review', [MotoController::class, 'review'])->name('moto.review')->middleware('auth');

// 🛒 Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/actualizar/{key}/{accion}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::get('/carrito/eliminar/{key}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// 🆕 ESTA RUTA ES LA QUE FALTABA
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

Route::get('/moto/{moto}/favorito', [MotoController::class, 'favorito'])->name('moto.favorito');
Route::get('/favoritos', function () {
    $favoritos = session('favoritos', []);
    $motos = \App\Models\Moto::whereIn('id', $favoritos)->get();

    return view('motos.favoritos', compact('motos'));
})->name('favoritos.index');

Route::middleware('auth')->group(function() {
    Route::post('/favorito/{moto}', [FavoriteController::class, 'toggle'])->name('favorito.toggle');
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favoritos.index');
});

Route::middleware('auth')->group(function() {
    Route::post('/favorito/{moto}', [FavoriteController::class, 'toggle'])->name('favorito.toggle');
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favoritos.index');
});

// Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar/{moto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// 🔥 Nueva ruta para sumar/restar cantidad
Route::get('/carrito/actualizar/{id}/{accion}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');

// Vaciar carrito
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

// 🔑 Rutas de autenticación Breeze
require __DIR__.'/auth.php';
