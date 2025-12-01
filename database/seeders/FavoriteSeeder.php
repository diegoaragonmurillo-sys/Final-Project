<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Moto;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('favoritos')->insert([
            [
                'user_id' => 1,
                'moto_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'moto_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
