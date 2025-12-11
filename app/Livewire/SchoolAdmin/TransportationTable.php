<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Transportation;
use Illuminate\Contracts\View\View;

class TransportationTable extends DataTable
{
    protected function getQuery()
    {
        return Transportation::query()
            ->with('school')
            // ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('vehicle_number', 'like', '%'.$this->search.'%')
                        ->orWhere('driver_name', 'like', '%'.$this->search.'%')
                        ->orWhere('driver_phone', 'like', '%'.$this->search.'%')
                        ->orWhere('driver_license_number', 'like', '%'.$this->search.'%')
                        ->orWhere('route_name', 'like', '%'.$this->search.'%')
                        ->orWhere('vehicle_type', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $transportation = Transportation::findOrFail($id);
        $transportation->delete();

        $this->dispatch('transportationDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Vehicle deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $vehicleNumber): void
    {
        $this->dispatch('openDeleteModal', [
            'transportationId' => $id,
            'transportationVehicleNumber' => $vehicleNumber,
        ]);
    }

    public function render(): View
    {
        $transportations = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.transportation-table', [
            'transportations' => $transportations,
        ]);
    }
}
