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
                        <th wire:click="sortBy('book_title')" style="cursor: pointer;">
                            Book Title
                            @if($sortField === 'book_title')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('author')" style="cursor: pointer;">
                            Author
                            @if($sortField === 'author')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>ISBN</th>
                        <th>Category</th>
                        <th>Total Copies</th>
                        <th>Available</th>
                        <th>Price</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($libraries as $index => $library)
                        <tr wire:key="library-{{ $library->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $library->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($libraries->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($library->book_image)
                                        @php
                                            $imagePath = public_path($library->book_image);
                                        @endphp
                                        @if(file_exists($imagePath))
                                            <img src="{{ asset($library->book_image) }}" alt="{{ $library->book_title }}"
                                                class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                                        @endif
                                    @endif
                                    <div class="ms-2">
                                        <span class="fw-medium">{{ $library->book_title }}</span>
                                        @if($library->publisher)
                                            <br><small class="text-muted">{{ $library->publisher }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $library->author }}</td>
                            <td>{{ $library->isbn ?? 'N/A' }}</td>
                            <td>{{ $library->category ?? 'N/A' }}</td>
                            <td>{{ $library->total_copies }}</td>
                            <td>
                                <span class="badge {{ $library->available_copies > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                    {{ $library->available_copies }}
                                </span>
                            </td>
                            <td>{{ $library->price ? '₹' . number_format($library->price, 2) : 'N/A' }}</td>
                            <td>
                                @if($library->is_active)
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
                                            <a class="dropdown-item" href="{{ route('school-admin.library.show', $library->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.library.edit', $library->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $library->id }}, '{{ $library->book_title }}')">
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
                                    <p class="mt-2 mb-0">No books found</p>
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
        @if($libraries->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $libraries->firstItem() ?? 0 }} to {{ $libraries->lastItem() ?? 0 }} of {{ $libraries->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $libraries->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
