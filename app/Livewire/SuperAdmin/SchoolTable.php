<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Components\DataTable;
use App\Models\School;
use Illuminate\Contracts\View\View;

class SchoolTable extends DataTable
{
    protected function getQuery()
    {
        return School::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $school = School::query()->findOrFail($id);
        $school->delete();

        $this->dispatch('schoolDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'School deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'schoolId' => $id,
            'schoolName' => $name,
        ]);
    }

    public function render(): View
    {
        $schools = $this->getQuery()->paginate($this->perPage);

        return view('livewire.super-admin.school-table', [
            'schools' => $schools,
        ]);
    }
}
