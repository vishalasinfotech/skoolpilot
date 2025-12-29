<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\AcademicSession;
use Illuminate\Contracts\View\View;

class AcademicSessionTable extends DataTable
{
    protected function getQuery()
    {
        return AcademicSession::query()
            ->with('school')
            ->where('school_id', auth()->user()->school_id)
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
        $academicSession = AcademicSession::query()->findOrFail($id);
        $academicSession->delete();

        $this->dispatch('academicSessionDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Academic session deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'academicSessionId' => $id,
            'academicSessionName' => $name,
        ]);
    }

    public function render(): View
    {
        $academicSessions = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.academic-session-table', [
            'academicSessions' => $academicSessions,
        ]);
    }
}
