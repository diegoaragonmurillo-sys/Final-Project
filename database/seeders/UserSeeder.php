<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@motovolt.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin1234'),
                'role' => 'admin'
            ]
        );

        // USUARIOS NORMALES
        User::factory()->count(5)->create();
    }
}
