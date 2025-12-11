@extends('layouts.master')
@section('title', 'Add Exam Schedule')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Exam Schedule</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.exam-schedule.index') }}">Exam Schedules</a></li>
                                <li class="breadcrumb-item active">Add Schedule</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Exam Schedule</h5>
                            <a href="{{ route('school-admin.exam-schedule.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.exam-schedule.store') }}" method="POST">
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
                                        <label for="exam_id" class="form-label">Exam <span class="text-danger">*</span></label>
                                        <x-select name="exam_id" id="exam_id" :options="$exams" :value="old('exam_id')" required placeholder="Select Exam" />
                                        @error('exam_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="academic_class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                        <x-select name="academic_class_id" id="academic_class_id" :options="$classes" :value="old('academic_class_id')" required placeholder="Select Class" />
                                        @error('academic_class_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="section_id" class="form-label">Section</label>
                                        <x-select name="section_id" id="section_id" :options="$sections" :value="old('section_id')" placeholder="Select Section (Optional)" />
                                        @error('section_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <x-select name="subject_id" id="subject_id" :options="$subjects" :value="old('subject_id')" required placeholder="Select Subject" />
                                        @error('subject_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="exam_date" class="form-label">Exam Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="exam_date" id="exam_date" :value="old('exam_date')" required />
                                        @error('exam_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                        <x-input type="time" name="start_time" id="start_time" :value="old('start_time')" required />
                                        @error('start_time')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                                        <x-input type="time" name="end_time" id="end_time" :value="old('end_time')" required />
                                        @error('end_time')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="room_number" class="form-label">Room Number</label>
                                        <x-input type="text" name="room_number" id="room_number" :value="old('room_number')" placeholder="e.g., Room 101" />
                                        @error('room_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                                        <x-input type="number" name="total_marks" id="total_marks" :value="old('total_marks', 100)" min="1" required />
                                        @error('total_marks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="passing_marks" class="form-label">Passing Marks <span class="text-danger">*</span></label>
                                        <x-input type="number" name="passing_marks" id="passing_marks" :value="old('passing_marks', 33)" min="0" required />
                                        @error('passing_marks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="instructions" class="form-label">Instructions</label>
                                        <x-textarea name="instructions" id="instructions" rows="3" placeholder="Enter exam instructions">{{ old('instructions') }}</x-textarea>
                                        @error('instructions')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Create Schedule</button>
                                    <a href="{{ route('school-admin.exam-schedule.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

