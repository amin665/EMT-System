<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'patientID' => 'required|exists:patients,id',
            // Appointment cannot be in the past
            'date' => 'required|date|after:now', 
            'status' => 'required|in:Scheduled,Done,Delayed,Canceled',
        ];
    }
}