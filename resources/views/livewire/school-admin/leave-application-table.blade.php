<div>
    <div class="card-body">
        <!-- Search and Filters -->
        <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
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
            <div class="col-sm-12 col-md-4">
                <div class="mb-2">
                    <label class="form-label">Filter by Status:</label>
                    <select wire:model.live="statusFilter" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
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
                        <th wire:click="sortBy('teacher_id')" style="cursor: pointer;">
                            Teacher
                            @if($sortField === 'teacher_id')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('leave_type')" style="cursor: pointer;">
                            Leave Type
                            @if($sortField === 'leave_type')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('start_date')" style="cursor: pointer;">
                            Start Date
                            @if($sortField === 'start_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('end_date')" style="cursor: pointer;">
                            End Date
                            @if($sortField === 'end_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Total Days</th>
                        <th>Reason</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveApplications as $index => $leaveApplication)
                        <tr wire:key="leave-{{ $leaveApplication->id }}">
                            <td>{{ str_pad($leaveApplications->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $defaultImage = asset('admin_theme/assets/images/default/default.png');
                                        $imagePath = $leaveApplication->teacher->profile_image ? public_path($leaveApplication->teacher->profile_image) : null;
                                    @endphp
                                    @if($leaveApplication->teacher->profile_image && $imagePath && file_exists($imagePath))
                                        <img src="{{ asset($leaveApplication->teacher->profile_image) }}" alt="{{ $leaveApplication->teacher->full_name }}"
                                            class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <img src="{{ $defaultImage }}" alt="{{ $leaveApplication->teacher->full_name }}"
                                            class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <div class="ms-2">
                                        <span class="fw-medium">{{ $leaveApplication->teacher->full_name }}</span>
                                        <br><small class="text-muted">{{ $leaveApplication->teacher->employee_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ ucfirst($leaveApplication->leave_type) }}</span>
                            </td>
                            <td>{{ $leaveApplication->start_date->format('M d, Y') }}</td>
                            <td>{{ $leaveApplication->end_date->format('M d, Y') }}</td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ $leaveApplication->total_days }} {{ $leaveApplication->total_days == 1 ? 'day' : 'days' }}</span></td>
                            <td>
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $leaveApplication->reason }}">
                                    {{ $leaveApplication->reason }}
                                </div>
                            </td>
                            <td>
                                @if($leaveApplication->status === 'approved')
                                    <span class="badge bg-success-subtle text-success">Approved</span>
                                @elseif($leaveApplication->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($leaveApplication->status === 'pending')
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-success btn-sm" wire:click="approve({{ $leaveApplication->id }})" wire:loading.attr="disabled" title="Approve Leave Application">
                                            <i class="ri-check-line"></i> Approve
                                        </button>
                                        <button class="btn btn-danger btn-sm" wire:click="reject({{ $leaveApplication->id }})" wire:loading.attr="disabled" title="Reject Leave Application">
                                            <i class="ri-close-line"></i> Reject
                                        </button>
                                    </div>
                                @else
                                    <div class="text-muted">
                                        <small>
                                            @if($leaveApplication->approver)
                                                <strong>By:</strong> {{ $leaveApplication->approver->full_name }}
                                                <br>
                                            @endif
                                            @if($leaveApplication->approved_at)
                                                <strong>Date:</strong> {{ $leaveApplication->approved_at->format('M d, Y h:i A') }}
                                            @endif
                                        </small>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No leave applications found</p>
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
        @if($leaveApplications->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $leaveApplications->firstItem() ?? 0 }} to {{ $leaveApplications->lastItem() ?? 0 }} of {{ $leaveApplications->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $leaveApplications->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div class="modal fade @if($rejectLeaveId) show d-block @endif" id="rejectLeaveModal" tabindex="-1" role="dialog" aria-labelledby="rejectLeaveModalLabel" aria-hidden="true" style="@if($rejectLeaveId) display: block; background-color: rgba(0,0,0,0.5); @endif">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectLeaveModalLabel">Reject Leave Application</h5>
                    <button type="button" class="btn-close" wire:click="closeRejectModal" aria-label="Close"></button>
                </div>
                <form wire:submit="confirmReject">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="adminRemarks" class="form-label">Admin Remarks (Optional)</label>
                            <textarea class="form-control @error('adminRemarks') is-invalid @enderror" id="adminRemarks" rows="3" wire:model="adminRemarks" placeholder="Please provide a reason for rejection..."></textarea>
                            @error('adminRemarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeRejectModal">Cancel</button>
                        <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="confirmReject">Confirm Rejection</span>
                            <span wire:loading wire:target="confirmReject">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Rejecting...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($rejectLeaveId)
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
