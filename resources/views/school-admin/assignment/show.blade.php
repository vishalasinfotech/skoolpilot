@extends('layouts.master')
@section('title', 'Assignment Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Assignment Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.assignment.index') }}">Assignments</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Assignment Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('teacher.assignment.edit', $assignment->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('teacher.assignment.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Title</label>
                                    <p class="mb-0">{{ $assignment->title }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($assignment->status === 'published')
                                            <span class="badge bg-success-subtle text-success">Published</span>
                                        @elseif($assignment->status === 'closed')
                                            <span class="badge bg-secondary-subtle text-secondary">Closed</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Draft</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <p class="mb-0">{{ $assignment->academicClass->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Subject</label>
                                    <p class="mb-0">{{ $assignment->subject->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Section</label>
                                    <p class="mb-0">{{ $assignment->section->name ?? 'All Sections' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Due Date</label>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $assignment->due_date->isPast() ? 'danger' : 'primary' }}-subtle text-{{ $assignment->due_date->isPast() ? 'danger' : 'primary' }}">
                                            {{ $assignment->due_date->format('M d, Y') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Maximum Marks</label>
                                    <p class="mb-0">{{ $assignment->max_marks ?? 'Not specified' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Description</label>
                                    <p class="mb-0">{!! nl2br(e($assignment->description)) !!}</p>
                                </div>
                            </div>

                            @if($assignment->instructions)
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Instructions</label>
                                        <p class="mb-0">{!! nl2br(e($assignment->instructions)) !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($assignment->attachment)
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Attachment</label>
                                        <p class="mb-0">
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($assignment->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="ri-download-line me-1"></i> Download Attachment
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created By</label>
                                    <p class="mb-0">{{ $assignment->teacher->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $assignment->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

