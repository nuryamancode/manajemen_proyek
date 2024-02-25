@extends('hr.layouts.base-hr', ['title' => 'Data Karyawan'])

@section('content-hr')
    <div class="container-fluid">
        <div class="card mb-3 mt-3">
            <div class="card-body">
                <h2 class="title-name">Tabel Data Karyawan</h2>
            </div>
        </div>
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
                <table id="datakaryawan" class="table table-responsive table-striped table-bordered mt-3"
                    style="width:100%">
                    <thead>
                        <tr class="text-center text-nowrap align-middle table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Bidang</th>
                            <th class="text-center">Verifikasi Email</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">No Handphone</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $item)
                            <tr class="text-nowrap align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->bidang->nama_bidang ?? 'Belum ditambahkan' }}</td>
                                <td>{!! $item->user->email_verified_at
                                    ? '<span class="verifikasi-done">Sudah Terverifikasi</span>'
                                    : '<span class="verifikasi-not">Belum Terverifikasi</span>' !!}
                                </td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ $item->alamat ?? 'Belum ditambahkan' }}</td>
                                <td>{{ $item->no_handphone ?? 'Belum ditambahkan' }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('hr.datakaryawan.delete', $item->id_karyawan) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-success"
                                        data-bs-target="#modalEdit{{ $item->id_karyawan }}" data-bs-toggle="modal">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @foreach ($karyawan as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_karyawan }}" tabindex="-1" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditLabel">
                            <i class="bi bi-person-fill-add"></i>
                            Tambah Data Bidang
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hr.add.bidang', $item->id_karyawan) }}" method="POST">
                            @csrf
                            @method('put')
                            <select name="bidang_id" id="" class="form-select">
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id_bidang }}">{{ $item->nama_bidang }}</option>
                                @endforeach
                            </select>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('hr-js')
    <script>
        new DataTable('#datakaryawan', {
            scrollX: true,
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
