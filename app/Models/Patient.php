<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'createdBy',
        'fullName',
        'email',
        'phoneNumber',
        'dob',
        'medicalHistory',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patientID');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patientID');
    }
}