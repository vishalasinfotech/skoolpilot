<?php

namespace App\Http\Requests\SchoolAdmin\AcademicClass;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicClassRequest extends FormRequest
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
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'The school field is required.',
            'name.required' => 'The class name field is required.',
        ];
    }
}
