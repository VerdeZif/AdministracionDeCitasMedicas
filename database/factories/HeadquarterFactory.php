<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HeadquarterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Sede ' . fake()->city(),
            'address' => fake()->address(),
        ];
    }
}