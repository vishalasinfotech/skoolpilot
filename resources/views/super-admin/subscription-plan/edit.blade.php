@extends('layouts.master')
@section('title', 'Edit Subscription Plan')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Subscription Plan</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Subscription Plans</a></li>
                                <li class="breadcrumb-item active">Edit Plan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Edit Subscription Plan Form -->
            <div class="row mt-4">
                <div class="col-lg-12 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Subscription Plan</h5>
                            <a href="{{ route('super-admin.subscription-plan.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('super-admin.subscription-plan.update', $subscriptionPlan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name', $subscriptionPlan->name)" required autofocus placeholder="Enter plan name" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description/Helping Message</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter a helpful description for this plan">{{ old('description', $subscriptionPlan->description) }}</x-textarea>
                                        @error('description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">This message will help users understand what this plan offers.</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">Regular Price <span class="text-danger">*</span></label>
                                        <x-input type="number" name="price" id="price" :value="old('price', $subscriptionPlan->price)" required placeholder="0.00" step="0.01" min="0" />
                                        @error('price')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="offer_price" class="form-label">Offer Price (Optional)</label>
                                        <x-input type="number" name="offer_price" id="offer_price" :value="old('offer_price', $subscriptionPlan->offer_price)" placeholder="0.00" step="0.01" min="0" />
                                        @error('offer_price')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">Leave empty if no discount applies. Must be less than regular price.</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <x-select name="type" id="type" :options="[
                                            'monthly' => 'Monthly',
                                            'quarterly' => 'Quarterly',
                                            'yearly' => 'Yearly',
                                            'lifetime' => 'Lifetime',
                                        ]" :value="old('type', $subscriptionPlan->type)" required placeholder="Select Type" />
                                        @error('type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="tier" class="form-label">Tier <span class="text-danger">*</span></label>
                                        <x-select name="tier" id="tier" :options="[
                                            'basic' => 'Basic',
                                            'standard' => 'Standard',
                                            'premium' => 'Premium',
                                        ]" :value="old('tier', $subscriptionPlan->tier)" required placeholder="Select Tier" />
                                        @error('tier')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="plan_status" class="form-label">Plan Status <span class="text-danger">*</span></label>
                                        <x-select name="plan_status" id="plan_status" :options="[
                                            'free' => 'Free',
                                            'paid' => 'Paid',
                                        ]" :value="old('plan_status', $subscriptionPlan->plan_status)" required placeholder="Select Status" />
                                        @error('plan_status')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="trial_days" class="form-label">Trial Days <span class="text-danger">*</span></label>
                                        <x-input type="number" name="trial_days" id="trial_days" :value="old('trial_days', $subscriptionPlan->trial_days)" required min="0" max="365" />
                                        @error('trial_days')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="features" class="form-label">Features</label>
                                        <div id="features-container">
                                            @if(old('features'))
                                                @foreach(old('features') as $index => $feature)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="features[]" value="{{ $feature }}" placeholder="Enter feature" class="form-control" />
                                                        @if($index === 0)
                                                            <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                                <i class="ri-add-line"></i> Add Feature
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                                <i class="ri-subtract-line"></i> Remove
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @elseif($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                                @foreach($subscriptionPlan->features as $index => $feature)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="features[]" value="{{ $feature }}" placeholder="Enter feature" class="form-control" />
                                                        @if($index === 0)
                                                            <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                                <i class="ri-add-line"></i> Add Feature
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                                <i class="ri-subtract-line"></i> Remove
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="text" name="features[]" placeholder="Enter feature" class="form-control" />
                                                    <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                        <i class="ri-add-line"></i> Add Feature
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        @error('features')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">Add features one by one. Leave empty if not applicable.</small>
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Plan</button>
                                    <a href="{{ route('super-admin.subscription-plan.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Subscription Plan Form -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @push('scripts')
    <script>
        function addFeatureField() {
            const container = document.getElementById('features-container');
            const newField = document.createElement('div');
            newField.className = 'input-group mb-2';
            newField.innerHTML = `
                <input type="text" name="features[]" placeholder="Enter feature" class="form-control" />
                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                    <i class="ri-subtract-line"></i> Remove
                </button>
            `;
            container.appendChild(newField);
        }
    </script>
    @endpush
@endsection

