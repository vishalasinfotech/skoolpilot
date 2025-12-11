@extends('layouts.master')
@section('title', 'Add Vehicle')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Vehicle</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.transportation.index') }}">Transportation</a></li>
                                <li class="breadcrumb-item active">Add Vehicle</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Vehicle</h5>
                            <a href="{{ route('school-admin.transportation.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.transportation.store') }}" method="POST">
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
                                        <label for="vehicle_number" class="form-label">Vehicle Number <span class="text-danger">*</span></label>
                                        <x-input type="text" name="vehicle_number" id="vehicle_number" :value="old('vehicle_number')" required autofocus placeholder="e.g., MH-01-AB-1234" />
                                        @error('vehicle_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="vehicle_type" class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                        <select name="vehicle_type" id="vehicle_type" class="form-select" required>
                                            <option value="">Select Vehicle Type</option>
                                            <option value="bus" {{ old('vehicle_type') === 'bus' ? 'selected' : '' }}>Bus</option>
                                            <option value="van" {{ old('vehicle_type') === 'van' ? 'selected' : '' }}>Van</option>
                                            <option value="car" {{ old('vehicle_type') === 'car' ? 'selected' : '' }}>Car</option>
                                            <option value="auto" {{ old('vehicle_type') === 'auto' ? 'selected' : '' }}>Auto</option>
                                            <option value="other" {{ old('vehicle_type') === 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('vehicle_type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                        <x-input type="number" name="capacity" id="capacity" :value="old('capacity')" required min="1" placeholder="Number of seats" />
                                        @error('capacity')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="driver_name" class="form-label">Driver Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="driver_name" id="driver_name" :value="old('driver_name')" required placeholder="Enter driver name" />
                                        @error('driver_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="driver_phone" class="form-label">Driver Phone <span class="text-danger">*</span></label>
                                        <x-input type="text" name="driver_phone" id="driver_phone" :value="old('driver_phone')" required placeholder="Enter driver phone number" />
                                        @error('driver_phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="driver_license_number" class="form-label">Driver License Number</label>
                                        <x-input type="text" name="driver_license_number" id="driver_license_number" :value="old('driver_license_number')" placeholder="Enter license number" />
                                        @error('driver_license_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fare_amount" class="form-label">Fare Amount (₹)</label>
                                        <x-input type="number" name="fare_amount" id="fare_amount" :value="old('fare_amount')" step="0.01" min="0" placeholder="0.00" />
                                        @error('fare_amount')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="route_name" class="form-label">Route Name</label>
                                        <x-input type="text" name="route_name" id="route_name" :value="old('route_name')" placeholder="e.g., Route A, North Route" />
                                        @error('route_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="registration_date" class="form-label">Registration Date</label>
                                        <x-input type="date" name="registration_date" id="registration_date" :value="old('registration_date')" />
                                        @error('registration_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="insurance_expiry" class="form-label">Insurance Expiry Date</label>
                                        <x-input type="date" name="insurance_expiry" id="insurance_expiry" :value="old('insurance_expiry')" />
                                        @error('insurance_expiry')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="route_description" class="form-label">Route Description</label>
                                        <x-textarea name="route_description" id="route_description" rows="3" placeholder="Enter route details">{{ old('route_description') }}</x-textarea>
                                        @error('route_description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <x-textarea name="notes" id="notes" rows="3" placeholder="Enter any additional notes">{{ old('notes') }}</x-textarea>
                                        @error('notes')
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
                                    <button type="submit" class="btn btn-primary">Create Vehicle</button>
                                    <a href="{{ route('school-admin.transportation.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

