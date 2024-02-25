@extends('karyawan.layouts.base_karyawan', ['title' => 'Daftar Tugas Terselesaikan'])

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">
@endsection

@section('content')
    <style>
        html[data-bs-theme=dark] .navbar-bg {
            background: #1E1E2D;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

        }
    </style>
    <div class="container" style="margin-top:80px;">
        <div class="card p-3">
            <div class="card-header">
                <h2 class="page-heading">Tabel Daftar Tugas Terselesaikan</h2>
            </div>
        </div>
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mt-2" style="margin-left: 45px; margin-right: 45px">
                            <ul class="text-start">
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success mt-2 text-start" style="margin-left: 45px; margin-right: 45px">
                            {{ session('success') }}
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                        </div>
                    @endif
                    <div class="text-end mb-3">
                    </div>
                    <table id="tugas_selesai" class="table table-responsive table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr class="text-center text-nowrap table-secondary">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Proyek</th>
                                <th class="text-center">Tanggal Tugas</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center">Penanggung Jawab</th>
                                <th class="text-center">Divisi</th>
                                <th class="text-center">Nama Klien</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas as $item)
                                <tr class="text-center text-nowrap">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->proyek->nama_proyek }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_tugas)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ $item->karyawan->name }}</td>
                                    <td>{{ $item->karyawan->bidang->nama_bidang }}</td>
                                    <td>{{ $item->klien->nama_klien }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('karyawan.detail.tugas-selesai', $item->id_tugas) }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        new DataTable('#tugas_selesai', {
            fixedColumns: {
                left: 0,
                right: 1
            },
            scrollX: true,
            scrollXInner: "100%",
            autoWidth: true,

        });
    </script>
@endsection
