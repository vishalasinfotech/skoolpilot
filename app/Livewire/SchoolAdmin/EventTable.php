<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class EventTable extends DataTable
{
    protected function getQuery()
    {
        return Event::query()
            ->with('school')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('location', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $event = Event::query()->findOrFail($id);
        $event->delete();

        $this->dispatch('eventDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Event deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $title): void
    {
        $this->dispatch('openDeleteModal', [
            'eventId' => $id,
            'eventTitle' => $title,
        ]);
    }

    public function render(): View
    {
        $events = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.event-table', [
            'events' => $events,
        ]);
    }
}
