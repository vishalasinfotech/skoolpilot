<?php

namespace App\Http\Requests\SchoolAdmin\Transportation;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportationRequest extends FormRequest
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
            'vehicle_number' => ['required', 'string', 'max:255'],
            'vehicle_type' => ['required', 'string', 'in:bus,van,car,auto,other'],
            'driver_name' => ['required', 'string', 'max:255'],
            'driver_phone' => ['required', 'string', 'max:20'],
            'driver_license_number' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'route_name' => ['nullable', 'string', 'max:255'],
            'route_description' => ['nullable', 'string', 'max:1000'],
            'fare_amount' => ['nullable', 'numeric', 'min:0'],
            'registration_date' => ['nullable', 'date'],
            'insurance_expiry' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
