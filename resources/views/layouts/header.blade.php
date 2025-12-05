
 <!--datatable css-->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
 <!--datatable responsive css-->
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

 <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- jsvectormap css -->
<link href="{{ asset('admin_theme/assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

<!--Swiper slider css-->
<link href="{{ asset('admin_theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Layout config Js -->
<script src="{{ asset('admin_theme/assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ asset('admin_theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('admin_theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('admin_theme/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ asset('admin_theme/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

@livewireStyles

@yield('stylesheet')
