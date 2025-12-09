<?php

namespace App\Http\Requests\SchoolAdmin\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->where('role', 'student')],
            'phone' => ['nullable', 'string', 'max:20'],
            'parent_phone' => ['nullable', 'string', 'max:20'],
            'admission_number' => ['required', 'string', 'max:50', Rule::unique('users', 'admission_number')->where('role', 'student')],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
            'class' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'class_id' => ['nullable', 'exists:academic_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'roll_number' => ['nullable', 'string', 'max:50'],
            'admission_date' => ['nullable', 'date'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_email' => ['nullable', 'email', 'max:255'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'profile_image' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'doc_type' => ['nullable', 'string', 'max:255'],
            'doc_image' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.unique' => 'This email is already registered.',
            'admission_number.required' => 'The admission number field is required.',
            'admission_number.unique' => 'This admission number is already in use.',
            'date_of_birth.before' => 'The date of birth must be before today.',
        ];
    }
}
