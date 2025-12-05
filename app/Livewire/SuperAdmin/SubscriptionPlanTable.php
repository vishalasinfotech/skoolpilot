<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Components\DataTable;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\View\View;

class SubscriptionPlanTable extends DataTable
{
    protected function getQuery()
    {
        return SubscriptionPlan::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('type', 'like', '%'.$this->search.'%')
                        ->orWhere('tier', 'like', '%'.$this->search.'%')
                        ->orWhere('plan_status', 'like', '%'.$this->search.'%')
                        ->orWhere('price', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $subscriptionPlan = SubscriptionPlan::query()->findOrFail($id);
        $subscriptionPlan->delete();

        $this->dispatch('subscriptionPlanDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Subscription plan deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'subscriptionPlanId' => $id,
            'subscriptionPlanName' => $name,
        ]);
    }

    public function render(): View
    {
        $subscriptionPlans = $this->getQuery()->paginate($this->perPage);

        return view('livewire.super-admin.subscription-plan-table', [
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }
}
