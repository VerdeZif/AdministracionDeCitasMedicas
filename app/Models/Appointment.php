<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
public function headquarter() { return $this->belongsTo(Headquarter::class); }
public function specialty() { return $this->belongsTo(Specialty::class); }
public function invoice() { return $this->hasOne(Invoice::class); }
}
