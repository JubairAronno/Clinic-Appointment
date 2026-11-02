<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    
    protected $fillable = [
        'date',
        'time', 
        'doctor_name',
        'chamber_name',
        'patient_name',
        'patient_phone',
        'notes',
        'status'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
}