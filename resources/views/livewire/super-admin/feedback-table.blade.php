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
        <div class="" wire:loading.remove.delay>
            <table class="table table-bordered table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">#</th>
                        <th wire:click="sortBy('subject')" style="cursor: pointer;">
                            {{ __('common.subject') }}
                            @if($sortField === 'subject')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>{{ __('common.type') }}</th>
                        <th>{{ __('common.created_by') }}</th>
                        <th>{{ __('common.all_schools') }}</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            {{ __('common.status') }}
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            {{ __('common.created_at') }}
                            @if($sortField === 'created_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 80px;">{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $index => $feedback)
                        <tr wire:key="feedback-{{ $feedback->id }}">
                            <td>{{ str_pad($feedbacks->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="fw-medium">{{ Str::limit($feedback->subject, 50) }}</div>
                                <small class="text-muted">{{ Str::limit($feedback->message, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    {{ ucfirst($feedback->type) }}
                                </span>
                            </td>
                            <td>
                                {{ $feedback->createdBy->full_name ?? $feedback->createdBy->name ?? __('common.n_a') }}
                                <br><small class="text-muted">{{ $feedback->createdBy->email ?? __('common.n_a') }}</small>
                            </td>
                            <td>{{ $feedback->school->name ?? __('common.n_a') }}</td>
                            <td>
                                @if($feedback->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning">{{ __('common.pending') }}</span>
                                @elseif($feedback->status === 'in_progress')
                                    <span class="badge bg-primary-subtle text-primary">{{ __('common.in_progress') }}</span>
                                @elseif($feedback->status === 'resolved')
                                    <span class="badge bg-success-subtle text-success">{{ __('common.resolved') }}</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">{{ __('common.closed') }}</span>
                                @endif
                            </td>
                            <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('super-admin.feedback.show', $feedback->id) }}">
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
                                    <p class="mt-2 mb-0">{{ __('common.no_feedback_found') }}</p>
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
        @if($feedbacks->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        {{ __('common.showing') }} {{ $feedbacks->firstItem() ?? 0 }} {{ __('common.to') }} {{ $feedbacks->lastItem() ?? 0 }} {{ __('common.of') }} {{ $feedbacks->total() }} {{ __('common.entries') }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
