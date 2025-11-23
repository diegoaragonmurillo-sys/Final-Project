<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moto;
use App\Models\MotoVariante;

class MotoSeeder extends Seeder
{
    public function run(): void
    {
        // === PROD 1 ===
        $moto1 = Moto::create([
            'nombre' => 'TRIMOTO ELECTRICA',
            'modelo' => 'IMPORT-01',
            'descripcion' => 'Trimoto eléctrica modelo IMPORT-01, 1000W con grafeno superior.',
            'precio_unit' => 3500.00,
            'precio_mayor' => 2700.00,
            'imagen' => 'prod1.jpg'
        ]);

        MotoVariante::insert([
            ['moto_id' => $moto1->id, 'color_nombre' => 'Rojo', 'color_hex' => '#b80000', 'imagen' => 'prod1-red.jpg'],
            ['moto_id' => $moto1->id, 'color_nombre' => 'Negro', 'color_hex' => '#000000', 'imagen' => 'prod1-black.jpg'],
            ['moto_id' => $moto1->id, 'color_nombre' => 'Plomo', 'color_hex' => '#737373', 'imagen' => 'prod1-gray.jpg'],
        ]);

        // === PROD 2 ===
        $moto2 = Moto::create([
            'nombre' => 'TRIMOTO ELECTRICA',
            'modelo' => 'IMPORT-02',
            'descripcion' => 'Trimoto eléctrica modelo IMPORT-02.',
            'precio_unit' => 4100.00,
            'precio_mayor' => 3300.00,
            'imagen' => 'prod2.jpg'
        ]);

        MotoVariante::insert([
            ['moto_id' => $moto2->id, 'color_nombre' => 'Rojo', 'color_hex' => '#b80000', 'imagen' => 'prod2-red.jpg'],
            ['moto_id' => $moto2->id, 'color_nombre' => 'Negro', 'color_hex' => '#000000', 'imagen' => 'prod2-black.jpg'],
            ['moto_id' => $moto2->id, 'color_nombre' => 'Verde', 'color_hex' => '#1a8d43', 'imagen' => 'prod2-green.jpg'],
            ['moto_id' => $moto2->id, 'color_nombre' => 'Beige', 'color_hex' => '#d7c9a5', 'imagen' => 'prod2-beige.jpg'],
            ['moto_id' => $moto2->id, 'color_nombre' => 'Blanco', 'color_hex' => '#ffffff', 'imagen' => 'prod2-white.jpg'],
        ]);

        // === PROD 3 ===
        $moto3 = Moto::create([
            'nombre' => 'TRIMOTO CONVERTIBLE',
            'modelo' => 'IMPORT-03',
            'descripcion' => 'Trimoto convertible 1200W.',
            'precio_unit' => 4000.00,
            'precio_mayor' => 3200.00,
            'imagen' => 'prod3.jpg'
        ]);

        MotoVariante::insert([
            ['moto_id' => $moto3->id, 'color_nombre' => 'Negro', 'color_hex' => '#000000', 'imagen' => 'prod3-black.jpg'],
            ['moto_id' => $moto3->id, 'color_nombre' => 'Rojo', 'color_hex' => '#b80000', 'imagen' => 'prod3-red.jpg'],
            ['moto_id' => $moto3->id, 'color_nombre' => 'Verde', 'color_hex' => '#1a8d43', 'imagen' => 'prod3-green.jpg'],
            ['moto_id' => $moto3->id, 'color_nombre' => 'Beige', 'color_hex' => '#d7c9a5', 'imagen' => 'prod3-beige.jpg'],
        ]);

        // === PROD 4 ===
        $moto4 = Moto::create([
            'nombre' => 'BICI MOTO CONVERTIBLE',
            'modelo' => 'IMPORT-04',
            'descripcion' => 'Bici moto eléctrica convertible.',
            'precio_unit' => 4300.00,
            'precio_mayor' => 3700.00,
            'imagen' => 'prod4.jpg'
        ]);

        MotoVariante::insert([
            ['moto_id' => $moto4->id, 'color_nombre' => 'Negro', 'color_hex' => '#000000', 'imagen' => 'prod4-black.jpg'],
            ['moto_id' => $moto4->id, 'color_nombre' => 'Gris', 'color_hex' => '#737373', 'imagen' => 'prod4-gray.jpg'],
            ['moto_id' => $moto4->id, 'color_nombre' => 'Verde', 'color_hex' => '#1a8d43', 'imagen' => 'prod4-green.jpg'],
            ['moto_id' => $moto4->id, 'color_nombre' => 'Beige', 'color_hex' => '#d7c9a5', 'imagen' => 'prod4-beige.jpg'],
        ]);

        // === PROD 5 ===
        $moto5 = Moto::create([
            'nombre' => 'TRIMOTO CON TECHO',
            'modelo' => 'IMPORT-05',
            'descripcion' => 'Trimoto con techo y grafeno.',
            'precio_unit' => 5800.00,
            'precio_mayor' => 5000.00,
            'imagen' => 'prod5.jpg'
        ]);

        MotoVariante::insert([
            ['moto_id' => $moto5->id, 'color_nombre' => 'Verde Militar', 'color_hex' => '#3e645f', 'imagen' => 'prod5-green.jpg'],
        ]);
    }
}
