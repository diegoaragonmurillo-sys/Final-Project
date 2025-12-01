<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moto;
use App\Models\MotoVariante;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        $variantes = [
            ['color_nombre' => 'Negro', 'color_hex' => '#000000', 'imagen' => 'variantes/negro.jpg'],
            ['color_nombre' => 'Rojo', 'color_hex' => '#FF0000', 'imagen' => 'variantes/rojo.jpg'],
            ['color_nombre' => 'Azul', 'color_hex' => '#0000FF', 'imagen' => 'variantes/azul.jpg'],
        ];

        // Asignar variantes automáticamente a cada moto existente
        foreach (Moto::all() as $moto) {
            foreach ($variantes as $v) {
                MotoVariante::create([
                    'moto_id'      => $moto->id,
                    'color_nombre' => $v['color_nombre'],
                    'color_hex'    => $v['color_hex'],
                    'imagen'       => $v['imagen'],
                ]);
            }
        }
    }
}
