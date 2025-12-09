<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Section;
use Illuminate\Contracts\View\View;

class SectionTable extends DataTable
{
    protected function getQuery()
    {
        return Section::query()
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
        $section = Section::query()->findOrFail($id);
        $section->delete();

        $this->dispatch('sectionDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Section deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'sectionId' => $id,
            'sectionName' => $name,
        ]);
    }

    public function render(): View
    {
        $sections = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.section-table', [
            'sections' => $sections,
        ]);
    }
}
