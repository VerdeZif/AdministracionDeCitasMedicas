<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dni',
        'full_name',
        'relationship',
    ];

    // Un dependiente pertenece a un usuario (paciente titular)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un dependiente tiene muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}