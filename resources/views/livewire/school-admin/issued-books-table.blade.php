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
                        <th>Book Title</th>
                        <th>User</th>
                        <th wire:click="sortBy('issue_date')" style="cursor: pointer;">
                            Issue Date
                            @if($sortField === 'issue_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('due_date')" style="cursor: pointer;">
                            Due Date
                            @if($sortField === 'due_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th>Return Date</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                            Status
                            @if($sortField === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                            @endif
                        </th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookIssues as $index => $bookIssue)
                        <tr wire:key="book-issue-{{ $bookIssue->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $bookIssue->id }}" class="form-check-input">
                            </td>
                            <td>{{ str_pad($bookIssues->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($bookIssue->library->book_image)
                                        @php
                                            $imagePath = public_path($bookIssue->library->book_image);
                                        @endphp
                                        @if(file_exists($imagePath))
                                            <img src="{{ asset($bookIssue->library->book_image) }}" alt="{{ $bookIssue->library->book_title }}"
                                                class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                                        @endif
                                    @endif
                                    <div class="ms-2">
                                        <span class="fw-medium">{{ $bookIssue->library->book_title }}</span>
                                        <br><small class="text-muted">by {{ $bookIssue->library->author }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $bookIssue->user->full_name }}</span>
                                    <br><small class="text-muted">{{ ucfirst($bookIssue->user->role) }}</small>
                                </div>
                            </td>
                            <td>{{ $bookIssue->issue_date->format('d M Y') }}</td>
                            <td>
                                <span class="{{ strtotime($bookIssue->due_date) < strtotime('today') && $bookIssue->status !== 'returned' ? 'text-danger fw-bold' : '' }}">
                                    {{ $bookIssue->due_date->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if($bookIssue->return_date)
                                    <span class="text-success">{{ $bookIssue->return_date->format('d M Y') }}</span>
                                @else
                                    <span class="text-muted">Not returned</span>
                                @endif
                            </td>
                            <td>
                                @if($bookIssue->status === 'returned')
                                    <span class="badge bg-success-subtle text-success">Returned</span>
                                @elseif($bookIssue->status === 'overdue' || (strtotime($bookIssue->due_date) < strtotime('today') && $bookIssue->status !== 'returned'))
                                    <span class="badge bg-danger-subtle text-danger">Overdue</span>
                                @else
                                    <span class="badge bg-info-subtle text-info">Issued</span>
                                @endif
                            </td>
                            <td>
                                @if($bookIssue->status !== 'returned')
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#returnBookModal{{ $bookIssue->id }}">
                                        <i class="ri-check-line"></i> Return
                                    </button>
                                @else
                                    <span class="text-muted">Returned</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Return Book Modal -->
                        @if($bookIssue->status !== 'returned')
                            <div class="modal fade" id="returnBookModal{{ $bookIssue->id }}" tabindex="-1" aria-labelledby="returnBookModalLabel{{ $bookIssue->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('school-admin.library.return-book', $bookIssue->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="returnBookModalLabel{{ $bookIssue->id }}">Return Book</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Book:</strong> {{ $bookIssue->library->book_title }}</p>
                                                <p><strong>Issued to:</strong> {{ $bookIssue->user->full_name }} ({{ ucfirst($bookIssue->user->role) }})</p>
                                                <p><strong>Issue Date:</strong> {{ $bookIssue->issue_date->format('d M Y') }}</p>
                                                <p><strong>Due Date:</strong> {{ $bookIssue->due_date->format('d M Y') }}</p>

                                                <div class="mb-3">
                                                    <label for="return_date{{ $bookIssue->id }}" class="form-label">Return Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="return_date" id="return_date{{ $bookIssue->id }}" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                    @error('return_date')
                                                        <small class="text-danger d-block">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="notes{{ $bookIssue->id }}" class="form-label">Notes</label>
                                                    <textarea name="notes" id="notes{{ $bookIssue->id }}" class="form-control" rows="3" placeholder="Enter any notes (optional)">{{ old('notes') }}</textarea>
                                                    @error('notes')
                                                        <small class="text-danger d-block">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ri-check-line align-middle me-1"></i> Return Book
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-search-line fs-2"></i>
                                    <p class="mt-2 mb-0">No issued books found</p>
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
        @if($bookIssues->hasPages())
            <div class="row mt-3 align-items-center">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $bookIssues->firstItem() ?? 0 }} to {{ $bookIssues->lastItem() ?? 0 }} of {{ $bookIssues->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-end">
                        {{ $bookIssues->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
