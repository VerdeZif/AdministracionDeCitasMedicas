<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'amount' => fake()->randomFloat(2, 50, 300),
            'payment_method' => fake()->randomElement([
                'Mock_Visa',
                'Mock_Yape',
                'Mock_Mastercard',
            ]),
        ];
    }
}