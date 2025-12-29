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
                            Template Name
                            @if($sortField === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('subject')" style="cursor: pointer;">
                            Subject
                            @if($sortField === 'subject')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('is_active')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'is_active')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            Created At
                            @if($sortField === 'created_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 120px;">{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $index => $template)
                        <tr wire:key="template-{{ $template->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $template->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($templates->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <span class="fw-medium">{{ $template->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $template->subject }}">
                                    {{ $template->subject }}
                                </span>
                            </td>
                            <td>
                                @if($template->is_active)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $template->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.notification-template.show', $template->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> {{ __('common.view') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.notification-template.edit', $template->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('common.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" wire:click="toggleStatus({{ $template->id }})">
                                                <i class="ri-toggle-{{ $template->is_active ? 'off' : 'on' }}-fill align-bottom me-2 text-muted"></i>
                                                {{ $template->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $template->id }}, '{{ $template->name }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> {{ __('common.delete') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No templates found.</p>
                                    @if($search)
                                        <small>Try adjusting your search criteria.</small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($templates->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        {{ __('common.showing') }} {{ $templates->firstItem() ?? 0 }} {{ __('common.to') }} {{ $templates->lastItem() ?? 0 }} {{ __('common.of') }} {{ $templates->total() }} {{ __('common.entries') }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $templates->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
