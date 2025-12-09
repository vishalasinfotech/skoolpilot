<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\FeeStructure;
use Illuminate\Contracts\View\View;

class FeeStructureTable extends DataTable
{
    protected function getQuery()
    {
        return FeeStructure::query()
            ->with(['school', 'academicClass'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('fee_type', 'like', '%'.$this->search.'%')
                        ->orWhere('fee_name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $feeStructure = FeeStructure::query()->findOrFail($id);
        $feeStructure->delete();

        $this->dispatch('feeStructureDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Fee structure deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'feeStructureId' => $id,
            'feeStructureName' => $name,
        ]);
    }

    public function render(): View
    {
        $feeStructures = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.fee-structure-table', [
            'feeStructures' => $feeStructures,
        ]);
    }
}
