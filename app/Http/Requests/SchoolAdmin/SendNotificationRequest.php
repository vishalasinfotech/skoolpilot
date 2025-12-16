<?php

namespace App\Http\Requests\SchoolAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'school-admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'url' => ['nullable', 'string', 'max:500'],
            'send_type' => ['required', 'string', Rule::in(['role', 'user'])],
            'roles' => ['required_if:send_type,role', 'array'],
            'roles.*' => ['string', Rule::in(['teacher', 'student', 'parent', 'staff'])],
            'user_ids' => ['required_if:send_type,user', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'message.required' => 'The message field is required.',
            'message.max' => 'The message may not be greater than 5000 characters.',
            'send_type.required' => 'Please select a send type.',
            'send_type.in' => 'Invalid send type selected.',
            'roles.required_if' => 'Please select at least one role.',
            'roles.*.in' => 'Invalid role selected.',
            'user_ids.required_if' => 'Please select at least one user.',
            'user_ids.*.exists' => 'One or more selected users do not exist.',
        ];
    }
}
