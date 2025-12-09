@extends('layouts.master')
@section('title', 'Add Fee Structure')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Fee Structure</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.fee-structure.index') }}">Fee Structure</a></li>
                                <li class="breadcrumb-item active">Add Fee Structure</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Fee Structure</h5>
                            <a href="{{ route('school-admin.fee-structure.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.fee-structure.store') }}" method="POST">
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
                                        <label for="class_id" class="form-label">Class</label>
                                        <x-select name="class_id" id="class_id" :options="$classes" :value="old('class_id')" placeholder="Select Class (Leave empty for all classes)" />
                                        @error('class_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></label>
                                        <x-input type="text" name="fee_type" id="fee_type" :value="old('fee_type')" required autofocus placeholder="e.g., Tuition, Library, Sports, Transport" />
                                        @error('fee_type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fee_name" class="form-label">Fee Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="fee_name" id="fee_name" :value="old('fee_name')" required placeholder="e.g., Annual Tuition Fee" />
                                        @error('fee_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                        <x-input type="number" name="amount" id="amount" step="0.01" min="0" :value="old('amount')" required placeholder="0.00" />
                                        @error('amount')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="frequency" class="form-label">Frequency <span class="text-danger">*</span></label>
                                        <select name="frequency" id="frequency" class="form-select" required>
                                            <option value="">Select Frequency</option>
                                            <option value="monthly" {{ old('frequency') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="quarterly" {{ old('frequency') === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                            <option value="yearly" {{ old('frequency') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                            <option value="per_semester" {{ old('frequency') === 'per_semester' ? 'selected' : '' }}>Per Semester</option>
                                            <option value="one_time" {{ old('frequency') === 'one_time' ? 'selected' : '' }}>One Time</option>
                                        </select>
                                        @error('frequency')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="effective_from" class="form-label">Effective From</label>
                                        <x-input type="date" name="effective_from" id="effective_from" :value="old('effective_from')" />
                                        @error('effective_from')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="effective_to" class="form-label">Effective To</label>
                                        <x-input type="date" name="effective_to" id="effective_to" :value="old('effective_to')" />
                                        @error('effective_to')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter fee description">{{ old('description') }}</x-textarea>
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
                                    <button type="submit" class="btn btn-primary">Create Fee Structure</button>
                                    <a href="{{ route('school-admin.fee-structure.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

