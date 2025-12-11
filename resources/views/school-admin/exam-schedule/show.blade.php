@extends('layouts.master')
@section('title', 'Exam Schedule Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Exam Schedule Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.exam-schedule.index') }}">Exam Schedules</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Schedule Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.exam-schedule.edit', $examSchedule->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.exam-schedule.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Exam</label>
                                    <p class="mb-0">{{ $examSchedule->exam->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Subject</label>
                                    <p class="mb-0">{{ $examSchedule->subject->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <p class="mb-0">{{ $examSchedule->academicClass->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Section</label>
                                    <p class="mb-0">{{ $examSchedule->section->name ?? 'All Sections' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Room Number</label>
                                    <p class="mb-0">{{ $examSchedule->room_number ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Exam Date</label>
                                    <p class="mb-0">{{ $examSchedule->exam_date->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Start Time</label>
                                    <p class="mb-0">{{ $examSchedule->start_time ? \Carbon\Carbon::createFromFormat('H:i:s', $examSchedule->start_time)->format('h:i A') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">End Time</label>
                                    <p class="mb-0">{{ $examSchedule->end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $examSchedule->end_time)->format('h:i A') : 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Total Marks</label>
                                    <p class="mb-0 fs-5 fw-bold">{{ $examSchedule->total_marks }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Passing Marks</label>
                                    <p class="mb-0 fs-5 fw-bold text-primary">{{ $examSchedule->passing_marks }}</p>
                                </div>
                            </div>

                            @if($examSchedule->instructions)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Instructions</label>
                                    <p class="mb-0">{{ $examSchedule->instructions }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

