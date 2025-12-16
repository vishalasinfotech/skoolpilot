<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicClass;
use App\Models\Feedback;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AddStudentComplaint extends Component
{
    public $studentId = '';

    public $subject = '';

    public $message = '';

    public $classId = '';

    public $sectionId = '';

    protected function rules(): array
    {
        return [
            'studentId' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'studentId.required' => 'Please select a student.',
            'studentId.exists' => 'The selected student does not exist.',
            'subject.required' => 'The subject field is required.',
            'subject.max' => 'The subject may not be greater than 255 characters.',
            'message.required' => 'The message field is required.',
            'message.max' => 'The message may not be greater than 5000 characters.',
        ];
    }

    public function updatedClassId(): void
    {
        $this->sectionId = '';
        $this->studentId = '';
    }

    public function store(): void
    {
        $this->validate();

        $user = auth()->user();
        $student = User::findOrFail($this->studentId);

        // Verify student belongs to same school
        abort_unless($student->school_id === $user->school_id, 403);
        abort_unless($student->isStudent(), 403);

        Feedback::create([
            'created_by' => $user->id,
            'student_id' => $this->studentId,
            'school_id' => $user->school_id,
            'subject' => $this->subject,
            'message' => $this->message,
            'type' => 'complaint',
            'status' => 'pending',
        ]);

        $this->reset(['studentId', 'subject', 'message', 'classId', 'sectionId']);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Complaint submitted successfully!',
        ]);
    }

    public function render(): View
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $students = collect();
        if ($this->classId) {
            $query = User::query()
                ->students()
                ->where('school_id', $schoolId)
                ->where('is_active', true)
                ->where('class_id', $this->classId);

            if ($this->sectionId) {
                $query->where('section_id', $this->sectionId);
            }

            $students = $query->orderBy('first_name')
                ->get()
                ->mapWithKeys(function ($student) {
                    return [$student->id => $student->name.' ('.$student->admission_number.')'];
                });
        }

        return view('livewire.teacher.add-student-complaint', [
            'classes' => $classes,
            'sections' => $sections,
            'students' => $students,
        ]);
    }
}
