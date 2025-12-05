<?php

namespace App\Http\Requests\SchoolAdmin\Staff;

use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staff = $this->route('staff');
        $staffId = $staff instanceof Staff ? $staff->id : $staff;

        return [
            'school_id' => ['required', 'exists:schools,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:staff,email,'.$staffId],
            'phone' => ['nullable', 'string', 'max:20'],
            'employee_id' => ['required', 'string', 'max:50', 'unique:staff,employee_id,'.$staffId],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'profile_image' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already registered.',
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.unique' => 'This employee ID is already in use.',
            'designation.required' => 'The designation field is required.',
            'date_of_birth.before' => 'The date of birth must be before today.',
        ];
    }
}
