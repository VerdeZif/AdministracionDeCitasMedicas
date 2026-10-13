<?php

namespace Database\Factories;

use App\Models\Headquarter;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $doctor = User::where('role', 'doctor')->inRandomOrder()->first()
                  ?? User::factory()->doctor()->create();

        $patient = User::where('role', 'patient')->inRandomOrder()->value('id')
                   ?? User::factory()->create()->id;

        return [
            'patient_id' => $patient,
            'doctor_id' => $doctor->id,
            'headquarter_id' => Headquarter::inRandomOrder()->value('id')
                                ?? Headquarter::factory(),
            'specialty_id' => $doctor->specialty_id ?? Specialty::factory(),
            'date' => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'time' => fake()->randomElement(['09:00', '10:00', '11:00', '15:00', '16:00', '17:00']),
            'status' => fake()->randomElement([
                'Pendiente de Pago',
                'Confirmada',
                'En Curso',
                'Atendida',
                'Ausente',
            ]),
        ];
    }
}