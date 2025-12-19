<?php

namespace App\Http\Requests\SchoolAdmin\LeaveApplication;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveApplicationRequest extends FormRequest
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
            'leave_type' => ['required', 'in:sick,casual,emergency,vacation,other'],
            'type' => ['required', 'in:full_day,half_day'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:1000'],
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
            'leave_type.required' => 'Please select a leave type.',
            'leave_type.in' => 'Invalid leave type selected.',
            'type.required' => 'Please select a leave duration.',
            'type.in' => 'Invalid leave duration selected.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.after_or_equal' => 'Start date cannot be in the past.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'reason.required' => 'Reason is required.',
            'reason.max' => 'Reason cannot exceed 1000 characters.',
        ];
    }
}
