<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dependent_id')->nullable()->constrained('dependents')->nullOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('headquarter_id')->constrained('headquarters')->restrictOnDelete();
            $table->foreignId('specialty_id')->constrained('specialties')->restrictOnDelete();
            
            $table->date('date');
            $table->time('time');
            $table->enum('status', ['Pendiente de Pago', 'Confirmada', 'En Curso', 'Atendida', 'Ausente'])->default('Pendiente de Pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
