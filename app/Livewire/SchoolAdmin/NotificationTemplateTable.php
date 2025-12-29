<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\NotificationTemplate;
use Illuminate\Contracts\View\View;

class NotificationTemplateTable extends DataTable
{
    public $sortField = 'created_at';

    protected function getQuery()
    {
        return NotificationTemplate::query()
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('subject', 'like', '%'.$this->search.'%')
                        ->orWhere('body', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $template = NotificationTemplate::findOrFail($id);

        // Check if user has permission
        if ($template->school_id !== auth()->user()->school_id) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'You do not have permission to delete this template.',
            ]);

            return;
        }

        $template->delete();

        $this->dispatch('templateDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Notification template deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'templateId' => $id,
            'templateName' => $name,
        ]);
    }

    public function toggleStatus(int $id): void
    {
        $template = NotificationTemplate::findOrFail($id);

        // Check if user has permission
        if ($template->school_id !== auth()->user()->school_id) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'You do not have permission to update this template.',
            ]);

            return;
        }

        $template->update([
            'is_active' => ! $template->is_active,
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Template status updated successfully!',
        ]);
    }

    public function render(): View
    {
        $templates = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.notification-template-table', [
            'templates' => $templates,
        ]);
    }
}
