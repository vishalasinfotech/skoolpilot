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
        <div  wire:loading.remove.delay>
            <table class="table table-bordered table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">#</th>
                        <th wire:click="sortBy('title')" style="cursor: pointer;">
                            Title
                            @if($sortField === 'title')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Section</th>
                        <th wire:click="sortBy('due_date')" style="cursor: pointer;">
                            Due Date
                            @if($sortField === 'due_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Max Marks</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $index => $assignment)
                        <tr wire:key="assignment-{{ $assignment->id }}">
                            <td>{{ str_pad($assignments->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $assignment->title }}">
                                    {{ $assignment->title }}
                                </div>
                            </td>
                            <td>{{ $assignment->academicClass->name ?? '-' }}</td>
                            <td>{{ $assignment->subject->name ?? '-' }}</td>
                            <td>{{ $assignment->section->name ?? 'All Sections' }}</td>
                            <td>
                                <span class="badge bg-{{ $assignment->due_date->isPast() ? 'danger' : 'primary' }}-subtle text-{{ $assignment->due_date->isPast() ? 'danger' : 'primary' }}">
                                    {{ $assignment->due_date->format('M d, Y') }}
                                </span>
                            </td>
                            <td>{{ $assignment->max_marks ?? '-' }}</td>
                            <td>
                                @if($assignment->status === 'published')
                                    <span class="badge bg-success-subtle text-success">Published</span>
                                @elseif($assignment->status === 'closed')
                                    <span class="badge bg-secondary-subtle text-secondary">Closed</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('teacher.assignment.show', $assignment->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('teacher.assignment.edit', $assignment->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        @if($assignment->status === 'draft')
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $assignment->id }}, '{{ $assignment->title }}')">
                                                    <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No assignments found</p>
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
        @if($assignments->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $assignments->firstItem() ?? 0 }} to {{ $assignments->lastItem() ?? 0 }} of {{ $assignments->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
