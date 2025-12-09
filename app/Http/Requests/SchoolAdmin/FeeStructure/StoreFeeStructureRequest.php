<?php

namespace App\Http\Requests\SchoolAdmin\FeeStructure;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeStructureRequest extends FormRequest
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
            'class_id' => ['nullable', 'exists:academic_classes,id'],
            'fee_type' => ['required', 'string', 'max:100'],
            'fee_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'frequency' => ['required', 'in:monthly,quarterly,yearly,one_time,per_semester'],
            'effective_from' => ['nullable', 'date'],
            'effective_to' => ['nullable', 'date', 'after:effective_from'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'fee_type.required' => 'The fee type field is required.',
            'fee_name.required' => 'The fee name field is required.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be at least 0.',
            'frequency.required' => 'The frequency field is required.',
            'effective_to.after' => 'The effective to date must be after the effective from date.',
        ];
    }
}
