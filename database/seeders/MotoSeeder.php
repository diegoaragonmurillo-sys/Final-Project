<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moto;

class MotoSeeder extends Seeder
{
    public function run(): void
    {
        $motos = [
            [
                'nombre' => 'Bicimoto EcoRide',
                'modelo' => 'BR-200',
                'descripcion' => 'Bicimoto ligera ideal para ciudad.',
                'categoria' => 'bicimotos',
                'precio_unit' => 3500,
                'precio_mayor' => 3200,
                'cantidad_mayorista' => 5,
                'stock' => 10,
                'imagen' => 'bicimoto-eco.png'
            ],
            [
                'nombre' => 'E-Moto Volt XP',
                'modelo' => 'EV-500',
                'descripcion' => 'Moto eléctrica con autonomía de 70km.',
                'categoria' => 'motos-electricas',
                'precio_unit' => 6800,
                'precio_mayor' => 6400,
                'cantidad_mayorista' => 3,
                'stock' => 8,
                'imagen' => 'volt-xp.png'
            ],
            [
                'nombre' => 'Trimoto CargoMax',
                'modelo' => 'TR-750',
                'descripcion' => 'Trimoto ideal para carga pesada.',
                'categoria' => 'trimotos',
                'precio_unit' => 12000,
                'precio_mayor' => 11500,
                'cantidad_mayorista' => 2,
                'stock' => 4,
                'imagen' => 'trimoto-cargo.png'
            ],
        ];

        foreach ($motos as $moto) {
            Moto::create($moto);
        }
    }
}

