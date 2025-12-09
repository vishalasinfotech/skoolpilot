@extends('layouts.master')
@section('title', 'Edit Teacher')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Teacher</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.teacher.index') }}">Teachers</a></li>
                                <li class="breadcrumb-item active">Edit Teacher</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Teacher</h5>
                            <a href="{{ route('school-admin.teacher.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('school-admin.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $teacher->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="first_name" id="first_name" :value="old('first_name', $teacher->first_name)" required placeholder="Enter first name" />
                                        @error('first_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="last_name" id="last_name" :value="old('last_name', $teacher->last_name)" required placeholder="Enter last name" />
                                        @error('last_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="employee_id" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                        <x-input type="text" name="employee_id" id="employee_id" :value="old('employee_id', $teacher->employee_id)" required placeholder="Enter employee ID" />
                                        @error('employee_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <x-input type="email" name="email" id="email" :value="old('email', $teacher->email)" required placeholder="Enter email address" />
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <x-input type="text" name="phone" id="phone" :value="old('phone', $teacher->phone)" placeholder="Enter phone number" />
                                        @error('phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <x-input type="date" name="date_of_birth" id="date_of_birth" :value="old('date_of_birth', $teacher->date_of_birth?->format('Y-m-d'))" />
                                        @error('date_of_birth')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <x-select name="gender" id="gender" :options="[
                                            'male' => 'Male',
                                            'female' => 'Female',
                                            'other' => 'Other',
                                        ]" :value="old('gender', $teacher->gender)" placeholder="Select Gender" />
                                        @error('gender')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="joining_date" class="form-label">Joining Date</label>
                                        <x-input type="date" name="joining_date" id="joining_date" :value="old('joining_date', $teacher->joining_date?->format('Y-m-d'))" />
                                        @error('joining_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="qualification" class="form-label">Qualification</label>
                                        <x-input type="text" name="qualification" id="qualification" :value="old('qualification', $teacher->qualification)" placeholder="e.g., B.Ed, M.Ed" />
                                        @error('qualification')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="specialization" class="form-label">Specialization</label>
                                        <x-input type="text" name="specialization" id="specialization" :value="old('specialization', $teacher->specialization)" placeholder="e.g., Mathematics, Science" />
                                        @error('specialization')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="salary" class="form-label">Salary</label>
                                        <x-input type="number" name="salary" id="salary" :value="old('salary', $teacher->salary)" placeholder="0.00" step="0.01" min="0" />
                                        @error('salary')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <x-input type="file" name="profile_image" id="profile_image" accept="image/*" />
                                        @if($teacher->profile_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($teacher->profile_image) }}" alt="{{ $teacher->full_name }}"
                                                    class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                            </div>
                                        @endif
                                        @error('profile_image')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <x-textarea name="address" id="address" rows="3" placeholder="Enter full address">{{ old('address', $teacher->address) }}</x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="doc_type" class="form-label">Document Type</label>
                                        <x-select name="doc_type" id="doc_type" :options="[
                                            'aadhar' => 'Aadhar',
                                            'pancard' => 'PAN Card',
                                            'other' => 'Other',
                                        ]" :value="old('doc_type', $teacher->doc_type)" placeholder="Select document type" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="doc_image" class="form-label">Document Image</label>
                                        <x-input type="file" name="doc_image" id="doc_image" accept="image/*" />
                                        @if($teacher->doc_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($teacher->doc_image) }}" alt="{{ $teacher->full_name }}"
                                                    class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                            </div>
                                        @endif
                                        @error('doc_image')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" value="{{ old('password') }}" placeholder="Enter password (leave blank to keep current)" class="form-control @error('password') is-invalid @enderror" />
                                            <button class="btn btn-outline-secondary toggle-password" type="button" id="togglePassword">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Enter confirm password" class="form-control @error('password_confirmation') is-invalid @enderror" />
                                            <button class="btn btn-outline-secondary toggle-password" type="button" id="toggleConfirmPassword">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                                    <a href="{{ route('school-admin.teacher.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

