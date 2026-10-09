<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Una especialidad tiene muchos médicos
    public function doctors()
    {
        return $this->hasMany(User::class)->where('role', 'doctor');
    }

    // Una especialidad tiene muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}