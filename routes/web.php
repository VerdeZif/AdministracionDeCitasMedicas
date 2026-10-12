<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// DATOS DE PRUEBA (temporal)
// Reemplazar por consultas a la BD desde los controladores cuando el backend esté listo.
// ==========================================
$specialties = [
    ['name' => 'Medicina General', 'description' => 'Evaluación integral y orientación para tu salud.', 'price' => 50],
    ['name' => 'Pediatría', 'description' => 'Atención médica para bebés, niños y adolescentes.', 'price' => 70],
    ['name' => 'Cardiología', 'description' => 'Diagnóstico y control de enfermedades del corazón.', 'price' => 120],
    ['name' => 'Dermatología', 'description' => 'Cuidado de la piel, cabello y uñas.', 'price' => 90],
    ['name' => 'Ginecología', 'description' => 'Salud integral de la mujer.', 'price' => 100],
];

$headquarters = [
    ['name' => 'Sede Central', 'address' => 'Av. Principal 123, Lima'],
    ['name' => 'Sede Norte', 'address' => 'Jr. Los Olivos 456, Lima'],
];

$doctors = [
    ['name' => 'Dra. Ana Torres', 'initials' => 'AT', 'specialty' => 'Pediatría', 'headquarter' => 'Sede Central'],
    ['name' => 'Dr. Luis Ramírez', 'initials' => 'LR', 'specialty' => 'Cardiología', 'headquarter' => 'Sede Norte'],
    ['name' => 'Dra. Carla Méndez', 'initials' => 'CM', 'specialty' => 'Dermatología', 'headquarter' => 'Sede Central'],
];

$metrics = [
    ['value' => '5', 'label' => 'Especialidades'],
    ['value' => '3', 'label' => 'Médicos'],
    ['value' => '2', 'label' => 'Sedes'],
    ['value' => '24/7', 'label' => 'Reservas en línea'],
];

// ==========================================
// RUTAS PÚBLICAS
// ==========================================
Route::view('/', 'public.home', [
    'specialties' => array_slice($specialties, 0, 3),
    'metrics' => $metrics,
])->name('home');

Route::view('/especialidades', 'public.services', compact('specialties'))->name('services');
Route::view('/medicos', 'public.specialists', compact('doctors'))->name('specialists');
Route::view('/contacto', 'public.contact', compact('headquarters'))->name('contact');
