<?php

namespace App\Http\Controllers;

use App\Models\Moto;

class MotoPublicController extends Controller
{
    public function show(Moto $moto)
    {
        return view('motos.detalle', compact('moto'));
    }
}
