<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patientID',
        'doctorID',
        'date',
        'status',
        'sms_sent',
    ];

    protected $casts = [
        'date' => 'datetime',
        'sms_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctorID');
    }
}