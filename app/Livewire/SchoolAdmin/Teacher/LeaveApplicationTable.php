<?php

namespace App\Livewire\SchoolAdmin\Teacher;

use App\Livewire\Components\DataTable;
use App\Models\LeaveApplication;
use Illuminate\Contracts\View\View;

class LeaveApplicationTable extends DataTable
{
    protected function getQuery()
    {
        return LeaveApplication::query()
            ->where('school_id', auth()->user()->school_id)
            ->where('teacher_id', auth()->id())
            ->with(['school', 'approver'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('leave_type', 'like', '%'.$this->search.'%')
                        ->orWhere('reason', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $leaveApplication = LeaveApplication::query()
            ->where('id', $id)
            ->where('teacher_id', auth()->id())
            ->where('school_id', auth()->user()->school_id)
            ->firstOrFail();

        // Only allow deletion of pending applications
        if ($leaveApplication->status !== 'pending') {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Only pending leave applications can be deleted.',
            ]);

            return;
        }

        $leaveApplication->delete();

        $this->dispatch('leaveApplicationDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Leave application deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'leaveApplicationId' => $id,
            'leaveApplicationName' => $name,
        ]);
    }

    public function render(): View
    {
        $leaveApplications = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.teacher.leave-application-table', [
            'leaveApplications' => $leaveApplications,
        ]);
    }
}
