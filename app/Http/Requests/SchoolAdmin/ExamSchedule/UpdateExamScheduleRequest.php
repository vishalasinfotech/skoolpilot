<?php

namespace App\Http\Requests\SchoolAdmin\ExamSchedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamScheduleRequest extends FormRequest
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
            'exam_id' => ['required', 'exists:exams,id'],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'exam_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'passing_marks' => ['required', 'integer', 'min:0'],
            'instructions' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
