<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\AcademicClass;
use Illuminate\Contracts\View\View;

class AcademicClassTable extends DataTable
{
    protected function getQuery()
    {
        return AcademicClass::query()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $academicClass = AcademicClass::query()->findOrFail($id);
        $academicClass->delete();

        $this->dispatch('academicClassDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Academic class deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'academicClassId' => $id,
            'academicClassName' => $name,
        ]);
    }

    public function render(): View
    {
        $academicClasses = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.academic-class-table', [
            'academicClasses' => $academicClasses,
        ]);
    }
}
