<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/image/mareca.png') }}">
    <title>{{ $title ?? config('app.name') }} - SIMPRODPEK</title>
    <link rel="stylesheet" href="{{ asset('assets/hd/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/hd/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <script src="{{ asset('assets/hd/js/dark/theme.js') }}"></script>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('hr.layouts.sidebar-hr')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            {{-- Navbar --}}
            @include('hr.layouts.navbar-hr')
            @yield('content-hr')
        </div>
        @include('layoutsall.footer-hd')
    </div>
    @include('vendor.sweetalert.alert')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('assets/hd/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/hd/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/hd/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/hd/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/hd/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/hd/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/hd/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/hd/js/dark/darktoogle.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @yield('hr-js')

</body>

</html>
