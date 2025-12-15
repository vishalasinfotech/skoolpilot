<?php

namespace App\Http\Requests\SchoolAdmin\Library;

use Illuminate\Foundation\Http\FormRequest;

class IssueBookRequest extends FormRequest
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
            'library_id' => ['required', 'exists:libraries,id'],
            'user_id' => ['required', 'exists:users,id'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after:issue_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'library_id.required' => 'Please select a book.',
            'library_id.exists' => 'The selected book does not exist.',
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'The selected user does not exist.',
            'issue_date.required' => 'The issue date field is required.',
            'issue_date.date' => 'The issue date must be a valid date.',
            'due_date.required' => 'The due date field is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after' => 'The due date must be after the issue date.',
            'notes.max' => 'The notes may not be greater than 1000 characters.',
        ];
    }
}
