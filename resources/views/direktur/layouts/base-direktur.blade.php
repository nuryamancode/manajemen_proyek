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
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    @stack('css')
    <style>
        table.dataTable thead tr>.dtfc-fixed-right {
            background-color: #2A3547;
        }

        /* table.dataTable tbody tr>.dtfc-fixed-right {
            background-color: #2A3547;
        } */
    </style>

</head>

<body>
    <script src="{{ asset('assets/hd/js/dark/theme.js') }}"></script>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('direktur.layouts.sidebar-direktur')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            {{-- Navbar --}}
            @include('direktur.layouts.navbar-direktur')
            @yield('content-direktur')
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        new DataTable('#tugaskar', {
            fixedColumns: {
                left: 0,
                right: 1
            },
            scrollX: true,
            scrollXInner: "100%",
            autoWidth: false,

        });
    </script>

    @yield('direktur-js')
    @stack('js')

</body>

</html>
