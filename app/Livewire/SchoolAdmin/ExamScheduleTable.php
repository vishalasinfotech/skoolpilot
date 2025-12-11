<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\ExamSchedule;
use Illuminate\Contracts\View\View;

class ExamScheduleTable extends DataTable
{
    protected function getQuery()
    {
        return ExamSchedule::query()
            ->with(['exam', 'academicClass', 'section', 'subject'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('exam', function ($examQuery) {
                        $examQuery->where('name', 'like', '%'.$this->search.'%');
                    })
                        ->orWhereHas('subject', function ($subjectQuery) {
                            $subjectQuery->where('name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('academicClass', function ($classQuery) {
                            $classQuery->where('name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhere('room_number', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->delete();

        $this->dispatch('examScheduleDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Exam schedule deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $examName): void
    {
        $this->dispatch('openDeleteModal', [
            'examScheduleId' => $id,
            'examScheduleName' => $examName,
        ]);
    }

    public function render(): View
    {
        $examSchedules = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.exam-schedule-table', [
            'examSchedules' => $examSchedules,
        ]);
    }
}
