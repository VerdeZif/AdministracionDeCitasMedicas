<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dependent_id',
        'doctor_id',
        'headquarter_id',
        'specialty_id',
        'date',
        'time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Paciente (User)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Doctor (User)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Especialidad
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // Sede
    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    // Dependiente (familiar)
    public function dependent()
    {
        return $this->belongsTo(Dependent::class);
    }

    // Una cita tiene una boleta
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
