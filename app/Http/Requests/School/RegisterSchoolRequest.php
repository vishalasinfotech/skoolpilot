<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSchoolRequest extends FormRequest
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
            'school_name' => ['required', 'string', 'max:255'],
            'school_email' => ['required', 'email', 'max:255', 'unique:schools,email'],
            'school_phone' => ['nullable', 'string', 'max:255'],
            'school_address' => ['nullable', 'string'],
            'logo' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'theme_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'subscription_plan_id' => ['nullable', 'integer', 'exists:subscription_plans,id'],

            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'school_name.required' => 'The school name field is required.',
            'school_email.required' => 'The school email field is required.',
            'school_email.email' => 'The school email must be a valid email address.',
            'school_email.unique' => 'The school email has already been taken.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, jpg, png, gif.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'theme_color.required' => 'The theme color field is required.',
            'theme_color.regex' => 'The theme color must be a valid hex color code (e.g., #3B82F6).',
            'subscription_plan_id.exists' => 'The selected subscription plan is invalid.',
            'admin_name.required' => 'The admin name field is required.',
            'admin_email.required' => 'The admin email field is required.',
            'admin_email.email' => 'The admin email must be a valid email address.',
            'admin_email.unique' => 'The admin email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
