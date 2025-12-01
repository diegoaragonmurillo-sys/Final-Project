<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moto;

class CategoriaProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [

            // =======================
            // 🚲 BICIMOTOS
            // =======================
            'bicimotos' => [
                ['nombre' => 'Bicimoto EcoRide', 'modelo' => 'BR-200', 'precio' => 3500],
                ['nombre' => 'Bicimoto 110cc', 'modelo' => 'BM-110', 'precio' => 3500],
                ['nombre' => 'Bicimoto 150cc Turbo', 'modelo' => 'BM-150T', 'precio' => 4500],
            ],

            // ========================
            // ⚡ MOTOS ELÉCTRICAS
            // ========================
            'motos-electricas' => [
                ['nombre' => 'E-Moto Volt XP', 'modelo' => 'EV-500', 'precio' => 6800],
                ['nombre' => 'EcoRide 500W', 'modelo' => 'ER-500', 'precio' => 5200],
                ['nombre' => 'Volt Max 1000W', 'modelo' => 'VM-1000', 'precio' => 9200],
            ],

            // ========================
            // 🚚 TRIMOTOS
            // ========================
            'trimotos' => [
                ['nombre' => 'Trimoto CargoMax', 'modelo' => 'TR-750', 'precio' => 12000],
                ['nombre' => 'TriCargo 200cc', 'modelo' => 'TRC-200', 'precio' => 9200],
                ['nombre' => 'TrikePower Diesel', 'modelo' => 'TPD-300', 'precio' => 11200],
            ],

            // ========================
            // 🧰 ACCESORIOS
            // ========================
            'accesorios' => [
                ['nombre' => 'Casco PowerShield', 'modelo' => 'CS-01', 'precio' => 180],
                ['nombre' => 'Guantes Racing Pro', 'modelo' => 'GRP-07', 'precio' => 95],
            ],

            // ========================
            // 🔧 REPUESTOS + SUBCATEGORÍAS
            // ========================
            'repuestos:baterias' => [
                ['nombre' => 'Batería 60V 20Ah', 'modelo' => 'BAT-60-20', 'precio' => 950]
            ],

            'repuestos:llantas' => [
                ['nombre' => 'Llanta Todo Terreno 14"', 'modelo' => 'LL-14-TT', 'precio' => 260]
            ],

            'repuestos:luces' => [
                ['nombre' => 'Kit Luces LED Premium', 'modelo' => 'LED-KIT-PRO', 'precio' => 120]
            ],

            'repuestos:cargadores' => [
                ['nombre' => 'Cargador Rápido 60V', 'modelo' => 'CH-60-Fast', 'precio' => 310]
            ],
        ];

        // Insertar en BD
        foreach ($productos as $categoria => $lista) {

            // Ver si hay subcategoría (formato categoria:sub)
            $parts = explode(':', $categoria);
            $categoriaBase = $parts[0];
            $subcategoria = $parts[1] ?? null;

            foreach ($lista as $p) {
                Moto::create([
                    'nombre'        => $p['nombre'],
                    'modelo'        => $p['modelo'],
                    'descripcion'   => $p['nombre'] . " de excelente calidad.",
                    'precio_unit'   => $p['precio'],
                    'categoria'     => $categoriaBase,
                    'subcategoria'  => $subcategoria,
                    'imagen'        => '/imagenes/productos/default.png',
                    'stock'         => rand(3, 15),
                ]);
            }
        }

        echo "✔ Productos por categoría creados correctamente.\n";
    }
}
