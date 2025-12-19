<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Components\DataTable;
use App\Models\School;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\View\View;

class SchoolTable extends DataTable
{
    public $statusFilter = '';

    public $planFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => ''],
        'planFilter' => ['except' => ''],
    ];

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPlanFilter(): void
    {
        $this->resetPage();
    }

    protected function getQuery()
    {
        return School::query()
            ->with('subscriptionPlan')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->planFilter !== '', function ($query) {
                $query->where('subscription_plan_id', $this->planFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $school = School::query()->findOrFail($id);
        $school->delete();

        $this->dispatch('schoolDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'School deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'schoolId' => $id,
            'schoolName' => $name,
        ]);
    }

    public function render(): View
    {
        $schools = $this->getQuery()->paginate($this->perPage);
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->orderBy('name')->get();

        return view('livewire.super-admin.school-table', [
            'schools' => $schools,
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }
}
