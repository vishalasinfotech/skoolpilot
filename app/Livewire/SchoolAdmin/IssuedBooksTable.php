<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\BookIssue;
use Illuminate\Contracts\View\View;

class IssuedBooksTable extends DataTable
{
    protected function getQuery()
    {
        return BookIssue::query()
            ->with(['library', 'user', 'school'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('library', function ($libraryQuery) {
                        $libraryQuery->where('book_title', 'like', '%'.$this->search.'%')
                            ->orWhere('author', 'like', '%'.$this->search.'%')
                            ->orWhere('isbn', 'like', '%'.$this->search.'%');
                    })
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('first_name', 'like', '%'.$this->search.'%')
                                ->orWhere('last_name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%')
                                ->orWhere('admission_number', 'like', '%'.$this->search.'%')
                                ->orWhere('employee_id', 'like', '%'.$this->search.'%');
                        })
                        ->orWhere('status', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render(): View
    {
        $bookIssues = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.issued-books-table', [
            'bookIssues' => $bookIssues,
        ]);
    }
}
