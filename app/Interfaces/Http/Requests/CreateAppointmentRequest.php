<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'service_id'   => ['required', 'integer', 'exists:services,id'],
            'starts_at'    => ['required', 'date'],
            'client_email' => ['required', 'email'],
            'client_name'  => ['nullable', 'string', 'max:120'],
            'client_phone' => ['nullable', 'string', 'max:40'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
