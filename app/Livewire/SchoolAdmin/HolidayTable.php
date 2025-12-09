<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Holiday;
use Illuminate\Contracts\View\View;

class HolidayTable extends DataTable
{
    protected function getQuery()
    {
        return Holiday::query()
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
        $holiday = Holiday::query()->findOrFail($id);
        $holiday->delete();

        $this->dispatch('holidayDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Holiday deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'holidayId' => $id,
            'holidayName' => $name,
        ]);
    }

    public function render(): View
    {
        $holidays = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.holiday-table', [
            'holidays' => $holidays,
        ]);
    }
}
