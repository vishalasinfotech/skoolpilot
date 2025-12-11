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
                        <th wire:click="sortBy('vehicle_number')" style="cursor: pointer;">
                            Vehicle Number
                            @if($sortField === 'vehicle_number')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('vehicle_type')" style="cursor: pointer;">
                            Vehicle Type
                            @if($sortField === 'vehicle_type')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Driver Name</th>
                        <th>Driver Phone</th>
                        <th>Capacity</th>
                        <th>Route</th>
                        <th>Fare (₹)</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transportations as $index => $transportation)
                        <tr wire:key="transportation-{{ $transportation->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $transportation->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($transportations->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="fw-medium">{{ $transportation->vehicle_number }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ ucfirst($transportation->vehicle_type) }}</span>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $transportation->driver_name }}</span>
                                    @if($transportation->driver_license_number)
                                        <br><small class="text-muted">License: {{ $transportation->driver_license_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $transportation->driver_phone }}</td>
                            <td>{{ $transportation->capacity }} seats</td>
                            <td>{{ $transportation->route_name ?? 'N/A' }}</td>
                            <td>{{ $transportation->fare_amount ? '₹' . number_format($transportation->fare_amount, 2) : 'N/A' }}</td>
                            <td>
                                @if($transportation->is_active)
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
                                            <a class="dropdown-item" href="{{ route('school-admin.transportation.show', $transportation->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.transportation.edit', $transportation->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $transportation->id }}, '{{ $transportation->vehicle_number }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No vehicles found</p>
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
        @if($transportations->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $transportations->firstItem() ?? 0 }} to {{ $transportations->lastItem() ?? 0 }} of {{ $transportations->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $transportations->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
