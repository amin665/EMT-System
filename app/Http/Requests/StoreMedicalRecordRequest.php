<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'patientID' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'medicines' => 'nullable|string',
            'followUpNotes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf|max:10240',
        ];
    }
}