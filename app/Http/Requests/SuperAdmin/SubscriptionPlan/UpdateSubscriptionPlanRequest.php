<?php

namespace App\Http\Requests\SuperAdmin\SubscriptionPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionPlanRequest extends FormRequest
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
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'string' , 'max:255'],
            'tier' => ['required', 'string' , 'max:255'],
            'plan_status' => ['required', 'string' , 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'offer_price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99', 'lt:price'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string'],
            'trial_days' => ['required', 'integer', 'min:0', 'max:365'],
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
            'name.required' => 'The plan name field is required.',
            'name.max' => 'The plan name must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 1000 characters.',
            'type.required' => 'The subscription type is required.',
            'type.string' => 'The subscription type must be a string.',
            'type.max' => 'The subscription type must not exceed 255 characters.',
            'tier.required' => 'The plan tier is required.',
            'tier.string' => 'The plan tier must be a string.',
            'tier.max' => 'The plan tier must not exceed 255 characters.',
            'plan_status.required' => 'The plan status is required.',
            'plan_status.string' => 'The plan status must be a string.',
            'plan_status.max' => 'The plan status must not exceed 255 characters.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'offer_price.numeric' => 'The offer price must be a valid number.',
            'offer_price.min' => 'The offer price must be at least 0.',
            'offer_price.lt' => 'The offer price must be less than the regular price.',
            'trial_days.required' => 'The trial days field is required.',
            'trial_days.integer' => 'The trial days must be a valid integer.',
            'trial_days.min' => 'The trial days must be at least 0.',
            'trial_days.max' => 'The trial days must not exceed 365.',
        ];
    }
}
