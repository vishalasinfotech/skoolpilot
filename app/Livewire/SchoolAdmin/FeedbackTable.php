<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Feedback;
use Illuminate\Contracts\View\View;

class FeedbackTable extends DataTable
{
    public $sortField = 'created_at';

    protected function getQuery()
    {
        $schoolId = auth()->user()->school_id;

        return Feedback::query()
            ->where('school_id', $schoolId)
            ->with(['createdBy'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('subject', 'like', '%'.$this->search.'%')
                        ->orWhere('message', 'like', '%'.$this->search.'%')
                        ->orWhere('type', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%')
                        ->orWhereHas('createdBy', function ($userQuery) {
                            $userQuery->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render(): View
    {
        $feedbacks = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.feedback-table', [
            'feedbacks' => $feedbacks,
        ]);
    }
}
