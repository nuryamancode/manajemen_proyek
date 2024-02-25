@extends('direktur.layouts.base-direktur', ['title' => 'Daftar Proyek'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Tabel Daftar Proyek</h2>
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
                <table id="daftarproyek" class="table table-responsive table-striped table-bordered mt-3"
                    style="width:100%">
                    <thead>
                        <tr class="text-center text-nowrap align-middle table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Proyek</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Nama Klien</th>
                            <th class="text-center">Email Klien</th>
                            <th class="text-center">Level Proyek</th>
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
                                <td>{{ $item->level_proyek }}</td>
                                <td>
                                    @if ($item->status_proyek === 'In Progress')
                                        <span class="status-waiting">Sedang diproses</span>
                                    @elseif($item->status_proyek === 'Done')
                                        <span class="status-done">Selesai</span>
                                    @elseif ($item->status_proyek === 'Reject')
                                        <span class="status-reject">Tidak Selesai</span>
                                    @elseif($item->status_proyek === 'Review')
                                        <span class="status-review">Sedang direviu</span>
                                    @else
                                        <span class="">Status bermasalah</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('direktur.tugas', $item->id_proyek) }}" class="btn btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($item->status_proyek == 'In Progress')
                                        <a href="#" class="btn btn-warning"
                                            data-bs-target="#modalEdit{{ $item->id_proyek }}" data-bs-toggle="modal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                        onclick="konfirmasiHapus('{{ route('direktur.delete.proyek', $item->id_proyek) }}')">
                                        <i class="bi bi-trash-fill"></i>
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
        <form action="{{ route('direktur.save.proyek') }}" method="POST">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">
                            <i class="bi bi-person-fill-add"></i>
                            Tambah Data
                        </h1>
                        <div class="">
                            <label for="message-text" class="" style="font-size: 10px">Level Proyek</label>
                            <select name="level_proyek" id="" class="form-select">
                                <option value="Mudah">Mudah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Sulit">Sulit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Proyek</label>
                            <input type="text" class="form-control" id="recipient-name" name="nama_proyek">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control" id="recipient-name" name="tanggal_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" id="recipient-name" name="tanggal_selesai">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Nama Klien</label>
                            <select name="klien_id" id="" class="form-select">
                                @foreach ($klien as $item)
                                    <option value="{{ $item->id_klien }}">{{ $item->nama_klien }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                aria-label="Close">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    @foreach ($proyek as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_proyek }}" tabindex="-1" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <form action="{{ route('direktur.update.proyek', $item->id_proyek) }}" method="POST">
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditLabel">
                                <i class="bi bi-pencil-square"></i>
                                Edit Data
                            </h1>
                            <div class="">
                                <label for="message-text" class="" style="font-size: 10px">Level Proyek</label>
                                <select name="level_proyek" id="" class="form-select">
                                    <option value="Mudah">Mudah</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Sulit">Sulit</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            @method('put')
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Proyek</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_proyek"
                                    value="{{ $item->nama_proyek }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Tanggal Mulai</label>
                                <input type="datetime-local" class="form-control" id="recipient-name"
                                    name="tanggal_mulai" value="{{ $item->tanggal_mulai }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Tanggal Selesai</label>
                                <input type="datetime-local" class="form-control" id="recipient-name"
                                    name="tanggal_selesai" value="{{ $item->tanggal_selesai }}">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Nama Klien</label>
                                <select name="klien_id" id="" class="form-select">
                                    <option selected value="{{ $item->klien->id_klien }}">{{ $item->klien->nama_klien }}
                                    </option>
                                    @foreach ($klien as $item)
                                        <option value="{{ $item->id_klien }}">{{ $item->nama_klien }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach


@endsection

@section('direktur-js')
    <script>
        new DataTable('#daftarproyek', {
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
                    window.location = deleteUrl;
                }
            });
        }
    </script>
@endsection
