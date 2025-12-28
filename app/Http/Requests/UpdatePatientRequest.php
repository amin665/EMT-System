<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'fullName' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phoneNumber' => 'required|string|max:20',
            'dob' => 'required|date',
            'medicalHistory' => 'nullable|string',
        ];
    }
}