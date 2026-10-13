<?php

namespace Database\Factories;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'last_name_paternal' => fake()->lastName(),
            'last_name_maternal' => fake()->lastName(),
            'document_type' => 'DNI',
            'dni' => fake()->unique()->numerify('########'),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'phone' => fake()->numerify('9########'),
            'gender' => fake()->randomElement(['M', 'F']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'patient',
            'remember_token' => Str::random(10),
        ];
    }
    /**
     * Estado: crear un MÉDICO.
     */
    public function doctor(?Specialty $specialty = null): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'doctor',
            'specialty_id' => $specialty?->id ?? Specialty::factory(),
        ]);
    }

    /**
     * Estado: crear un ADMINISTRADOR.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'specialty_id' => null,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}