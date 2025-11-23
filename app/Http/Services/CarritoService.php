<?php

namespace App\Http\Services;

use App\Models\Moto;

class CarritoService
{
    public static function add(Moto $moto)
    {
        $carrito = session()->get('carrito', []);

        $carrito[$moto->id] = [
            'nombre'    => $moto->nombre,
            'precio'    => $moto->precio_unit,
            'cantidad'  => ($carrito[$moto->id]['cantidad'] ?? 0) + 1
        ];

        session()->put('carrito', $carrito);
    }

    public static function remove($id)
    {
        $carrito = session()->get('carrito', []);

        unset($carrito[$id]);

        session()->put('carrito', $carrito);
    }
}
