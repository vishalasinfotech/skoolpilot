<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\Library;
use Illuminate\Contracts\View\View;

class LibraryTable extends DataTable
{
    protected function getQuery()
    {
        return Library::query()
            ->with('school')
            // ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('book_title', 'like', '%'.$this->search.'%')
                        ->orWhere('author', 'like', '%'.$this->search.'%')
                        ->orWhere('isbn', 'like', '%'.$this->search.'%')
                        ->orWhere('publisher', 'like', '%'.$this->search.'%')
                        ->orWhere('category', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $library = Library::findOrFail($id);

        if ($library->book_image && file_exists(public_path($library->book_image))) {
            unlink(public_path($library->book_image));
        }

        $library->delete();

        $this->dispatch('libraryDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Book deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $title): void
    {
        $this->dispatch('openDeleteModal', [
            'libraryId' => $id,
            'libraryTitle' => $title,
        ]);
    }

    public function render(): View
    {
        $libraries = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.library-table', [
            'libraries' => $libraries,
        ]);
    }
}
