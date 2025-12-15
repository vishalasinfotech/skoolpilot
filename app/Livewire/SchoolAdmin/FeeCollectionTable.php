<?php

namespace App\Livewire\SchoolAdmin;

use App\Livewire\Components\DataTable;
use App\Models\StudentFeeTransaction;
use Illuminate\Contracts\View\View;

class FeeCollectionTable extends DataTable
{
    protected function getQuery()
    {
        return StudentFeeTransaction::query()
            ->with(['student', 'feeStructure', 'academicSession', 'collectedBy', 'school'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_number', 'like', '%'.$this->search.'%')
                        ->orWhere('receipt_number', 'like', '%'.$this->search.'%')
                        ->orWhere('amount', 'like', '%'.$this->search.'%')
                        ->orWhereHas('student', function ($studentQuery) {
                            $studentQuery->where('first_name', 'like', '%'.$this->search.'%')
                                ->orWhere('last_name', 'like', '%'.$this->search.'%')
                                ->orWhere('admission_number', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('feeStructure', function ($feeQuery) {
                            $feeQuery->where('fee_name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $transaction = StudentFeeTransaction::query()->findOrFail($id);
        $transaction->delete();

        $this->dispatch('feeCollectionDeleted');
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Fee transaction deleted successfully!',
        ]);
    }

    public function openDeleteModal(int $id, string $transactionNumber): void
    {
        $this->dispatch('openDeleteModal', [
            'feeCollectionId' => $id,
            'feeCollectionNumber' => $transactionNumber,
        ]);
    }

    public function render(): View
    {
        $feeCollections = $this->getQuery()->paginate($this->perPage);

        return view('livewire.school-admin.fee-collection-table', [
            'feeCollections' => $feeCollections,
        ]);
    }
}
