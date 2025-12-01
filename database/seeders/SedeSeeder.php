<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        Sede::insert([
            ['nombre' => 'Sucursal Lima', 'ciudad' => 'Lima', 'telefono' => '01 555-0001'],
            ['nombre' => 'Sucursal Arequipa', 'ciudad' => 'Arequipa', 'telefono' => '054 222-111'],
            ['nombre' => 'Sucursal Cusco', 'ciudad' => 'Cusco', 'telefono' => '084 777-222'],
        ]);
    }
}
