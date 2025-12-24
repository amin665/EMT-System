<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'followUpNotes' => 'nullable|string',
        ];
    }
}