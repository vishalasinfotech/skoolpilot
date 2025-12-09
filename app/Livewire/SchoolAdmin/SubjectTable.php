<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Subject;
use Illuminate\Contracts\View\View;

class SubjectTable extends DataTable
{
    protected function getQuery()
    {
        return Subject::query()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('code', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $subject = Subject::query()->findOrFail($id);
        $subject->delete();

        $this->dispatch('subjectDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Subject deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'subjectId' => $id,
            'subjectName' => $name,
        ]);
    }

    public function render(): View
    {
        $subjects = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.subject-table', [
            'subjects' => $subjects,
        ]);
    }
}
