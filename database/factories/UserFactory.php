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
            'name' => fake()->name(),
            'dni' => fake()->unique()->numerify('########'),
            'phone' => fake()->numerify('9########'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'patient',
            'specialty_id' => null,
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