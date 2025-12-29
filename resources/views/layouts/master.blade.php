<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="School Management System by AS Infotech" />
    <meta name="author" content="AS Infotech" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset(setting('school_favicon', auth()->user()->school_id ?? null) ?? 'assets/images/favicon.ico') }}">

    @include('layouts.header')


</head>

<body>
    <div id="layout-wrapper">

        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <div class="main-content">
            @yield('main-container')
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    @stack('scripts')


    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</body>

</html>
