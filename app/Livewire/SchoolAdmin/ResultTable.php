<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Result;
use Illuminate\Contracts\View\View;

class ResultTable extends DataTable
{
    protected function getQuery()
    {
        return Result::query()
            ->with(['student', 'exam', 'subject', 'academicClass', 'section', 'academicSession'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('student', function ($studentQuery) {
                        $studentQuery->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('first_name', 'like', '%'.$this->search.'%')
                            ->orWhere('last_name', 'like', '%'.$this->search.'%')
                            ->orWhere('admission_number', 'like', '%'.$this->search.'%');
                    })
                        ->orWhereHas('exam', function ($examQuery) {
                            $examQuery->where('name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('subject', function ($subjectQuery) {
                            $subjectQuery->where('name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhere('grade', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $result = Result::findOrFail($id);
        $result->delete();

        $this->dispatch('resultDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Result deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $studentName): void
    {
        $this->dispatch('openDeleteModal', [
            'resultId' => $id,
            'resultStudentName' => $studentName,
        ]);
    }

    public function render(): View
    {
        $results = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.result-table', [
            'results' => $results,
        ]);
    }
}
