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
                        <th style="width: 80px;">#</th>
                        <th>{{ __('common.language_code') }}</th>
                        <th>{{ __('common.language_name') }}</th>
                        <th>{{ __('common.native_name') }}</th>
                        <th style="width: 100px;">{{ __('common.status') }}</th>
                        <th style="width: 100px;">{{ __('common.default') }}</th>
                        <th style="width: 80px;">{{ __('common.sort_order') }}</th>
                        <th style="width: 150px;">{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($languages as $index => $language)
                        <tr wire:key="language-{{ $language->id }}">
                            <td>{{ str_pad($languages->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ strtoupper($language->code) }}</span>
                            </td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->native_name ?? '-' }}</td>
                            <td>
                                @if($language->is_active)
                                    <span class="badge bg-success-subtle text-success">{{ __('common.active') }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($language->is_default)
                                    <span class="badge bg-info-subtle text-info">{{ __('common.default') }}</span>
                                @else
                                    <form action="{{ route('super-admin.language.set-default', $language) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-soft-info"
                                                title="{{ __('common.set_as_default') }}"
                                                @if(!$language->is_active) disabled @endif>
                                            <i class="ri-star-line"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>{{ $language->sort_order }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('super-admin.language.edit', $language) }}">
                                                <i class="ri-pencil-line align-middle me-1"></i> {{ __('common.edit') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            @if(!$language->is_default)
                                                <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $language->id }}, '{{ $language->name }}', '{{ $language->code }}')">
                                                    <i class="ri-delete-bin-fill align-bottom me-2"></i> {{ __('common.delete') }}
                                                </button>
                                            @else
                                                <span class="dropdown-item text-muted" style="cursor: not-allowed;">
                                                    <i class="ri-delete-bin-fill align-bottom me-2"></i> {{ __('common.delete') }}
                                                </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-inbox-line fs-48"></i>
                                    <p class="mt-2">{{ __('common.no_languages_found') }}</p>
                                    <p class="text-muted small">{{ __('common.try_adjusting_search') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row mt-3">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info">
                    {{ __('common.showing') }} {{ $languages->firstItem() ?? 0 }} {{ __('common.to') }} {{ $languages->lastItem() ?? 0 }} {{ __('common.of') }} {{ $languages->total() }} {{ __('common.entries') }}
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $languages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
