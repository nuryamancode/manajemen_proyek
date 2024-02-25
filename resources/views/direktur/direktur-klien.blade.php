@extends('direktur.layouts.base-direktur', ['title' => 'Daftar Klien'])


@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Tabel Daftar Klien</h2>
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
                    <a href="#" class="btn btn-success" data-bs-target="#modalTambah" data-bs-toggle="modal">
                        <i class="bi bi-person-fill-add"></i>
                        Tambah Data
                    </a>
                </div>
                <table id="klien"
                    class="table table-responsive table-bordered mt-3 table table-striped nowrap"
                    style="width:100%">
                    <thead>
                        <tr class="text-center table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">No Handphone</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($klien as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_klien }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->nomor_handphone }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('direktur.delete.klien', $item->id_klien) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-success"
                                        data-bs-target="#modalEdit{{ $item->id_klien }}" data-bs-toggle="modal">
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
                    <form action="{{ route('direktur.save.klien') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="recipient-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Email</label>
                            <input type="email" class="form-control" id="recipient-name" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Alamat Lengkap</label>
                            <textarea class="form-control" placeholder="Masukkan alamat disini..." id="floatingTextarea" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">No Handphone</label>
                            <input type="text" class="form-control" id="recipient-name" name="nomor_handphone">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @foreach ($klien as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_klien }}" tabindex="-1" aria-labelledby="modalEditLabel"
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
                        <form action="{{ route('direktur.update.klien', $item->id_klien) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="recipient-name" name="name"
                                    value="{{ $item->nama_klien }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="recipient-name" name="email"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Alamat Lengkap</label>
                                <textarea class="form-control" placeholder="Masukkan alamat disini..." id="floatingTextarea" name="alamat">{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">No Handphone</label>
                                <input type="text" class="form-control" id="recipient-name" name="nomor_handphone"
                                    value="{{ $item->nomor_handphone }}">
                            </div>
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

@section('direktur-js')
    <script>
        new DataTable('#klien', {
            fixedColumns:{
                left: 0,
                right:1
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
                    window.location = deleteUrl;
                }
            });
        }
    </script>
@endsection
