<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorBlockController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\HeadquarterController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/servicios', function () {
    return view('services');
})->name('services');

Route::get('/especialistas', function () {
    $doctors = \App\Models\User::where('role', 'doctor')->get();
    return view('specialists', compact('doctors'));
})->name('specialists');

Route::get('/contacto', function () {
    return view('contact');
})->name('contact');
/*
|--------------------------------------------------------------------------
| Dashboard General & Perfil (Nativo de Laravel Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    // El "semáforo" redirige según el rol del usuario
    if ($user->role === 'admin') {
        return redirect()->route('admin.appointments.all');
    } elseif ($user->role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } else {
        return redirect()->route('patient.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel del Paciente
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->prefix('paciente')->name('patient.')->group(function () {
    Route::get('/panel', [AppointmentController::class, 'patientDashboard'])->name('dashboard');
    Route::get('/reservar', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/reservar', [AppointmentController::class, 'store'])->name('appointments.store');
});

/*
|--------------------------------------------------------------------------
| Panel del Médico
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])->prefix('medico')->name('doctor.')->group(function () {
    Route::get('/panel', [AppointmentController::class, 'doctorDashboard'])->name('dashboard');
    Route::get('/agenda', [AppointmentController::class, 'doctorAppointments'])->name('appointments.index');
    Route::patch('/citas/{appointment}/estado', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::resource('bloqueos', DoctorBlockController::class)->parameters(['bloqueos' => 'doctorBlock']);
});

/*
|--------------------------------------------------------------------------
| Panel del Administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('especialidades', SpecialtyController::class)->parameters(['especialidades' => 'specialty']);
    Route::resource('sedes', HeadquarterController::class)->parameters(['sedes' => 'headquarter']);
    Route::get('/citas-globales', [AppointmentController::class, 'adminAppointments'])->name('appointments.all');
});

Route::get('/api/horarios-disponibles', [App\Http\Controllers\AppointmentController::class, 'getAvailableHours']);

Route::get('/citas/{appointment}/descargar-pdf', [App\Http\Controllers\AppointmentController::class, 'downloadPdf'])->name('patient.appointments.pdf');

require __DIR__.'/auth.php';