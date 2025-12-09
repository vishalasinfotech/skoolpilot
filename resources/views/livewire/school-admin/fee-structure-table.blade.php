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
                        <th wire:click="sortBy('fee_name')" style="cursor: pointer;">
                            Fee Name
                            @if($sortField === 'fee_name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Fee Type</th>
                        <th>Class</th>
                        <th wire:click="sortBy('amount')" style="cursor: pointer;">
                            Amount
                            @if($sortField === 'amount')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Frequency</th>
                        <th>Effective Period</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feeStructures as $index => $feeStructure)
                        <tr wire:key="fee-structure-{{ $feeStructure->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $feeStructure->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($feeStructures->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="fw-medium">{{ $feeStructure->fee_name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ $feeStructure->fee_type }}</span>
                            </td>
                            <td>{{ $feeStructure->academicClass->name ?? 'All Classes' }}</td>
                            <td>
                                <span class="fw-semibold">{{ number_format($feeStructure->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ ucfirst(str_replace('_', ' ', $feeStructure->frequency)) }}</span>
                            </td>
                            <td>
                                @if($feeStructure->effective_from && $feeStructure->effective_to)
                                    {{ $feeStructure->effective_from->format('d M Y') }} - {{ $feeStructure->effective_to->format('d M Y') }}
                                @elseif($feeStructure->effective_from)
                                    From {{ $feeStructure->effective_from->format('d M Y') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($feeStructure->is_active)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.fee-structure.show', $feeStructure->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.fee-structure.edit', $feeStructure->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $feeStructure->id }}, '{{ $feeStructure->fee_name }}')">
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
                                    <p class="mt-2 mb-0">No fee structures found</p>
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
        @if($feeStructures->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $feeStructures->firstItem() ?? 0 }} to {{ $feeStructures->lastItem() ?? 0 }} of {{ $feeStructures->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $feeStructures->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
