<?php

namespace App\Http\Controllers;

use App\Models\Moto;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'motos' => Moto::paginate(8), // <-- ahora trae datos paginados
            'destacados' => Moto::inRandomOrder()->take(4)->get(),
            'nuevos' => Moto::latest()->take(4)->get(),
        ]);
    }
}
