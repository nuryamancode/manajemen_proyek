@extends('hr.layouts.base-hr', ['title' => 'Bidang Karyawan'])

@section('content-hr')
    <div class="container-fluid">
        <div class="card mb-3 mt-3">
            <div class="card-body">
                <h2 class="title-name">Tabel Bidang Karyawan</h2>
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
                    <a href="#" class="btn btn-success" data-bs-target="#modalTambah" data-bs-toggle="modal">
                        <i class="bi bi-database-fill-add"></i>
                        Tambah Data
                    </a>
                </div>
                <table id="databidang" class="table table-striped table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="table-dark">
                            <th>No</th>
                            <th>Nama Bidang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bidang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_bidang }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('hr.delete.bidang', $item->id_bidang) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-success"
                                        data-bs-target="#modalEdit{{ $item->id_bidang }}" data-bs-toggle="modal">
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


    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahLabel">
                        <i class="bi bi-database-fill-add"></i>
                        Tambah Data
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hr.save.bidang') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Bidang</label>
                            <input type="text" class="form-control" id="recipient-name" name="nama_bidang">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @foreach ($bidang as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_bidang }}" tabindex="-1" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditLabel">
                            <i class="bi bi-pen-fill"></i>
                            Edit Data
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hr.update.bidang', $item->id_bidang) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Bidang</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_bidang"
                                    value="{{ $item->nama_bidang }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ubah</button>
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
        new DataTable('#databidang');

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
