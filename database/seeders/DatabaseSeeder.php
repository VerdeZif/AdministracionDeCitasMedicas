<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Headquarter;
use App\Models\Invoice;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin maestro
        User::factory()->admin()->create([
            'name'  => 'Administrador Maestro',
            'email' => 'admin@clinica.com',
            'dni'   => '00000001',
            'phone' => '999000001',
        ]);

        // 2. Cinco especialidades reales con precios
        $specialtiesData = [
            ['name' => 'Cardiología',      'description' => 'Enfermedades del corazón',                 'price' => 150.00],
            ['name' => 'Pediatría',        'description' => 'Atención médica infantil',                 'price' => 100.00],
            ['name' => 'Dermatología',     'description' => 'Cuidado de la piel',                       'price' => 120.00],
            ['name' => 'Traumatología',    'description' => 'Lesiones del sistema músculo-esquelético', 'price' => 180.00],
            ['name' => 'Medicina General', 'description' => 'Atención primaria general',                'price' => 80.00],
        ];

        $specialties = collect($specialtiesData)->map(
            fn ($s) => Specialty::create($s)
        );

        // 3. Sedes
        $headquarters = collect([
            ['name' => 'Sede Central', 'address' => 'Av. Principal 123, Lima'],
            ['name' => 'Sede Norte',   'address' => 'Av. Los Álamos 456, Lima'],
            ['name' => 'Sede Sur',     'address' => 'Av. El Sol 789, Lima'],
        ])->map(fn ($h) => Headquarter::create($h));

        // 4. Tres médicos asignados a especialidades
        User::factory()->doctor($specialties[0])->create([
            'name'  => 'Dr. Carlos Ramírez',
            'email' => 'doctor@clinica.com',
            'dni'   => '10000001',
            'phone' => '999000002',
        ]);

        User::factory()->doctor($specialties[1])->create([
            'name'  => 'Dra. Ana Torres',
            'email' => 'ana.torres@clinica.com',
            'dni'   => '10000002',
            'phone' => '999000003',
        ]);

        User::factory()->doctor($specialties[3])->create([
            'name'  => 'Dr. Luis Mendoza',
            'email' => 'luis.mendoza@clinica.com',
            'dni'   => '10000003',
            'phone' => '999000004',
        ]);

        // 5. Diez pacientes (uno con email conocido para login)
        User::factory()->create([
            'name'  => 'Paciente Demo',
            'email' => 'paciente@correo.com',
            'dni'   => '20000001',
            'phone' => '999000005',
            'role'  => 'patient',
        ]);

        User::factory()->count(9)->create(['role' => 'patient']);

        // 6. Citas y boletas de ejemplo (para que Fernando vea tablas llenas)
        Appointment::factory()->count(20)->create()->each(function ($appointment) {
            if ($appointment->status !== 'Pendiente de Pago') {
                Invoice::factory()->create([
                    'appointment_id' => $appointment->id,
                    'amount'         => $appointment->specialty->price,
                ]);
            }
        });
    }
}