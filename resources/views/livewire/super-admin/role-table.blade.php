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
                        <input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm ms-2"
                            placeholder="{{ __('common.search_placeholder') }}" style="width: 200px;">
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
                        <th style="width: 80px;">#</th>
                        <th wire:click="sortBy('name')" style="cursor: pointer;">
                            {{ __('common.role_name') }}
                            @if($sortField === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 130px; cursor: pointer;" wire:click="sortBy('permissions_count')">
                            {{ __('common.permissions') }}
                            @if($sortField === 'permissions_count')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 120px;">{{ __('common.guard') }}</th>
                        <th style="width: 200px;">{{ __('common.assigned_permissions') }}</th>
                        <th style="width: 90px;">{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                        <tr wire:key="role-{{ $role->id }}">
                            <td>{{ str_pad($roles->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="fw-medium">{{ $role->name }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    {{ $role->permissions_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ $role->guard_name }}</span>
                            </td>
                            <td>
                                @if($role->permissions && $role->permissions->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($role->permissions->take(6) as $permission)
                                            <span class="badge bg-light text-dark">{{ $permission->name }}</span>
                                        @endforeach
                                        @if($role->permissions->count() > 6)
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                +{{ $role->permissions->count() - 6 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('roles.edit', $role) }}">
                                                <i class="ri-pencil-line align-middle me-1"></i> {{ __('common.edit') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger"
                                                wire:click="openDeleteModal({{ $role->id }}, '{{ $role->name }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> {{ __('common.delete') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-inbox-line fs-48"></i>
                                    <p class="mt-2 mb-0">{{ __('common.no_roles_found') }}</p>
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
        @if($roles->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        {{ __('common.showing') }} {{ $roles->firstItem() ?? 0 }} {{ __('common.to') }} {{ $roles->lastItem() ?? 0 }}
                        {{ __('common.of') }} {{ $roles->total() }} {{ __('common.entries') }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
