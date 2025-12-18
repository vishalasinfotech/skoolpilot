<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | Register School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @include('layouts.header')

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Register Your School</h5>
                                    <p class="text-muted">Create your school and admin account to get started</p>
                                </div>

                                <div class="p-2 mt-4">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('school.register.store') }}"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="school_name" class="form-label">School Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="school_name"
                                                    class="form-control @error('school_name') is-invalid @enderror"
                                                    id="school_name" placeholder="Enter school name"
                                                    value="{{ old('school_name') }}" required>
                                                @error('school_name')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="school_email" class="form-label">School Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="school_email"
                                                    class="form-control @error('school_email') is-invalid @enderror"
                                                    id="school_email" placeholder="Enter school email"
                                                    value="{{ old('school_email') }}" required>
                                                @error('school_email')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="school_phone" class="form-label">School Phone</label>
                                                <input type="text" name="school_phone"
                                                    class="form-control @error('school_phone') is-invalid @enderror"
                                                    id="school_phone" placeholder="Enter school phone"
                                                    value="{{ old('school_phone') }}">
                                                @error('school_phone')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="subscription_plan_id" class="form-label">Subscription Plan
                                                    (optional)</label>
                                                <select name="subscription_plan_id"
                                                    class="form-select @error('subscription_plan_id') is-invalid @enderror"
                                                    id="subscription_plan_id">
                                                    <option value="">Select a plan</option>
                                                    @foreach ($subscriptionPlans as $plan)
                                                        <option value="{{ $plan->id }}"
                                                            {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subscription_plan_id')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="school_address" class="form-label">School Address</label>
                                            <textarea name="school_address" id="school_address"
                                                class="form-control @error('school_address') is-invalid @enderror" rows="3"
                                                placeholder="Enter school address">{{ old('school_address') }}</textarea>
                                            @error('school_address')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="logo" class="form-label">School Logo (optional)</label>
                                                <input type="file" name="logo"
                                                    class="form-control @error('logo') is-invalid @enderror"
                                                    id="logo" accept="image/*">
                                                @error('logo')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="theme_color" class="form-label">Theme Color <span
                                                        class="text-danger">*</span></label>
                                                <input type="color" name="theme_color"
                                                    class="form-control form-control-color @error('theme_color') is-invalid @enderror"
                                                    id="theme_color" value="{{ old('theme_color', '#3B82F6') }}"
                                                    required>
                                                @error('theme_color')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <h6 class="mb-3">Admin Account</h6>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="admin_name" class="form-label">Admin Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="admin_name"
                                                    class="form-control @error('admin_name') is-invalid @enderror"
                                                    id="admin_name" placeholder="Enter admin name"
                                                    value="{{ old('admin_name') }}" required>
                                                @error('admin_name')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="admin_email" class="form-label">Admin Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="admin_email"
                                                    class="form-control @error('admin_email') is-invalid @enderror"
                                                    id="admin_email" placeholder="Enter admin email"
                                                    value="{{ old('admin_email') }}" required>
                                                @error('admin_email')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">Password <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Enter password"
                                                    autocomplete="new-password" required>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    id="password_confirmation" placeholder="Confirm password"
                                                    autocomplete="new-password" required>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex gap-2">
                                            <button class="btn btn-success" type="submit">Register School</button>
                                            <a class="btn btn-light" href="{{ route('login') }}">Back to Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
    <!-- end auth-page-wrapper -->

    @include('layouts.script')
</body>

</html>


