<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\User;
use Illuminate\Contracts\View\View;

class StaffTable extends DataTable
{
    protected function getQuery()
    {
        return User::query()
            ->staff()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('employee_id', 'like', '%'.$this->search.'%')
                        ->orWhere('designation', 'like', '%'.$this->search.'%')
                        ->orWhere('department', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $staff = User::query()->staff()->findOrFail($id);

        if ($staff->profile_image && file_exists(public_path($staff->profile_image))) {
            unlink(public_path($staff->profile_image));
        }

        $staff->delete();

        $this->dispatch('staffDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Staff member deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'staffId' => $id,
            'staffName' => $name,
        ]);
    }

    public function render(): View
    {
        $staffMembers = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.staff-table', [
            'staffMembers' => $staffMembers,
        ]);
    }
}
