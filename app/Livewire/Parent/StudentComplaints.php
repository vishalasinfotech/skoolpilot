<?php

namespace App\Livewire\Parent;

use App\Livewire\Components\DataTable;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Contracts\View\View;

class StudentComplaints extends DataTable
{
    public $selectedStudentId = '';

    protected function getQuery()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Get all children of the parent
        $childrenIds = User::where('school_id', $schoolId)
            ->students()
            ->where(function ($query) use ($user) {
                $query->where('parent_email', $user->email)
                    ->orWhere('parent_phone', $user->phone);
            })
            ->pluck('id');

        $query = Feedback::query()
            ->where('type', 'complaint')
            ->whereIn('student_id', $childrenIds)
            ->with(['student', 'createdBy']);

        if ($this->selectedStudentId) {
            $query->where('student_id', $this->selectedStudentId);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%'.$this->search.'%')
                    ->orWhere('message', 'like', '%'.$this->search.'%')
                    ->orWhereHas('student', function ($studentQuery) {
                        $studentQuery->where('first_name', 'like', '%'.$this->search.'%')
                            ->orWhere('last_name', 'like', '%'.$this->search.'%')
                            ->orWhere('admission_number', 'like', '%'.$this->search.'%');
                    });
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function updatedSelectedStudentId(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Get all children of the parent
        $children = User::where('school_id', $schoolId)
            ->students()
            ->where(function ($query) use ($user) {
                $query->where('parent_email', $user->email)
                    ->orWhere('parent_phone', $user->phone);
            })
            ->orderBy('first_name')
            ->get();

        $complaints = $this->getQuery()->paginate($this->perPage);

        return view('livewire.parent.student-complaints', [
            'complaints' => $complaints,
            'children' => $children,
        ]);
    }
}
