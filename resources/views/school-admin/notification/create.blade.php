@extends('layouts.master')
@section('title', 'Send Notification')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Send Notification</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.notification.index') }}">Notifications</a></li>
                                <li class="breadcrumb-item active">Send</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Send Notification</h5>
                            <a href="{{ route('school-admin.notification.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.notification.store') }}" method="POST" id="notificationForm">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="notification_template_id" class="form-label">Notification Template (Optional)</label>
                                        <select name="notification_template_id" id="notification_template_id" class="form-select">
                                            <option value="">Select a template (optional)</option>
                                            @foreach($templates as $template)
                                                <option value="{{ $template->id }}" {{ old('notification_template_id') == $template->id ? 'selected' : '' }}>
                                                    {{ $template->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('notification_template_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <x-input type="text" name="title" id="title" :value="old('title')" required autofocus placeholder="Enter notification title" />
                                        @error('title')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                        <x-textarea name="message" id="message" rows="5" required placeholder="Enter notification message">{{ old('message') }}</x-textarea>
                                        @error('message')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="url" class="form-label">URL (Optional)</label>
                                        <x-input type="text" name="url" id="url" :value="old('url')" placeholder="Enter URL (e.g., /dashboard)" />
                                        @error('url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Send Type <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="send_type" id="send_type_role" value="role" {{ old('send_type', 'role') == 'role' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="send_type_role">By Role</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="send_type" id="send_type_user" value="user" {{ old('send_type') == 'user' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="send_type_user">Specific Users</label>
                                            </div>
                                        </div>
                                        @error('send_type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row" id="roles_section">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Select Roles <span class="text-danger">*</span></label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach($availableRoles as $roleValue => $roleLabel)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $roleValue }}" value="{{ $roleValue }}" {{ in_array($roleValue, old('roles', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="role_{{ $roleValue }}">{{ $roleLabel }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('roles')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        @error('roles.*')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row" id="users_section" style="display: none;">
                                    <div class="col-md-12 mb-3">
                                        <label for="user_search" class="form-label">Search Users <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="user_search" placeholder="Type to search users..." autocomplete="off">
                                        <div id="user_search_results" class="mt-2"></div>
                                        <div id="selected_users" class="mt-3"></div>
                                        @foreach(old('user_ids', []) as $userId)
                                            <input type="hidden" name="user_ids[]" value="{{ $userId }}">
                                        @endforeach
                                        @error('user_ids')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        @error('user_ids.*')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-md">
                                            <input class="form-check-input" type="checkbox" id="send_email" name="send_email" value="1" {{ old('send_email', true) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="send_email">Send Email Notification</label>
                                        </div>
                                        @error('send_email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Send Notification</button>
                                    <a href="{{ route('school-admin.notification.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendTypeRole = document.getElementById('send_type_role');
            const sendTypeUser = document.getElementById('send_type_user');
            const rolesSection = document.getElementById('roles_section');
            const usersSection = document.getElementById('users_section');
            const userSearch = document.getElementById('user_search');
            const userSearchResults = document.getElementById('user_search_results');
            const selectedUsers = document.getElementById('selected_users');
            const userIdsInput = document.getElementById('user_ids');
            let selectedUserIds = [];

            function toggleSections() {
                if (sendTypeRole.checked) {
                    rolesSection.style.display = 'block';
                    usersSection.style.display = 'none';
                } else {
                    rolesSection.style.display = 'none';
                    usersSection.style.display = 'block';
                }
            }

            sendTypeRole.addEventListener('change', toggleSections);
            sendTypeUser.addEventListener('change', toggleSections);
            toggleSections();

            // User search
            let searchTimeout;
            userSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    userSearchResults.innerHTML = '';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('school-admin.notification.get-users') }}?search=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            userSearchResults.innerHTML = '';
                            if (data.length === 0) {
                                userSearchResults.innerHTML = '<p class="text-muted">No users found</p>';
                                return;
                            }
                            data.forEach(user => {
                                if (!selectedUserIds.includes(user.id)) {
                                    const div = document.createElement('div');
                                    div.className = 'border rounded p-2 mb-2 cursor-pointer';
                                    div.style.cursor = 'pointer';
                                    div.innerHTML = `<strong>${user.name || user.first_name + ' ' + user.last_name}</strong> (${user.email}) - ${user.role}`;
                                    div.addEventListener('click', () => addUser(user));
                                    userSearchResults.appendChild(div);
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }, 300);
            });

            function addUser(user) {
                if (!selectedUserIds.includes(user.id)) {
                    selectedUserIds.push(user.id);
                    updateSelectedUsers();
                    userSearch.value = '';
                    userSearchResults.innerHTML = '';
                }
            }

            function removeUser(userId) {
                selectedUserIds = selectedUserIds.filter(id => id !== userId);
                updateSelectedUsers();
            }

            function updateSelectedUsers() {
                // Remove existing hidden inputs
                document.querySelectorAll('input[name="user_ids[]"]').forEach(input => {
                    if (input.id !== 'user_ids') {
                        input.remove();
                    }
                });

                // Add hidden inputs for selected user IDs
                selectedUserIds.forEach(userId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_ids[]';
                    input.value = userId;
                    document.getElementById('notificationForm').appendChild(input);
                });

                selectedUsers.innerHTML = '';
                if (selectedUserIds.length === 0) {
                    return;
                }
                selectedUserIds.forEach(userId => {
                    fetch(`{{ route('school-admin.notification.get-users') }}?search=&id=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const user = data[0];
                                const div = document.createElement('div');
                                div.className = 'badge bg-primary me-2 mb-2 p-2';
                                div.innerHTML = `${user.name || user.first_name + ' ' + user.last_name} <button type="button" class="btn-close btn-close-white ms-2" onclick="removeUser(${user.id})"></button>`;
                                selectedUsers.appendChild(div);
                            }
                        });
                });
            }

            window.removeUser = removeUser;
        });
    </script>
    @endpush
@endsection

