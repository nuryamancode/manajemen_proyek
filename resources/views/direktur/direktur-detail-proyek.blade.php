@extends('direktur.layouts.base-direktur', ['title' => 'Detail Proyek'])

@section('content-direktur')
    <div class="container-fluid">
        <span class="mb-3"><a href="{{ route('direktur.proyek') }}" class="btn-primary">
                <i class="bi bi-caret-left-fill"></i>
                Kembali</a></span>
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-header">
                <h1 class="main-title mt-3">Detail Proyek</h1>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text p-3">
                            <h2 class="main-title" style="color: #5D87FF">Data Klien</h2>
                            <h6 class="">Nama Klien : <span class="main-title">{{ $proyek->klien->nama_klien }}</span>
                            </h6>
                            <h6 class="">Email Klien : <span class="main-title">{{ $proyek->klien->email }}</span>
                            </h6>
                            <h6 class="">Alamat Klien : <span class="main-title">{{ $proyek->klien->alamat }}</span>
                            </h6>
                            <h6 class="">Nomor Handphone Klien : <span
                                    class="main-title">{{ $proyek->klien->nomor_handphone }}</span></h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text p-3">
                            <h2 class="main-title" style="color:#65E9D1">Data Proyek</h2>
                            <h6 class="">Nama Proyek : <span class="main-title">{{ $proyek->nama_proyek }}</span></h6>
                            <h6 class="">Tanggal Mulai : <span
                                    class="main-title">{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}</span>
                            </h6>
                            <h6 class="">Tanggal Selesai : <span
                                    class="main-title">{{ \Carbon\Carbon::parse($proyek->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}</span>
                            </h6>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mt-3 text-end">
                            <h6 class="mt-4">Status :
                                <span class="main-title">
                                    @if ($proyek->status === 'Waiting')
                                        <span class="status-waiting">Sedang diproses</span>
                                    @elseif ($proyek->status === 'Done')
                                        <span class="status-done">Selesai</span>
                                    @elseif ($proyek->status === 'Reject')
                                        <span class="status-reject">Tidak selesai</span>
                                    @elseif ($proyek->status === 'Review')
                                        <span class="status-review">Sedang direviu</span>
                                    @else
                                        <span class="btn btn-primary disabled">Status Tidak Valid</span>
                                    @endif
                                </span>
                            </h6>
                            <div class="mt-3">
                                <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                    onclick="konfirmasiHapus('{{ route('direktur.delete.proyek', $proyek->id_proyek) }}')">
                                    <i class="bi bi-trash-fill"></i>
                                    Hapus Proyek
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col">
                        @if ($proyek->status != 'Done')
                            <h6 class="">Berkas Proyek</h6>
                                <a href="{{ route('direktur.download.proyek', $proyek->berkas) }}"
                                    class="justify-content-center align-content-center">
                                    @if (in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                        <img src="{{ asset('assets/image/icons/word.png') }}" alt="" srcset=""
                                            width="18px">
                                        {{ $proyek->berkas }}
                                    @elseif(pathinfo($proyek->berkas, PATHINFO_EXTENSION) == 'pdf')
                                        <img src="{{ asset('assets/image/icons/pdf.png') }}" alt="" srcset=""
                                            width="18px">
                                        {{ $proyek->berkas }}
                                    @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                        <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                            srcset="" width="18px">
                                        {{ $proyek->berkas }}
                                    @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                        <img src="{{ asset('assets/image/icons/zip.png') }}" alt="" srcset=""
                                            width="18px">
                                        {{ $proyek->berkas }}
                                    @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                        <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                            srcset="" width="18px">
                                        {{ $proyek->berkas }}
                                    @endif
                                </a>
                        @endif
                    </div>
                </div>
                @if ($proyek->status == 'Done')
                    <div class="row p-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="main-title" tyle="color: #5D87FF">Hasil Proyek</h2>
                                </div>
                                <div class="card-body">
                                    <div class="mt-2">
                                        <h6 class="">Dokumen Berkas Proyek</h6>
                                        <h6 class="main-title">
                                            <a href="{{ route('direktur.download.proyek', $proyek->berkas) }}"
                                                class="justify-content-center align-content-center">
                                                @if (in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->berkas }}
                                                @elseif(pathinfo($proyek->berkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->berkas }}
                                                @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->berkas }}
                                                @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->berkas }}
                                                @elseif(in_array(pathinfo($proyek->berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->berkas }}
                                                @endif
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="">Dokumen Hasil Proyek</h6>
                                        <h6 class="main-title">
                                            <a href="{{ route('direktur.download.tugas', $proyek->tugas_karyawan->uploadberkas) }}"
                                                class="justify-content-center align-content-center">
                                                @if (in_array(pathinfo($proyek->tugas_karyawan->uploadberkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->tugas_karyawan->uploadberkas }}
                                                @elseif(pathinfo($proyek->tugas_karyawan->uploadberkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->tugas_karyawan->uploadberkas }}
                                                @elseif(in_array(pathinfo($proyek->tugas_karyawan->uploadberkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->tugas_karyawan->uploadberkas }}
                                                @elseif(in_array(pathinfo($proyek->tugas_karyawan->uploadberkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->tugas_karyawan->uploadberkas }}
                                                @elseif(in_array(pathinfo($proyek->tugas_karyawan->uploadberkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $proyek->tugas_karyawan->uploadberkas }}
                                                @endif
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($proyek->status != 'Done')
                    <div class="row p-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="main-title" style="color: #5D87FF">Klien</h2>
                                </div>
                                <div class="card-body">
                                    <div class="form-container" id="klienform">
                                        <form action="{{ route('direktur.update.klien', $proyek->klien->id_klien) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="recipient-name"
                                                    name="name" value="{{ $proyek->klien->nama_klien }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Email</label>
                                                <input type="email" class="form-control" id="recipient-name"
                                                    name="email" value="{{ $proyek->klien->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Alamat Lengkap</label>
                                                <textarea class="form-control" placeholder="Masukkan alamat disini..." id="floatingTextarea" name="alamat">{{ $proyek->klien->alamat }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">No Handphone</label>
                                                <input type="text" class="form-control" id="recipient-name"
                                                    name="nomor_handphone" value="{{ $proyek->klien->nomor_handphone }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ubah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="main-title" style="color:#65E9D1">Proyek</h2>
                                </div>
                                <div class="card-body">
                                    <div class="form-container" id="klienform">
                                        <form action="{{ route('direktur.update.proyek', $proyek->id_proyek) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Nama Proyek</label>
                                                <input type="text" class="form-control" id="recipient-name"
                                                    name="nama_proyek" value="{{ $proyek->nama_proyek }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" id="recipient-name"
                                                    name="tanggal_mulai" value="{{ $proyek->tanggal_mulai }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="recipient-name"
                                                    name="tanggal_selesai" value="{{ $proyek->tanggal_selesai }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Berkas</label>
                                                <input type="file" class="form-control" id="recipient-name"
                                                    name="berkas" value="{{ $proyek->berkas }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Nama Klien</label>
                                                <select name="klien_id" id="" class="form-select">
                                                    <option value="{{ $proyek->klien->id_klien }}" selected>
                                                        {{ $proyek->klien->nama_klien }}</option>
                                                    @foreach ($klien as $item)
                                                        <option value="{{ $item->id_klien }}">{{ $item->nama_klien }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ubah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script>
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
<<<<<<< HEAD
=======
                        // If the user clicks "Yes", proceed with the deletion
>>>>>>> 712c05ef5196bc95eedc5fc7ff54baad76789018
                        window.location = deleteUrl;
                    }
                });
            }
        </script>
    @endsection
