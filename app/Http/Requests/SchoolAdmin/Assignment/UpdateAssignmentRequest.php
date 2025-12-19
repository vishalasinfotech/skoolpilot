<?php

namespace App\Http\Requests\SchoolAdmin\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
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
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'instructions' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'max_marks' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'status' => ['required', 'in:draft,published,closed'],
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
            'academic_class_id.required' => 'Please select a class.',
            'academic_class_id.exists' => 'Selected class does not exist.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'section_id.exists' => 'Selected section does not exist.',
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'due_date.required' => 'Due date is required.',
            'due_date.date' => 'Due date must be a valid date.',
            'max_marks.integer' => 'Maximum marks must be a number.',
            'max_marks.min' => 'Maximum marks cannot be negative.',
            'max_marks.max' => 'Maximum marks cannot exceed 1000.',
            'attachment.file' => 'Attachment must be a valid file.',
            'attachment.mimes' => 'Attachment must be a PDF, DOC, DOCX, JPG, JPEG, or PNG file.',
            'attachment.max' => 'Attachment size cannot exceed 10MB.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}
