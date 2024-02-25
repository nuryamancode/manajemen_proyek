<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/image/mareca.png') }}">
    <title>{{ $title ?? config('app.name') }} - Simprodpek</title>
    <link href="{{ asset('karyawan/vendor/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('karyawan/vendor/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('karyawan/vendor/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('karyawan/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('karyawan/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">
    <style>
        table.dataTable thead tr>.dtfc-fixed-right {
            background-color: #1C2D41;
        }
    </style>


</head>

<body>
    {{-- PreLoader --}}
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    {{-- PreLoader --}}
    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- Topbar navbar -->
        @include('karyawan.layouts.navbar_karyawan')
        <!-- End Topbar navbar -->
        <!-- Sidebar  -->
        <aside class="left-sidebar" data-sidebarbg="skin6" style="background-color: #212529">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu text-white">Menu</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link" href="{{ route('karyawan.dashboard') }}">
                                <i data-feather="home" class="feather-icon text-white"></i>
                                <span class="hide-menu text-white">Dashboard</span>
                            </a>
                        </li>
                        <li class="list-divider bg-white"></li>
                        <li class="nav-small-cap">
                            <span class="hide-menu text-white">Proyek</span>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('karyawan.daftartugas') }}">
                                <i data-feather="folder" class="feather-icon text-white"></i>
                                <span class="hide-menu text-white">Daftar Tugas Proyek</span>
                            </a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                href="{{ route('karyawan.tugas-selesai') }}">
                                <i data-feather="check-square" class="feather-icon text-white"></i>
                                <span class="hide-menu text-white">Tugas Proyek Terselesaikan</span>
                            </a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="app-calendar.html"><i
                                    data-feather="clipboard" class="feather-icon text-white"></i>
                                <span class="hide-menu text-white">Hasil Kinerja Karyawan</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- End Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            @yield('content')
        </div>
        @include('karyawan.layouts.footer')
        <!-- End Page wrapper  -->
    </div>
    @include('vendor.sweetalert.alert')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('karyawan/js/feather.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('karyawan/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('karyawan/js/custom.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/c3/d3.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/c3/c3.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('karyawan/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#tugasdaftar', {
            fixedColumns: {
                left: 0,
                right: 1
            },
            scrollX: true,
            scrollXInner: "100%",
            autoWidth: true,

        });
    </script>

</body>

</html>
