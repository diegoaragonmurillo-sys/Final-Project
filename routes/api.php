<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Moto;

// --------------------------------
// 🔓 API pública del catálogo
// --------------------------------
Route::get('/motos', function () {
    return Moto::all();
});

// --------------------------------
// 🔐 API protegida para pedidos
// --------------------------------
Route::middleware('auth:sanctum')->get('/usuario', function (Request $request) {
    return $request->user();
});
