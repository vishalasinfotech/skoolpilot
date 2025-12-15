<?php

namespace App\Http\Requests\SchoolAdmin\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'type' => ['nullable', 'in:general,complaint,suggestion,question,other'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'The subject field is required.',
            'subject.max' => 'The subject may not be greater than 255 characters.',
            'message.required' => 'The message field is required.',
            'message.max' => 'The message may not be greater than 5000 characters.',
            'type.in' => 'The selected type is invalid.',
        ];
    }
}
