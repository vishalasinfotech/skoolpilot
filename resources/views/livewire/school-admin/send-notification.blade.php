<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-notification-line me-2"></i>Send Notification
            </h5>
        </div>
        <div class="card-body">
            @include('layouts.badge')

            <form wire:submit="sendNotification">
                <!-- Notification Details -->
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" wire:model="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter notification title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea wire:model="message" id="message" rows="6" class="form-control @error('message') is-invalid @enderror" placeholder="Enter notification message" required></textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maximum 5000 characters</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="url" class="form-label">URL (Optional)</label>
                        <input type="text" wire:model="url" id="url" class="form-control @error('url') is-invalid @enderror" placeholder="e.g., /dashboard, /reports">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Optional link to include in the notification</small>
                    </div>
                </div>

                <!-- Send Type Selection -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label">Send To <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="sendType" value="role" id="sendTypeRole">
                                <label class="form-check-label" for="sendTypeRole">
                                    By Role
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="sendType" value="user" id="sendTypeUser">
                                <label class="form-check-label" for="sendTypeUser">
                                    Specific Users
                                </label>
                            </div>
                        </div>
                        @error('sendType')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection (when sendType is 'role') -->
                @if($sendType === 'role')
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label">Select Roles <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($availableRoles as $roleKey => $roleLabel)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="selectedRoles" value="{{ $roleKey }}" id="role_{{ $roleKey }}">
                                            <label class="form-check-label" for="role_{{ $roleKey }}">
                                                {{ $roleLabel }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedRoles')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            @if(empty($selectedRoles))
                                <small class="text-danger d-block">Please select at least one role.</small>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- User Selection (when sendType is 'user') -->
                @if($sendType === 'user')
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="userSearch" class="form-label">Search Users <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" wire:model.live.debounce.300ms="userSearch" id="userSearch" class="form-control" placeholder="Search by name, email, admission number, or employee ID">
                                @if(!empty($userSearch) && $users->count() > 0)
                                    <div class="list-group position-absolute w-100 mt-1" style="z-index: 1000; max-height: 300px; overflow-y: auto;">
                                        @foreach($users as $user)
                                            <button type="button" class="list-group-item list-group-item-action" wire:click="addUser({{ $user->id }})">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                        @if($user->admission_number)
                                                            <small class="text-muted"> | Admission: {{ $user->admission_number }}</small>
                                                        @endif
                                                        @if($user->employee_id)
                                                            <small class="text-muted"> | Employee ID: {{ $user->employee_id }}</small>
                                                        @endif
                                                    </div>
                                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Selected Users -->
                    @if(count($selectedUserIds) > 0)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Selected Users ({{ count($selectedUserIds) }})</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($selectedUsers as $user)
                                        <span class="badge bg-primary-subtle text-primary p-2 d-flex align-items-center gap-2">
                                            {{ $user->name }}
                                            <button type="button" class="btn-close btn-close-sm" wire:click="removeUser({{ $user->id }})" aria-label="Remove"></button>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @error('selectedUserIds')
                        <small class="text-danger d-block mb-3">{{ $message }}</small>
                    @enderror
                    @if(empty($selectedUserIds))
                        <small class="text-danger d-block mb-3">Please select at least one user.</small>
                    @endif
                @endif

                <!-- Submit Button -->
                <div class="d-flex justify-content-start gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="sendNotification">
                            <i class="ri-send-plane-line me-1"></i> Send Notification
                        </span>
                        <span wire:loading wire:target="sendNotification">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Sending...
                        </span>
                    </button>
                    <button type="button" class="btn btn-secondary" wire:click="$set('title', ''); $set('message', ''); $set('url', null); $set('selectedRoles', []); $set('selectedUserIds', []);">
                        <i class="ri-refresh-line me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
