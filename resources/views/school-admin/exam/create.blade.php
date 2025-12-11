@extends('layouts.master')
@section('title', 'Add Exam')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Exam</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.exam.index') }}">Exams</a></li>
                                <li class="breadcrumb-item active">Add Exam</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Exam</h5>
                            <a href="{{ route('school-admin.exam.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.exam.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', auth()->user()->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_session_id" class="form-label">Academic Session <span class="text-danger">*</span></label>
                                        <x-select name="academic_session_id" id="academic_session_id" :options="$academicSessions" :value="old('academic_session_id')" required placeholder="Select Academic Session" />
                                        @error('academic_session_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Exam Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name')" required autofocus placeholder="e.g., Mid-Term Exam, Final Exam" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exam_type" class="form-label">Exam Type <span class="text-danger">*</span></label>
                                        <select name="exam_type" id="exam_type" class="form-select" required>
                                            <option value="">Select Exam Type</option>
                                            <option value="regular" {{ old('exam_type') === 'regular' ? 'selected' : '' }}>Regular</option>
                                            <option value="mid_term" {{ old('exam_type') === 'mid_term' ? 'selected' : '' }}>Mid-Term</option>
                                            <option value="final" {{ old('exam_type') === 'final' ? 'selected' : '' }}>Final</option>
                                            <option value="unit_test" {{ old('exam_type') === 'unit_test' ? 'selected' : '' }}>Unit Test</option>
                                            <option value="quiz" {{ old('exam_type') === 'quiz' ? 'selected' : '' }}>Quiz</option>
                                        </select>
                                        @error('exam_type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="start_date" id="start_date" :value="old('start_date')" required />
                                        @error('start_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="end_date" id="end_date" :value="old('end_date')" required />
                                        @error('end_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter exam description">{{ old('description') }}</x-textarea>
                                        @error('description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Create Exam</button>
                                    <a href="{{ route('school-admin.exam.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

