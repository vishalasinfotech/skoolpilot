<?php

namespace App\Http\Requests\SchoolAdmin\Holiday;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHolidayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'The school field is required.',
            'name.required' => 'The holiday name field is required.',
            'date.required' => 'The holiday date field is required.',
        ];
    }
}
