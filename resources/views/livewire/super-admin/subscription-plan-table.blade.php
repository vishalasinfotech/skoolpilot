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
                        <th wire:click="sortBy('name')" style="cursor: pointer;">
                            Plan Name
                            @if($sortField === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('type')" style="cursor: pointer;">
                            Type
                            @if($sortField === 'type')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('tier')" style="cursor: pointer;">
                            Tier
                            @if($sortField === 'tier')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('price')" style="cursor: pointer;">
                            Price
                            @if($sortField === 'price')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 100px;">Plan Type</th>
                        <th style="width: 100px;">Trial Days</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptionPlans as $index => $plan)
                        <tr wire:key="subscription-plan-{{ $plan->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $plan->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($subscriptionPlans->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $plan->name }}</span>
                                    @if($plan->features && count($plan->features) > 0)
                                        <small class="text-muted">{{ count($plan->features) }} features</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    {{ ucfirst($plan->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($plan->tier === 'basic') bg-secondary-subtle text-secondary
                                    @elseif($plan->tier === 'standard') bg-primary-subtle text-primary
                                    @else bg-warning-subtle text-warning
                                    @endif
                                ">
                                    {{ ucfirst($plan->tier) }}
                                </span>
                            </td>
                            <td>
                                @if($plan->offer_price && $plan->offer_price < $plan->price)
                                    <div>
                                        <span class="text-decoration-line-through text-muted">${{ number_format($plan->price, 2) }}</span>
                                        <span class="fw-bold text-success ms-1">${{ number_format($plan->offer_price, 2) }}</span>
                                        <span class="badge bg-danger-subtle text-danger ms-1">OFFER</span>
                                    </div>
                                @else
                                    <span class="fw-medium">${{ number_format($plan->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($plan->plan_status === 'free') bg-success-subtle text-success
                                    @else bg-primary-subtle text-primary
                                    @endif
                                ">
                                    {{ ucfirst($plan->plan_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $plan->trial_days }} days</span>
                            </td>
                            <td>
                                @if($plan->is_active)
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
                                            <a class="dropdown-item" href="{{ route('super-admin.subscription-plan.show', $plan->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('super-admin.subscription-plan.edit', $plan->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $plan->id }}, '{{ $plan->name }}')">
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
                                    <p class="mt-2 mb-0">No subscription plans found</p>
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
        @if($subscriptionPlans->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $subscriptionPlans->firstItem() ?? 0 }} to {{ $subscriptionPlans->lastItem() ?? 0 }} of {{ $subscriptionPlans->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $subscriptionPlans->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
