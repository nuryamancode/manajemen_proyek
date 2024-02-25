@extends('hr.layouts.base-hr', ['title' => 'Kriteria'])

@section('content-hr')
    <div class="container-fluid">
        <div class="card mb-3 mt-3">
            <div class="card-header">
                <h2 class="title-name">Tabel Kriteria</h2>
            </div>
            <p class="p-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat enim, vel nisi quis, minus
                voluptas
                ullam perspiciatis ut incidunt ex voluptate. Eos esse nulla ut iusto, enim quasi voluptatum. Asperiores.
            </p>
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
                    </div>
                @endif
                <div class="text-end mb-3">
                    <a href="#" class="btn btn-success" data-bs-target="#modalTambah" data-bs-toggle="modal">
                        <i class="bi bi-person-fill-add"></i>
                        Tambah Data
                    </a>
                </div>
                <table id="kriteria" class="table table-responsive table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="table-dark">
                            <th>No</th>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kriteria as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kriteria }}</td>
                                <td>{{ intval($item->bobot_kriteria) }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('hr.delete.kriteria', $item->id_kriteria) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-success"
                                        data-bs-target="#modalEdit{{ $item->id_kriteria }}" data-bs-toggle="modal">
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
                        <i class="bi bi-person-fill-add"></i>
                        Tambah Data
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hr.add.kriteria') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Kriteria</label>
                            <input type="text" class="form-control" id="recipient-name" name="nama_kriteria">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nilai Preferensi</label>
                            <input type="number" class="form-control" id="recipient-name" name="bobot" max="100">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @foreach ($kriteria as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_kriteria }}" tabindex="-1" aria-labelledby="modalEditLabel"
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
                        <form action="{{ route('hr.update.kriteria', $item->id_kriteria) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Kriteria</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_kriteria"
                                    value="{{ $item->nama_kriteria }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nilai Preferensi</label>
                                <input type="number" class="form-control" id="recipient-name" name="bobot"
                                    max="100" value="{{ intval($item->bobot_kriteria) }}">
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
        new DataTable('#kriteria');

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
                    window.location = deleteUrl;
                }
            });
        }
    </script>
@endsection
