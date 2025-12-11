<?php

namespace App\Http\Requests\SchoolAdmin\Result;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'exam_schedule_id' => ['required', 'exists:exam_schedules,id'],
            'student_id' => ['required', 'exists:users,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'obtained_marks' => ['required', 'numeric', 'min:0'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'grade' => ['nullable', 'string', 'in:A+,A,B+,B,C+,C,D,F'],
            'percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:pass,fail,absent'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ];
    }
}
