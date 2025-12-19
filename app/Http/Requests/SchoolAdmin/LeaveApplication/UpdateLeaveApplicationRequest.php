<?php

namespace App\Http\Requests\SchoolAdmin\LeaveApplication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveApplicationRequest extends FormRequest
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
        $leaveApplication = $this->route('leave_application');

        return [
            'status' => ['required', 'in:approved,rejected'],
            'admin_remarks' => ['nullable', 'string', 'max:500'],
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
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status selected.',
            'admin_remarks.max' => 'Admin remarks cannot exceed 500 characters.',
        ];
    }
}
