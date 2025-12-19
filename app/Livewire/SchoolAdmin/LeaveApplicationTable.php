<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\LeaveApplication;
use Illuminate\Contracts\View\View;

class LeaveApplicationTable extends DataTable
{
    public $statusFilter = '';

    public $rejectLeaveId = null;

    public $adminRemarks = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => ''],
    ];

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    protected function getQuery()
    {
        return LeaveApplication::query()
            ->where('school_id', auth()->user()->school_id)
            ->with(['teacher', 'approver'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('leave_type', 'like', '%'.$this->search.'%')
                        ->orWhere('reason', 'like', '%'.$this->search.'%')
                        ->orWhereHas('teacher', function ($teacherQuery) {
                            $teacherQuery->where('first_name', 'like', '%'.$this->search.'%')
                                ->orWhere('last_name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%')
                                ->orWhere('employee_id', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function approve(int $id): void
    {
        $leaveApplication = LeaveApplication::findOrFail($id);

        if ($leaveApplication->status !== 'pending') {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'This leave application has already been processed.',
            ]);

            return;
        }

        $leaveApplication->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $this->dispatch('leaveApplicationUpdated');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Leave application approved successfully!',
        ]);
    }

    public function reject(int $id): void
    {
        $leaveApplication = LeaveApplication::findOrFail($id);

        if ($leaveApplication->status !== 'pending') {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'This leave application has already been processed.',
            ]);

            return;
        }

        $this->rejectLeaveId = $id;
        $this->adminRemarks = '';
        $this->dispatch('openRejectModal');
    }

    public function confirmReject(): void
    {
        if (! $this->rejectLeaveId) {
            return;
        }

        $leaveApplication = LeaveApplication::findOrFail($this->rejectLeaveId);

        if ($leaveApplication->status !== 'pending') {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'This leave application has already been processed.',
            ]);

            return;
        }

        $leaveApplication->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_remarks' => $this->adminRemarks,
        ]);

        $this->rejectLeaveId = null;
        $this->adminRemarks = '';
        $this->dispatch('closeRejectModal');
        $this->dispatch('leaveApplicationUpdated');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Leave application rejected successfully!',
        ]);
    }

    public function closeRejectModal(): void
    {
        $this->rejectLeaveId = null;
        $this->adminRemarks = '';
    }

    public function render(): View
    {
        $leaveApplications = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.leave-application-table', [
            'leaveApplications' => $leaveApplications,
        ]);
    }
}
