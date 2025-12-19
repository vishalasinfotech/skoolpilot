<?php

namespace App\Livewire\SchoolAdmin\Teacher;

use App\Livewire\Components\DataTable;
use App\Models\Assignment;
use Illuminate\Contracts\View\View;

class AssignmentTable extends DataTable
{
    protected function getQuery()
    {
        return Assignment::query()
            ->where('school_id', auth()->user()->school_id)
            ->where('teacher_id', auth()->id())
            ->with(['academicClass', 'subject', 'section', 'teacher'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $assignment = Assignment::query()
            ->where('id', $id)
            ->where('teacher_id', auth()->id())
            ->where('school_id', auth()->user()->school_id)
            ->firstOrFail();

        if ($assignment->status !== 'draft') {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Only draft assignments can be deleted.',
            ]);

            return;
        }

        $assignment->delete();

        $this->dispatch('assignmentDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Assignment deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'assignmentId' => $id,
            'assignmentName' => $name,
        ]);
    }

    public function render(): View
    {
        $assignments = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.teacher.assignment-table', [
            'assignments' => $assignments,
        ]);
    }
}
