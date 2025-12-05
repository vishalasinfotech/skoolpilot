@extends('layouts.master')
@section('title', 'Edit Student')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Student</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('school-admin.student.index') }}">Students</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Student</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Student</h5>
                            <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('school-admin.student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $student->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="first_name" id="first_name" :value="old('first_name', $student->first_name)" required placeholder="Enter first name" />
                                        @error('first_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="last_name" id="last_name" :value="old('last_name', $student->last_name)" required placeholder="Enter last name" />
                                        @error('last_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="admission_number" class="form-label">Admission Number <span class="text-danger">*</span></label>
                                        <x-input type="text" name="admission_number" id="admission_number" :value="old('admission_number', $student->admission_number)" required placeholder="Enter admission number" />
                                        @error('admission_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <x-input type="email" name="email" id="email" :value="old('email', $student->email)" required placeholder="Enter email address" />
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <x-input type="text" name="phone" id="phone" :value="old('phone', $student->phone)" placeholder="Enter phone number" />
                                        @error('phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="parent_phone" class="form-label">Parent Phone</label>
                                        <x-input type="text" name="parent_phone" id="parent_phone" :value="old('parent_phone', $student->parent_phone)" placeholder="Enter parent phone number" />
                                        @error('parent_phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <x-input type="date" name="date_of_birth" id="date_of_birth" :value="old('date_of_birth', $student->date_of_birth?->format('Y-m-d'))" />
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
                                        ]" :value="old('gender', $student->gender)" placeholder="Select Gender" />
                                        @error('gender')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <x-input type="text" name="blood_group" id="blood_group" :value="old('blood_group', $student->blood_group)" placeholder="Enter blood group" />
                                        @error('blood_group')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="class" class="form-label">Class</label>
                                        <x-input type="text" name="class" id="class" :value="old('class', $student->class)" placeholder="Enter class" />
                                        @error('class')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="section" class="form-label">Section</label>
                                        <x-input type="text" name="section" id="section" :value="old('section', $student->section)" placeholder="Enter section" />
                                        @error('section')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="roll_number" class="form-label">Roll Number</label>
                                        <x-input type="text" name="roll_number" id="roll_number" :value="old('roll_number', $student->roll_number)" placeholder="Enter roll number" />
                                        @error('roll_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="admission_date" class="form-label">Admission Date</label>
                                        <x-input type="date" name="admission_date" id="admission_date" :value="old('admission_date', $student->admission_date?->format('Y-m-d'))" />
                                        @error('admission_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="parent_name" class="form-label">Parent Name</label>
                                        <x-input type="text" name="parent_name" id="parent_name" :value="old('parent_name', $student->parent_name)" placeholder="Enter parent name" />
                                        @error('parent_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="parent_email" class="form-label">Parent Email</label>
                                        <x-input type="email" name="parent_email" id="parent_email" :value="old('parent_email', $student->parent_email)" placeholder="Enter parent email" />
                                        @error('parent_email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <x-input type="file" name="profile_image" id="profile_image" accept="image/*" />
                                        @if($student->profile_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($student->profile_image) }}" alt="{{ $student->first_name . ' ' . $student->last_name }}" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
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
                                        <x-textarea name="address" id="address" rows="3" placeholder="Enter full address">{{ old('address', $student->address) }}</x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Student</button>
                                    <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
