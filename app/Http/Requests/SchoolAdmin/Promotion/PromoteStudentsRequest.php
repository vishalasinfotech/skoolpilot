<?php

namespace App\Http\Requests\SchoolAdmin\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromoteStudentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        return in_array($user->role, ['school_admin', 'school-admin'], true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $schoolId = $this->user()?->school_id;

        return [
            'from_academic_session_id' => [
                'required',
                'integer',
                Rule::exists('academic_sessions', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'to_academic_session_id' => [
                'required',
                'integer',
                'different:from_academic_session_id',
                Rule::exists('academic_sessions', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'from_class_id' => [
                'required',
                'integer',
                Rule::exists('academic_classes', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'from_section_id' => [
                'nullable',
                'integer',
                Rule::exists('sections', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'to_class_id' => [
                'required',
                'integer',
                Rule::exists('academic_classes', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'to_section_id' => [
                'nullable',
                'integer',
                Rule::exists('sections', 'id')->where(fn ($query) => $query->where('school_id', $schoolId)),
            ],
            'include_inactive' => ['nullable', 'boolean'],
        ];
    }
}
