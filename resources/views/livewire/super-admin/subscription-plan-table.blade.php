<div>
    <div class="card-body">
        <!-- Search and Per Page Controls -->
        <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length">
                    <label class="d-inline-flex align-items-center">
                        {{ __('common.show') }}
                        <select wire:model.live="perPage" class="form-select form-select-sm mx-2" style="width: auto;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        {{ __('common.entries') }}
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_filter text-md-end">
                    <label class="d-inline-flex align-items-center">
                        {{ __('common.search') }}:
                        <input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm ms-2" placeholder="{{ __('common.search_placeholder') }}" style="width: 200px;">
                    </label>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading.delay class="text-center py-3">
            <div class="spinner-border text-primary spinner-border-sm" role="status">
                <span class="visually-hidden">{{ __('common.loading') }}</span>
            </div>
            <span class="ms-2">{{ __('common.loading') }}</span>
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
                            {{ __('common.plan_name') }}
                            @if($sortField === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('type')" style="cursor: pointer;">
                            {{ __('common.plan_type') }}
                            @if($sortField === 'type')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('tier')" style="cursor: pointer;">
                            {{ __('common.tier') }}
                            @if($sortField === 'tier')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('price')" style="cursor: pointer;">
                            {{ __('common.price') }}
                            @if($sortField === 'price')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 100px;">{{ __('common.plan_status') }}</th>
                        <th style="width: 100px;">{{ __('common.days') }}</th>
                        <th style="width: 100px;">{{ __('common.status') }}</th>
                        <th style="width: 80px;">{{ __('common.action') }}</th>
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
                                        <small class="text-muted">{{ count($plan->features) }} {{ __('common.features_count') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    @if($plan->type === 'monthly') {{ __('common.monthly') }}
                                    @elseif($plan->type === 'quarterly') {{ __('common.quarterly') }}
                                    @elseif($plan->type === 'yearly') {{ __('common.yearly') }}
                                    @elseif($plan->type === 'lifetime') {{ __('common.lifetime') }}
                                    @else {{ ucfirst($plan->type) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge
                                    @if($plan->tier === 'basic') bg-secondary-subtle text-secondary
                                    @elseif($plan->tier === 'standard') bg-primary-subtle text-primary
                                    @else bg-warning-subtle text-warning
                                    @endif
                                ">
                                    @if($plan->tier === 'basic') {{ __('common.basic') }}
                                    @elseif($plan->tier === 'standard') {{ __('common.standard') }}
                                    @elseif($plan->tier === 'premium') {{ __('common.premium') }}
                                    @else {{ ucfirst($plan->tier) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($plan->offer_price && $plan->offer_price < $plan->price)
                                    <div>
                                        <span class="text-decoration-line-through text-muted">${{ number_format($plan->price, 2) }}</span>
                                        <span class="fw-bold text-success ms-1">${{ number_format($plan->offer_price, 2) }}</span>
                                        <span class="badge bg-danger-subtle text-danger ms-1">{{ __('common.offer') }}</span>
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
                                    @if($plan->plan_status === 'free') {{ __('common.free') }}
                                    @elseif($plan->plan_status === 'paid') {{ __('common.paid') }}
                                    @else {{ ucfirst($plan->plan_status) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $plan->trial_days }} {{ __('common.days') }}</span>
                            </td>
                            <td>
                                @if($plan->is_active)
                                    <span class="badge bg-success-subtle text-success">{{ __('common.active') }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">{{ __('common.inactive') }}</span>
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
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> {{ __('common.view') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('super-admin.subscription-plan.edit', $plan->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('common.edit') }}
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $plan->id }}, '{{ $plan->name }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> {{ __('common.delete') }}
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
                                    <p class="mt-2 mb-0">{{ __('common.no_subscription_plans_found') }}</p>
                                    @if($search)
                                        <small>{{ __('common.try_adjusting_search') }}</small>
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
                        {{ __('common.showing') }} {{ $subscriptionPlans->firstItem() ?? 0 }} {{ __('common.to') }} {{ $subscriptionPlans->lastItem() ?? 0 }} {{ __('common.of') }} {{ $subscriptionPlans->total() }} {{ __('common.entries') }}
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
