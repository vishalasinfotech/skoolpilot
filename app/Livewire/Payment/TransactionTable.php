<?php

namespace App\Livewire\Payment;

use App\Livewire\Components\DataTable;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;

class TransactionTable extends DataTable
{
    public $sortField = 'created_at';

    protected function getQuery()
    {
        return Transaction::query()
            ->with(['school', 'subscriptionPlan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('razorpay_order_id', 'like', '%'.$this->search.'%')
                        ->orWhere('razorpay_payment_id', 'like', '%'.$this->search.'%')
                        ->orWhere('amount', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%')
                        ->orWhere('payment_method', 'like', '%'.$this->search.'%')
                        ->orWhereHas('school', function ($schoolQuery) {
                            $schoolQuery->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('subscriptionPlan', function ($planQuery) {
                            $planQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render(): View
    {
        $transactions = $this->getQuery()->paginate($this->perPage);

        return view('livewire.payment.transaction-table', [
            'transactions' => $transactions,
        ]);
    }
}
