@extends('layouts.master')
@section('title', 'Edit Academic Session')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Academic Session</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.academic-session.index') }}">Academic Sessions</a></li>
                                <li class="breadcrumb-item active">Edit Session</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Academic Session</h5>
                            <a href="{{ route('school-admin.academic-session.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.academic-session.update', $academicSession->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $academicSession->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Session Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name', $academicSession->name)" required autofocus placeholder="e.g., 2024-2025, 2025-2026" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="start_date" id="start_date" :value="old('start_date', $academicSession->start_date->format('Y-m-d'))" required />
                                        @error('start_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="end_date" id="end_date" :value="old('end_date', $academicSession->end_date->format('Y-m-d'))" required />
                                        @error('end_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter session description">{{ old('description', $academicSession->description) }}</x-textarea>
                                        @error('description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch form-switch-md">
                                            <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1" {{ old('is_current', $academicSession->is_current) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="is_current">Set as Current Session</label>
                                        </div>
                                        <small class="text-muted">Only one session can be current at a time</small>
                                        @error('is_current')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch form-switch-md">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $academicSession->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                        </div>
                                        @error('is_active')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Session</button>
                                    <a href="{{ route('school-admin.academic-session.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

