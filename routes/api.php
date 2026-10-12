<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicAppointmentController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Doctor\DoctorAppointmentController;

// ==========================================
// 1. RUTAS PÚBLICAS (Para cargar el formulario)
// ==========================================
Route::prefix('public')->group(function () {
    Route::get('/filters', [PublicAppointmentController::class, 'getFormFilters']);
    Route::get('/doctors', [PublicAppointmentController::class, 'getDoctors']);
    Route::get('/availability', [PublicAppointmentController::class, 'getAvailableSlots']);
});

// ==========================================
// 2. RUTAS DEL PACIENTE (Requiere Login + Middleware CheckPatient)
// ==========================================
Route::middleware(['auth:sanctum', 'check.patient'])->prefix('patient')->group(function () {
    Route::post('/appointments', [PatientAppointmentController::class, 'store']);
    Route::get('/my-appointments', [PatientAppointmentController::class, 'myAppointments']);
});

// ==========================================
// 3. RUTAS DEL MÉDICO (Requiere Login + Middleware CheckDoctor)
// ==========================================
Route::middleware(['auth:sanctum', 'check.doctor'])->prefix('doctor')->group(function () {
    Route::get('/schedule', [DoctorAppointmentController::class, 'mySchedule']);
    Route::put('/appointments/{id}/status', [DoctorAppointmentController::class, 'updateStatus']);
});