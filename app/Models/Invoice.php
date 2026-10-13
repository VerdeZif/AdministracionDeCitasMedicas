<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'amount',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Una boleta pertenece a una cita
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}

