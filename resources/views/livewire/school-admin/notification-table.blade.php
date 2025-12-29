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
                        <th wire:click="sortBy('title')" style="cursor: pointer;">
                            Title
                            @if($sortField === 'title')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('type')" style="cursor: pointer;">
                            Type
                            @if($sortField === 'type')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('total_recipients')" style="cursor: pointer;">
                            Recipients
                            @if($sortField === 'total_recipients')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Email Status</th>
                        <th wire:click="sortBy('sent_at')" style="cursor: pointer;">
                            Sent At
                            @if($sortField === 'sent_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 100px;">{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $index => $notification)
                        <tr wire:key="notification-{{ $notification->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $notification->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($notifications->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <span class="fw-medium">{{ $notification->title }}</span>
                                        @if($notification->template)
                                            <br><small class="text-muted">Template: {{ $notification->template->name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($notification->type === 'role')
                                    <span class="badge bg-info-subtle text-info">By Role</span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary">Specific Users</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">{{ $notification->total_recipients }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-success-subtle text-success">{{ $notification->emails_sent }} sent</span>
                                    @if($notification->emails_failed > 0)
                                        <span class="badge bg-danger-subtle text-danger">{{ $notification->emails_failed }} failed</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($notification->sent_at)
                                    <div>
                                        <span>{{ $notification->sent_at->format('M d, Y') }}</span>
                                        <br><small class="text-muted">{{ $notification->sent_at->format('h:i A') }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.notification.show', $notification->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> {{ __('common.view') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No notifications found.</p>
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
        @if($notifications->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        {{ __('common.showing') }} {{ $notifications->firstItem() ?? 0 }} {{ __('common.to') }} {{ $notifications->lastItem() ?? 0 }} {{ __('common.of') }} {{ $notifications->total() }} {{ __('common.entries') }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
