<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// -----------------------------
// 🌍 Rutas públicas (sin login)
// -----------------------------

Route::get('/', function () {
    return redirect('/motos');
})->name('home');

Route::get('/motos', [MotoController::class, 'index'])->name('motos.index');
Route::get('/motos/{moto}', [MotoController::class, 'show'])->name('motos.show');

// -----------------------------
// 🛒 CARRITO (sesiones)
// -----------------------------

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar/{moto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// -----------------------------
// 🔐 Rutas protegidas con login
// -----------------------------

Route::middleware(['auth'])->group(function () {

    // Finalizar compra
    Route::get('/orden/confirmar', [OrderController::class, 'confirmar'])->name('orden.confirmar');

    // Dashboard simple para usuario
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');
});

// -----------------------------
// ⚙️ Rutas ADMIN
// -----------------------------

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Panel de administración
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');

    // CRUD de motos (excepto mostrar y listar pública)
    Route::resource('/admin/motos', MotoController::class)->except(['index','show']);
});

// -----------------------------
// 🔑 Autenticación (Breeze / UI)
// -----------------------------

require __DIR__.'/auth.php';
