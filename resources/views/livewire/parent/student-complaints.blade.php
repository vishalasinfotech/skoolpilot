<div>
    <div class="card-body">
        <!-- Filter and Search Controls -->
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
                        <th style="width: 80px;">#</th>
                        <th wire:click="sortBy('subject')" style="cursor: pointer;">
                            Subject
                            @if($sortField === 'subject')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Student</th>
                        <th>Complaint Details</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            Date
                            @if($sortField === 'created_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Admin Response</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $index => $complaint)
                        <tr wire:key="complaint-{{ $complaint->id }}">
                            <td>{{ str_pad($complaints->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="fw-medium">{{ Str::limit($complaint->subject, 50) }}</div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $complaint->student->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $complaint->student->admission_number ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="text-muted">{{ Str::limit($complaint->message, 80) }}</div>
                                <small class="text-muted">By: {{ $complaint->createdBy->name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                @if($complaint->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                @elseif($complaint->status === 'in_progress')
                                    <span class="badge bg-primary-subtle text-primary">In Progress</span>
                                @elseif($complaint->status === 'resolved')
                                    <span class="badge bg-success-subtle text-success">Resolved</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Closed</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($complaint->admin_response)
                                    <div class="text-success">
                                        <i class="ri-check-line"></i> Responded
                                    </div>
                                    <small class="text-muted">{{ Str::limit($complaint->admin_response, 50) }}</small>
                                    @if($complaint->responded_at)
                                        <br><small class="text-muted">{{ $complaint->responded_at->format('M d, Y') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">No Response</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-inbox-line fs-2"></i>
                                    <p class="mt-2 mb-0">No complaints found</p>
                                    @if($search || $selectedStudentId)
                                        <small>Try adjusting your filters</small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($complaints->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $complaints->firstItem() ?? 0 }} to {{ $complaints->lastItem() ?? 0 }} of {{ $complaints->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
