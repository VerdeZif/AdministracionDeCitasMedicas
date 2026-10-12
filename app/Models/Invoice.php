<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function appointment() { return $this->belongsTo(Appointment::class); }
}
