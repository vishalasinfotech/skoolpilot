@extends('layouts.master')
@section('title', 'Apply for Leave')
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Apply for Leave</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.leave-application.index') }}">Leave Applications</a></li>
                                <li class="breadcrumb-item active">Apply for Leave</li>
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
                            <h5 class="card-title mb-0">Apply for Leave</h5>
                            <a href="{{ route('teacher.leave-application.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('teacher.leave-application.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="leave_type" class="form-label">Leave Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('leave_type') is-invalid @enderror" id="leave_type" name="leave_type" required>
                                            <option value="">Select leave type</option>
                                            <option value="casual" {{ old('leave_type') === 'casual' ? 'selected' : '' }}>Casual</option>
                                            <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>Sick</option>
                                            <option value="emergency" {{ old('leave_type') === 'emergency' ? 'selected' : '' }}>Emergency</option>
                                            <option value="vacation" {{ old('leave_type') === 'vacation' ? 'selected' : '' }}>Vacation</option>
                                            <option value="other" {{ old('leave_type') === 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('leave_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">Leave Duration <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="">Select duration</option>
                                            <option value="full_day" {{ old('type') === 'full_day' ? 'selected' : '' }}>Full Day</option>
                                            <option value="half_day" {{ old('type') === 'half_day' ? 'selected' : '' }}>Half Day</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" placeholder="Please provide a reason for your leave application..." required>{{ old('reason') }}</textarea>
                                        @error('reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line align-middle me-1"></i> Submit Application
                                        </button>
                                        <a href="{{ route('teacher.leave-application.index') }}" class="btn btn-light">
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    endDateInput.min = this.value;
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = this.value;
                    }
                }
            });
        });
    </script>
    @endpush

@endsection

