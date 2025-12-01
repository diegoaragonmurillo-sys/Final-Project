<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// ======================================
// 🌍 RUTAS PÚBLICAS (SIN LOGIN)
// ======================================

// Home → redirige al catálogo
Route::get('/', function () {
    return redirect('/motos');
})->name('home');

// Catálogo público
Route::get('/motos', [MotoController::class, 'index'])->name('motos.index');
Route::get('/motos/{moto}', [MotoController::class, 'show'])->name('motos.show');


// ======================================
// 🛒 CARRITO
// ======================================

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar/{moto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');


// ======================================
// 🔐 USUARIOS CON LOGIN
// ======================================

Route::middleware(['auth'])->group(function () {

    // Confirmar pedido / checkout
    Route::get('/orden/confirmar', [OrderController::class, 'confirmar'])->name('orden.confirmar');

    // Vista básica del usuario normal
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');
});


// ======================================
// ⚙️ PANEL ADMINISTRADOR
// ======================================

// 🔥 Aquí entra solo si `is_admin = 1`
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Gestión de motos (CRUD interno)
    Route::resource('motos', MotoController::class)->except(['index','show']);

    // Gestión de pedidos
    Route::get('/pedidos', [OrderController::class, 'index'])->name('admin.pedidos');
});


// ======================================
// 🔑 AUTENTICACIÓN DE LARAVEL BREEZE
// ======================================

require __DIR__.'/auth.php';
