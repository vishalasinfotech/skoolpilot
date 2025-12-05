<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;

/**
 * Reusable DataTable Component
 *
 * This component provides a base for creating data tables with:
 * - Search functionality
 * - Sortable columns
 * - Pagination
 * - Row selection
 * - Configurable items per page
 *
 * Usage:
 * 1. Extend this class in your custom table component
 * 2. Override getQuery() to return your model query with search/sort logic
 * 3. Create a blade view for your table structure
 * 4. Use @livewire('your-component-name') in your page
 *
 * @see App\Livewire\SuperAdmin\SchoolTable for a complete example
 */
class DataTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $perPage = 10;

    public $sortField = 'id';

    public $sortDirection = 'desc';

    public $selectedRows = [];

    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedRows = $this->getQuery()->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    protected function getQuery()
    {
        // Override this method in child components
        return collect([]);
    }

    public function render()
    {
        return view('livewire.components.data-table');
    }
}
