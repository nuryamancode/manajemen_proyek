@extends('karyawan.layouts.base_karyawan', ['title' => 'Detail Daftar Tugas'])

@section('content')
    <style>
        html[data-bs-theme=dark] .navbar-bg {
            background: #1E1E2D;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        html[data-bs-theme=dark] .main-title {
            color: #1E1E2D;
        }
    </style>
    <div class="container mt-3">
        <div class="container-fluid">
            <span class="mb-3"><a href="{{ route('karyawan.daftartugas') }}" class="btn-primary">
                    <i class="bi bi-caret-left-fill"></i>
                    Kembali</a>
            </span>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $item)
                                        <li>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h2 class="main-title">Detail Tugas</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-between">
                                <div class="col-4">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label">Nama Proyek</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">
                                            {{ $tugas->proyek->nama_proyek }}
                                        </h6>
                                        <label for="proyek" class="form-label mt-3">Nama Klien</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">
                                            {{ $tugas->proyek->klien->nama_klien }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label">Nama Penanggung Jawab</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">{{ $tugas->karyawan->name }}
                                        </h6>
                                        <label for="proyek" class="form-label mt-3">Tugas</label>
                                        <h6 class="title-sub text-uppercase">
                                            {{ $tugas->nama_tugas }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label">Divisi</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">
                                            {{ $tugas->karyawan->bidang->nama_bidang ?? 'Belum ditambahkan' }}
                                        </h6>
                                        <label for="proyek" class="form-label mt-3">Deadline Tugas</label>
                                        <h6 class="title-sub text-uppercase">
                                            {{ \Carbon\Carbon::parse($tugas->deadline_tugas)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h2 class="main-title">Tugas</h2>
                                </div>
                                <div class="col text-end">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Keterangan Tugas</label>
                                <textarea class="form-control" id="floatingTextarea" style="height: 100px" name="keterangan_tugas" disabled>{{ $tugas->keterangan_tugas }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Berkas Tugas</label>
                                <div>
                                    <label for="recipient-name" class="col-form-label">
                                        @if ($tugas->berkas_tugas === null)
                                            Tidak ada berkas tugas
                                        @else
                                            <a href="{{ route('karyawan.download.proyek', $tugas->berkas_tugas) }}"
                                                class="justify-content-center align-content-center">
                                                @if (in_array(pathinfo($tugas->berkas_tugas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->berkas_tugas }}
                                                @elseif(pathinfo($tugas->berkas_tugas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->berkas_tugas }}
                                                @elseif(in_array(pathinfo($tugas->berkas_tugas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->berkas_tugas }}
                                                @elseif(in_array(pathinfo($tugas->berkas_tugas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->berkas_tugas }}
                                                @elseif(in_array(pathinfo($tugas->berkas_tugas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->berkas_tugas }}
                                                @endif
                                            </a>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @if ($tugas->status_tugas != 'Review')
                                @if ($tugas->status_tugas != 'Selesai')
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalTambah">
                                        <i data-feather="folder" class="feather-icon "></i>
                                        Uplod Tugas
                                    </a>
                                @else
                                    <label for="recipient-name" class="col-form-label">Tugas Selesai</label>
                                    @endif
                                    @else
                                    <label for="recipient-name" class="col-form-label">Tugas Sedang Direviu</label>
                            @endif
                            <p class="mt-2" style="font-size: 13px">Silahkan upload hasil tugas yang
                                anda
                                kerjakan dan selalu cek kembali agar dapat melihat status dari proyek
                                yang
                                anda kerjakan</p>

                            <table class="table table-responsive table-bordered mt-3 border-dark" style="width:100%">
                                <thead>
                                    <tr class="text-center text-nowrap table-primary border-dark">
                                        <th class="text-center">Status Tugas</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            @if ($tugas->status_tugas === 'Proses')
                                                <span class="status-waiting">Sedang
                                                    diproses</span>
                                            @elseif($tugas->status_tugas === 'Selesai')
                                                <span class="status-done">Selesai</span>
                                            @elseif ($tugas->status_tugas === 'Revisi')
                                                <span class="status-reject">Sedang direvisi</span>
                                            @elseif($tugas->status_tugas === 'Review')
                                                <span class="status-review">Sedang
                                                    direview</span>
                                            @else
                                                <span class="">Status
                                                    bermasalah</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($tugas->upload_berkas === null)
                                                File Kosong
                                            @else
                                                <a href="{{ route('karyawan.download.daftartugas', $tugas->upload_berkas) }}"
                                                    class="justify-content-center align-content-center">
                                                    @if (in_array(pathinfo($tugas->upload_berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                        <img src="{{ asset('assets/image/icons/word.png') }}"
                                                            alt="" srcset="" width="18px">
                                                        {{ $tugas->upload_berkas }}
                                                    @elseif(pathinfo($tugas->upload_berkas, PATHINFO_EXTENSION) == 'pdf')
                                                        <img src="{{ asset('assets/image/icons/pdf.png') }}"
                                                            alt="" srcset="" width="18px">
                                                        {{ $tugas->upload_berkas }}
                                                    @elseif(in_array(pathinfo($tugas->upload_berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                        <img src="{{ asset('assets/image/icons/excel.png') }}"
                                                            alt="" srcset="" width="18px">
                                                        {{ $tugas->upload_berkas }}
                                                    @elseif(in_array(pathinfo($tugas->upload_berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                        <img src="{{ asset('assets/image/icons/zip.png') }}"
                                                            alt="" srcset="" width="18px">
                                                        {{ $tugas->upload_berkas }}
                                                    @elseif(in_array(pathinfo($tugas->upload_berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                        <img src="{{ asset('assets/image/icons/image.png') }}"
                                                            alt="" srcset="" width="18px">
                                                        {{ $tugas->upload_berkas }}
                                                    @endif
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $tugas->catatan_revisi }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- modal tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahLabel">
                        <i data-feather="folder-plus" class="feather-icon "></i>
                        Upload Tugas
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('karyawan.upload.daftartugas', $tugas->id_tugas) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="inputGroupFile04" class="form-label">Unggah Tugas</label>
                            <div class="input-group">
                                <input name="upload_berkas" type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-primary" type="submit">Kirim</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Catatan Tugas</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                    name="catatan_karyawan"></textarea>
                                <label for="floatingTextarea2">Masukkan catatan (jika ada)</label>
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
    {{-- modal tambah --}}
@endsection
