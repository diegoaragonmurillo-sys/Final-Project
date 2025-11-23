<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'modelo' => $this->faker->bothify('MODEL-###'),
            'descripcion' => $this->faker->paragraph(),
            'precio_unit' => $this->faker->numberBetween(2000, 8000),
            'precio_mayor' => $this->faker->numberBetween(1500, 6000),
            'cantidad_mayorista' => 5,
            'imagen' => 'default.jpg',
        ];
    }
}
