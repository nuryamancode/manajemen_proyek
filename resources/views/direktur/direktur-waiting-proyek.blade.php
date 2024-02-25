@extends('direktur.layouts.base-direktur', ['title' => 'Proyek Sedang Diproses'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Tabel Proses Proyek</h2>
            </div>
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
                    {{-- <a href="#" class="btn btn-success" data-bs-target="#modalTambah" data-bs-toggle="modal">
                        <i class="bi bi-person-fill-add"></i>
                        Tambah Data
                    </a> --}}
                </div>
                <table id="waiting" class="table table-responsive table-striped table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="text-center text-nowrap align-middle table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Proyek</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Nama Klien</th>
                            <th class="text-center">Email Klien</th>
                            <th class="text-center">Status Proyek</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyek as $item)
                            <tr class="text-nowrap align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_proyek }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ $item->klien->nama_klien }}</td>
                                <td>{{ $item->klien->email }}</td>
                                <td>

                                    {!! $item->status_proyek ? '<span class="status-waiting">Sedang diproses</span>' : '<span class="status-reject">Status bermasalah</span>' !!}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('direktur.detail.proyek', $item->id_proyek) }}"
                                        class="btn btn-secondary">
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


@endsection

@section('direktur-js')
    <script>
        new DataTable('#waiting', {
            fixedColumns: {
                left: 0,
                right: 1
            },
            scrollX: true,
            scrollXInner: "100%",
            autoWidth: false,

        });

        function konfirmasiHapus(deleteUrl) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah kamu yakin ingin menghapus ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes", proceed with the deletion
                    window.location = deleteUrl;
                }
            });
        }
    </script>
@endsection
