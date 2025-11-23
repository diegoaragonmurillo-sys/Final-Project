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


// 🔑 Rutas de autenticación Breeze
require __DIR__.'/auth.php';
