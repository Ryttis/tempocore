<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'service_id' => ['required', 'integer', 'exists:services,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
