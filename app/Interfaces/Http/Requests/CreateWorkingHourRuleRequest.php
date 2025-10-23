<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateWorkingHourRuleRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('working_hour');

        return [
            'day_of_week' => [
                'required',
                'integer',
                'between:0,6',
                Rule::unique('working_hour_rules', 'day_of_week')->ignore($id),
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'day_of_week.unique' => 'A working hour rule already exists for this day.',
            'end_time.after' => 'End time must be after start time.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
