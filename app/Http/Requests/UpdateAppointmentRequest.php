<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'date' => 'required|date|after:now',
            'status' => 'required|in:Scheduled,Done,Delayed,Canceled',
        ];
    }
}