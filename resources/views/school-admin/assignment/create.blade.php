@extends('layouts.master')
@section('title', 'Create Assignment')
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Assignment</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.assignment.index') }}">Assignments</a></li>
                                <li class="breadcrumb-item active">Create Assignment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @include('layouts.badge')

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Assignment</h5>
                            <a href="{{ route('teacher.assignment.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('teacher.assignment.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                        <select class="form-select @error('academic_class_id') is-invalid @enderror" id="academic_class_id" name="academic_class_id" required>
                                            <option value="">Select class</option>
                                            @foreach($classes as $id => $name)
                                                <option value="{{ $id }}" {{ old('academic_class_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('academic_class_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                            <option value="">Select subject</option>
                                            @foreach($subjects as $id => $name)
                                                <option value="{{ $id }}" {{ old('subject_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select class="form-select @error('section_id') is-invalid @enderror" id="section_id" name="section_id">
                                            <option value="">All Sections</option>
                                            @foreach($sections as $id => $name)
                                                <option value="{{ $id }}" {{ old('section_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}" required>
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter assignment title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter assignment description" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="instructions" class="form-label">Instructions</label>
                                        <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="3" placeholder="Enter assignment instructions (optional)">{{ old('instructions') }}</textarea>
                                        @error('instructions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="max_marks" class="form-label">Maximum Marks</label>
                                        <input type="number" class="form-control @error('max_marks') is-invalid @enderror" id="max_marks" name="max_marks" value="{{ old('max_marks') }}" placeholder="Enter maximum marks" min="0" max="1000">
                                        @error('max_marks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="attachment" class="form-label">Attachment</label>
                                        <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)</small>
                                        @error('attachment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line align-middle me-1"></i> Create Assignment
                                        </button>
                                        <a href="{{ route('teacher.assignment.index') }}" class="btn btn-light">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

