<?php

namespace App\Http\Controllers;

use App\Models\Moto;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            // 🔥 Promociones
            'motos' => Moto::whereNotNull('precio_unit')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8),

            // 🚚 Cargueros Eléctricos (solo TRIMOTOS)
            'destacados' => Moto::where('categoria', 'trimotos')
                                ->inRandomOrder()
                                ->take(4)
                                ->get(),

            // 🆕 Nuevos ingresos
            'nuevos' => Moto::latest()->take(4)->get(),
        ]);
    }
}
