@extends('hr.layouts.base-hr', ['title' => 'Rekap Hasil Penilaian'])

@section('content-hr')
    <div class="container-fluid">
        <div class="card mb-3 mt-3">
            <div class="card-body">
                <h2 class="title-name">Tabel Rekap Hasil Penilaian</h2>
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
                        <i class="bi bi-person-fill-add"></i>
                        Tambah Data
                    </a>
                </div>
                <table id="rekaphasilpenilaian" class="table table-striped table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="table-dark">
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Nama Penanggung Jawab</th>
                            <th>Divisi</th>
                            <th>Nama Klien</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->role === 'Direktur' ? ($item->direktur ? $item->direktur->name : 'Belum Ditambahkan') : ($item->role === 'Karyawan' ? ($item->karyawan ? $item->karyawan->name : 'Belum Ditambahkan') : 'Belum Ditambahkan') }}
                                </td>
                                <td>{{ $item->email }}</td>
                                <td>{!! $item->email_verified_at
                                    ? '<span class="verifikasi-done">Sudah Terverifikasi</span>'
                                    : '<span class="verifikasi-not">Belum Terverifikasi</span>' !!}</td>
                                <td>{{ $item->role }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('hr.manageuser.delete', $item->id) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-success" data-bs-target="#modalEdit{{ $item->id }}"
                                        data-bs-toggle="modal">
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
                    <form action="{{ route('hr.manageuser.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="recipient-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Email</label>
                            <input type="text" class="form-control" id="recipient-name" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Password</label>
                            <input type="password" class="form-control" id="recipient-name" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Peran/Role</label>
                            <select class="form-select" aria-label="Default select example" name="role">
                                <option value="Direktur">Direktur</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @foreach ($user as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditLabel"
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
                        <form action="{{ route('hr.manageuser.edit', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="recipient-name" name="name"
                                    value="{{ $item->role === 'Direktur' ? ($item->direktur ? $item->direktur->name : 'Belum Ditambahkan') : ($item->role === 'Karyawan' ? ($item->karyawan ? $item->karyawan->name : 'Belum Ditambahkan') : 'Belum Ditambahkan') }}">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Email</label>
                                <input type="text" class="form-control" id="recipient-name" name="email"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="mb-3">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <a class="btn btn-accordion" style="width: 100%; height:40px" href="#" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                Change Password
                                            </a>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <label for="message-text" class="col-form-label">Password</label>
                                                <input type="password" class="form-control" id="recipient-name"
                                                    name="password" value="{{ $item->password }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

@section('hr-js')
    <script>
        new DataTable('#rekaphasilpenilaian');

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
