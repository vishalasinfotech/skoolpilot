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
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            Student
                            @if($sortField === 'created_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Exam</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th wire:click="sortBy('obtained_marks')" style="cursor: pointer;">
                            Obtained
                            @if($sortField === 'obtained_marks')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Total</th>
                        <th wire:click="sortBy('percentage')" style="cursor: pointer;">
                            Percentage
                            @if($sortField === 'percentage')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Grade</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $index => $result)
                        <tr wire:key="result-{{ $result->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $result->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($results->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $result->student->name ?? 'N/A' }}</span>
                                    @if($result->student && $result->student->admission_number)
                                        <br><small class="text-muted">{{ $result->student->admission_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $result->exam->name ?? 'N/A' }}</td>
                            <td>{{ $result->subject->name ?? 'N/A' }}</td>
                            <td>{{ $result->academicClass->name ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $result->obtained_marks }}</td>
                            <td>{{ $result->total_marks }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ number_format($result->percentage, 2) }}%</span>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ $result->grade ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($result->status === 'pass')
                                    <span class="badge bg-success-subtle text-success">Pass</span>
                                @elseif($result->status === 'fail')
                                    <span class="badge bg-danger-subtle text-danger">Fail</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Absent</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.result.show', $result->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.result.edit', $result->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $result->id }}, '{{ $result->student->name ?? 'Result' }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No results found</p>
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
        @if($results->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $results->firstItem() ?? 0 }} to {{ $results->lastItem() ?? 0 }} of {{ $results->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $results->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
