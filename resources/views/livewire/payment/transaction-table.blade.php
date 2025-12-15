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
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            Transaction ID
                            @if($sortField === 'created_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>School</th>
                        <th>Plan</th>
                        <th wire:click="sortBy('amount')" style="cursor: pointer;">
                            Amount
                            @if($sortField === 'amount')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Payment Method</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('paid_at')" style="cursor: pointer;">
                            Paid At
                            @if($sortField === 'paid_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('expires_at')" style="cursor: pointer;">
                            Expires At
                            @if($sortField === 'expires_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $index => $transaction)
                        <tr wire:key="transaction-{{ $transaction->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $transaction->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($transactions->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div>
                                    <span class="fw-medium">#{{ $transaction->id }}</span>
                                    @if($transaction->razorpay_order_id)
                                        <br><small class="text-muted">{{ $transaction->razorpay_order_id }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $transaction->school->name ?? 'N/A' }}</span>
                                    @if($transaction->school)
                                        <br><small class="text-muted">{{ $transaction->school->email ?? '' }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ $transaction->subscriptionPlan->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold">₹{{ number_format($transaction->amount, 2) }}</span>
                                <br><small class="text-muted">{{ $transaction->currency }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                            </td>
                            <td>
                                @if($transaction->status === 'completed')
                                    <span class="badge bg-success-subtle text-success">Completed</span>
                                @elseif($transaction->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                @elseif($transaction->status === 'processing')
                                    <span class="badge bg-info-subtle text-info">Processing</span>
                                @elseif($transaction->status === 'failed')
                                    <span class="badge bg-danger-subtle text-danger">Failed</span>
                                @elseif($transaction->status === 'cancelled')
                                    <span class="badge bg-secondary-subtle text-secondary">Cancelled</span>
                                @elseif($transaction->status === 'refunded')
                                    <span class="badge bg-primary-subtle text-primary">Refunded</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($transaction->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->paid_at)
                                    <div>
                                        <span>{{ $transaction->paid_at->format('d M Y') }}</span>
                                        <br><small class="text-muted">{{ $transaction->paid_at->format('h:i A') }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->expires_at)
                                    <div>
                                        <span>{{ $transaction->expires_at->format('d M Y') }}</span>
                                        <br>
                                        @if($transaction->expires_at->isPast())
                                            <small class="text-danger">Expired</small>
                                        @elseif($transaction->expires_at->isToday())
                                            <small class="text-warning">Expires Today</small>
                                        @else
                                            <small class="text-muted">{{ $transaction->expires_at->diffForHumans() }}</small>
                                        @endif
                                    </div>
                                @else
                                    <span class="badge bg-primary-subtle text-primary">Lifetime</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('payment.transaction.show', $transaction->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Invoice
                                            </a>
                                        </li>
                                        @if($transaction->razorpay_payment_id && $transaction->status === 'completed')
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Refund functionality coming soon!')">
                                                    <i class="ri-refund-line align-bottom me-2 text-muted"></i> Refund
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No transactions found</p>
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
        @if($transactions->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
