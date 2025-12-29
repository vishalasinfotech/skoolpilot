<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\CustomNotification;
use Illuminate\Contracts\View\View;

class NotificationTable extends DataTable
{
    public $sortField = 'created_at';

    protected function getQuery()
    {
        return CustomNotification::query()
            ->with(['sender', 'template'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('message', 'like', '%'.$this->search.'%')
                        ->orWhere('type', 'like', '%'.$this->search.'%')
                        ->orWhereHas('sender', function ($senderQuery) {
                            $senderQuery->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('template', function ($templateQuery) {
                            $templateQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render(): View
    {
        $notifications = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.notification-table', [
            'notifications' => $notifications,
        ]);
    }
}
