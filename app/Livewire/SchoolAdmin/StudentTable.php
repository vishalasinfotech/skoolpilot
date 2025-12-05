<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Student;
use Illuminate\Contracts\View\View;

class StudentTable extends DataTable
{
    protected function getQuery()
    {
        return Student::query()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('admission_number', 'like', '%'.$this->search.'%')
                        ->orWhere('class', 'like', '%'.$this->search.'%')
                        ->orWhere('section', 'like', '%'.$this->search.'%')
                        ->orWhere('roll_number', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $student = Student::query()->findOrFail($id);

        if ($student->profile_image && file_exists(public_path($student->profile_image))) {
            unlink(public_path($student->profile_image));
        }

        $student->delete();

        $this->dispatch('studentDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Student deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'studentId' => $id,
            'studentName' => $name,
        ]);
    }

    public function render(): View
    {
        $students = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.student-table', [
            'students' => $students,
        ]);
    }
}
