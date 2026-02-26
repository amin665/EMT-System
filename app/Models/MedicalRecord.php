<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patientID',
        'doctorID',
        'diagnosis',
        'prescription',
        'medicines',
        'followUpNotes',
        'attachment_path',
        'attachment_original_name',
        'attachment_mime',
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