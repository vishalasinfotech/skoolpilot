@extends('layouts.master')
@section('title', 'Profile')
@section('main-container')

    <div class="page-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="{{ $user->profile_image ? asset($user->profile_image) : asset('admin_theme/assets/images/default/default.png') }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image" id="profile-image-preview">

                                </div>
                                <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->designation ?? $user->role ?? 'User' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">First Name</label>
                                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                        id="firstnameInput" name="first_name"
                                                        placeholder="Enter your firstname" value="{{ old('first_name', $user->first_name) }}">
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                        id="lastnameInput" name="last_name"
                                                        placeholder="Enter your lastname" value="{{ old('last_name', $user->last_name) }}">
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                        id="phonenumberInput" name="phone"
                                                        placeholder="Enter your phone number" value="{{ old('phone', $user->phone) }}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                        id="emailInput" name="email"
                                                        placeholder="Enter your email" value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <a href="{{ route('profile') }}" class="btn btn-soft-success">Cancel</a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="{{ route('profile.change-password') }}" method="POST" id="password-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput" class="form-label">Old Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                                        id="oldpasswordInput" name="old_password"
                                                        placeholder="Enter current password" required>
                                                    @error('old_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput" class="form-label">New Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                        id="newpasswordInput" name="password"
                                                        placeholder="Enter new password" required>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        id="confirmpasswordInput" name="password_confirmation"
                                                        placeholder="Confirm password" required>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Change Password</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>

                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
@endsection
