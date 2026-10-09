<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialtyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Cardiología',
                'Pediatría',
                'Dermatología',
                'Traumatología',
                'Ginecología',
                'Oftalmología',
                'Neurología',
                'Medicina General',
            ]),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 50, 300),
        ];
    }
}