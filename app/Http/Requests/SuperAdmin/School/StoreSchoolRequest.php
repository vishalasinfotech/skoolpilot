<?php

namespace App\Http\Requests\SuperAdmin\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:schools,email'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'theme_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'status' => ['nullable', 'boolean'],
            'subscription_plan_id' => ['nullable', 'integer'],
            'trial_ends_at' => ['nullable', 'date'],
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
            'name.required' => 'The school name field is required.',
            'name.max' => 'The school name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.max' => 'The phone may not be greater than 255 characters.',
            'logo.file' => 'The logo must be a file.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, jpg, png, gif.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'theme_color.required' => 'The theme color field is required.',
            'theme_color.regex' => 'The theme color must be a valid hex color code (e.g., #3B82F6).',
            'status.boolean' => 'The status field must be true or false.',
            'subscription_plan_id.integer' => 'The subscription plan must be a valid integer.',
            'trial_ends_at.date' => 'The trial ends at must be a valid date.',
        ];
    }
}
