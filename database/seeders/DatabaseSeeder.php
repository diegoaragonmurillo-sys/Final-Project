<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // 👈 Importar modelo

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar todos los seeders
        $this->call([
            UserSeeder::class,
            SedeSeeder::class,
            MotoSeeder::class,
            VariantSeeder::class,
            FavoriteSeeder::class,
            CategoriaProductoSeeder::class,
        ]);

        // Crear usuario admin si no existe
        User::updateOrCreate(
            ['email' => 'admin@motovolt.com'], // Buscar por email
            [
                'name' => 'Administrador',
                'password' => bcrypt('Admin1234'),
                'role' => 'admin',
            ]
        );
    }
}
