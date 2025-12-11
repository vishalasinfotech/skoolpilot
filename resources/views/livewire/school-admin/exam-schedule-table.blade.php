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
                        <th wire:click="sortBy('exam_date')" style="cursor: pointer;">
                            Exam
                            @if($sortField === 'exam_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th wire:click="sortBy('exam_date')" style="cursor: pointer;">
                            Date
                            @if($sortField === 'exam_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Marks</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examSchedules as $index => $schedule)
                        <tr wire:key="exam-schedule-{{ $schedule->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $schedule->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($examSchedules->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="fw-medium">{{ $schedule->exam->name ?? 'N/A' }}</span>
                            </td>
                            <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                            <td>{{ $schedule->academicClass->name ?? 'N/A' }}</td>
                            <td>{{ $schedule->section->name ?? 'All' }}</td>
                            <td>{{ $schedule->exam_date->format('d M Y') }}</td>
                            <td>
                                @if($schedule->start_time && $schedule->end_time)
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $schedule->room_number ?? 'N/A' }}</td>
                            <td>
                                <small>{{ $schedule->total_marks }} <span class="text-muted">(Pass: {{ $schedule->passing_marks }})</span></small>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.exam-schedule.show', $schedule->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('school-admin.exam-schedule.edit', $schedule->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" wire:click="openDeleteModal({{ $schedule->id }}, '{{ $schedule->exam->name ?? 'Schedule' }}')">
                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No exam schedules found</p>
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
        @if($examSchedules->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $examSchedules->firstItem() ?? 0 }} to {{ $examSchedules->lastItem() ?? 0 }} of {{ $examSchedules->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $examSchedules->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
