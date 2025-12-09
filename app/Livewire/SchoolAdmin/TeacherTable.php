<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\User;
use Illuminate\Contracts\View\View;

class TeacherTable extends DataTable
{
    protected function getQuery()
    {
        return User::query()
            ->teachers()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('employee_id', 'like', '%'.$this->search.'%')
                        ->orWhere('specialization', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $teacher = User::query()->teachers()->findOrFail($id);

        if ($teacher->profile_image && file_exists(public_path($teacher->profile_image))) {
            unlink(public_path($teacher->profile_image));
        }

        $teacher->delete();

        $this->dispatch('teacherDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Teacher deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'teacherId' => $id,
            'teacherName' => $name,
        ]);
    }

    public function render(): View
    {
        $teachers = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.teacher-table', [
            'teachers' => $teachers,
        ]);
    }
}
