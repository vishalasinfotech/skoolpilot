<div>
    <div class="card-body">
        <!-- Search and Per Page Controls -->
        <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length">
                    <label class="d-inline-flex align-items-center">
                        Show
                        <select wire:model.live="perPage" class="form-select form-select-sm mx-2" style="width: auto;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        entries
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_filter text-md-end">
                    <label class="d-inline-flex align-items-center">
                        Search:
                        <input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm ms-2" placeholder="Search..." style="width: 200px;">
                    </label>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading.delay class="text-center py-3">
            <div class="spinner-border text-primary spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="ms-2">Loading...</span>
        </div>

        <!-- Table -->
        <div class="table-responsive" wire:loading.remove.delay>
            <table class="table table-bordered table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" wire:model.live="selectAll" class="form-check-input">
                        </th>
                        <th style="width: 80px;">#</th>
                        <th wire:click="sortBy('transaction_number')" style="cursor: pointer;">
                            Transaction #
                            @if($sortField === 'transaction_number')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Student</th>
                        <th>Fee Structure</th>
                        <th wire:click="sortBy('transaction_date')" style="cursor: pointer;">
                            Date
                            @if($sortField === 'transaction_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('amount')" style="cursor: pointer;">
                            Amount
                            @if($sortField === 'amount')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Payment Method</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feeCollections as $index => $feeCollection)
                        <tr wire:key="fee-collection-{{ $feeCollection->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $feeCollection->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($feeCollections->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="fw-medium">{{ $feeCollection->transaction_number }}</span>
                                @if($feeCollection->receipt_number)
                                    <br><small class="text-muted">RCP: {{ $feeCollection->receipt_number }}</small>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $feeCollection->student->full_name ?? 'N/A' }}</span>
                                    @if($feeCollection->student)
                                        <br><small class="text-muted">{{ $feeCollection->student->admission_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $feeCollection->feeStructure->fee_name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $feeCollection->transaction_date->format('d M Y') }}
                            </td>
                            <td>
                                <span class="fw-semibold">₹{{ number_format($feeCollection->amount, 2) }}</span>
                            </td>
                            <td>
                                @if($feeCollection->payment_method === 'cash')
                                    <span class="badge bg-success-subtle text-success">Cash</span>
                                @elseif($feeCollection->payment_method === 'bank')
                                    <span class="badge bg-info-subtle text-info">Bank</span>
                                    @if($feeCollection->bank_name)
                                        <br><small class="text-muted">{{ $feeCollection->bank_name }}</small>
                                    @endif
                                @elseif($feeCollection->payment_method === 'cheque')
                                    <span class="badge bg-warning-subtle text-warning">Cheque</span>
                                    @if($feeCollection->cheque_number)
                                        <br><small class="text-muted">#{{ $feeCollection->cheque_number }}</small>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($feeCollection->status === 'completed')
                                    <span class="badge bg-success-subtle text-success">Completed</span>
                                @elseif($feeCollection->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.fee-collection.show', $feeCollection->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.fee-collection.edit', $feeCollection->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $feeCollection->id }}, '{{ $feeCollection->transaction_number }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No fee transactions found</p>
                                    @if($search)
                                        <small>Try adjusting your search</small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($feeCollections->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $feeCollections->firstItem() ?? 0 }} to {{ $feeCollections->lastItem() ?? 0 }} of {{ $feeCollections->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $feeCollections->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
