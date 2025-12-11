<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Exam;
use Illuminate\Contracts\View\View;

class ExamTable extends DataTable
{
    protected function getQuery()
    {
        return Exam::query()
            ->with(['school', 'academicSession'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('exam_type', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        $this->dispatch('examDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Exam deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'examId' => $id,
            'examName' => $name,
        ]);
    }

    public function render(): View
    {
        $exams = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.exam-table', [
            'exams' => $exams,
        ]);
    }
}
