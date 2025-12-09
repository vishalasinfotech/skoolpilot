<?php

namespace App\Http\Requests\SchoolAdmin\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->where('role', 'teacher')],
            'phone' => ['nullable', 'string', 'max:20'],
            'employee_id' => ['required', 'string', 'max:50', Rule::unique('users', 'employee_id')->where('role', 'teacher')],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'profile_image' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'doc_type' => ['nullable', 'string', 'max:255'],
            'doc_image' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already registered.',
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.unique' => 'This employee ID is already in use.',
            'date_of_birth.before' => 'The date of birth must be before today.',
        ];
    }
}
