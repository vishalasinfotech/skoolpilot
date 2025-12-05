@extends('layouts.master')
@section('title', 'Edit Staff')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Staff</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('school-admin.staff.index') }}">Staff</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Staff</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Staff</h5>
                            <a href="{{ route('school-admin.staff.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('school-admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $staff->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="first_name" id="first_name" :value="old('first_name', $staff->first_name)" required placeholder="Enter first name" />
                                        @error('first_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="last_name" id="last_name" :value="old('last_name', $staff->last_name)" required placeholder="Enter last name" />
                                        @error('last_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="employee_id" class="form-label">Staff ID <span class="text-danger">*</span></label>
                                        <x-input type="text" name="employee_id" id="employee_id" :value="old('employee_id', $staff->employee_id)" required placeholder="Enter staff ID" />
                                        @error('employee_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <x-input type="email" name="email" id="email" :value="old('email', $staff->email)" required placeholder="Enter email address" />
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <x-input type="text" name="phone" id="phone" :value="old('phone', $staff->phone)" placeholder="Enter phone number" />
                                        @error('phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="alternate_phone" class="form-label">Alternate Phone</label>
                                        <x-input type="text" name="alternate_phone" id="alternate_phone" :value="old('alternate_phone', $staff->alternate_phone)" placeholder="Enter alternate phone number" />
                                        @error('alternate_phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <x-input type="date" name="date_of_birth" id="date_of_birth" :value="old('date_of_birth', $staff->date_of_birth?->format('Y-m-d'))" />
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
                                        ]" :value="old('gender', $staff->gender)" placeholder="Select Gender" />
                                        @error('gender')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <x-input type="text" name="blood_group" id="blood_group" :value="old('blood_group', $staff->blood_group)" placeholder="Enter blood group" />
                                        @error('blood_group')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <x-input type="text" name="department" id="department" :value="old('department', $staff->department)" placeholder="Enter department" />
                                        @error('department')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="designation" class="form-label">Designation</label>
                                        <x-input type="text" name="designation" id="designation" :value="old('designation', $staff->designation)" placeholder="Enter designation" />
                                        @error('designation')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="joining_date" class="form-label">Joining Date</label>
                                        <x-input type="date" name="joining_date" id="joining_date" :value="old('joining_date', $staff->joining_date?->format('Y-m-d'))" />
                                        @error('joining_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <x-input type="file" name="profile_image" id="profile_image" accept="image/*" />
                                        @if($staff->profile_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($staff->profile_image) }}" alt="{{ $staff->first_name . ' ' . $staff->last_name }}" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
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
                                        <x-textarea name="address" id="address" rows="3" placeholder="Enter full address">{{ old('address', $staff->address) }}</x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Staff</button>
                                    <a href="{{ route('school-admin.staff.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
