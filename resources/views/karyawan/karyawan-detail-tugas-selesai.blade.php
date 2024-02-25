@extends('karyawan.layouts.base_karyawan', ['title' => 'Detail Daftar Tugas Terselesaikan'])

@section('contents')
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
    <div class="container" style="margin-top: 50px">
        <div class="container-fluid">
            <span class="mb-3"><a href="{{ route('karyawan.tugas-selesai') }}" class="btn-primary">
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
                                <div class="col text-end">
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
                                        <h6 class="title-sub text-uppercase" id="proyek">{{ $tugas->klien->nama_klien }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label">Nama Penanggung Jawab</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">{{ $tugas->karyawan->name }}
                                        </h6>
                                        <label for="proyek" class="form-label mt-3">Tanggal Tugas</label>
                                        <h6 class="title-sub text-uppercase">
                                            {{ \Carbon\Carbon::parse($tugas->tanggal_tugas)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label">Divisi</label>
                                        <h6 class="title-sub text-uppercase" id="proyek">
                                            {{ $tugas->karyawan->bidang->nama_bidang }}
                                        </h6>
                                        <label for="proyek" class="form-label mt-3">Tanggal Selesai</label>
                                        <h6 class="title-sub text-uppercase">
                                            {{ \Carbon\Carbon::parse($tugas->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
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
                                    <h2 class="main-title">Progress Proyek</h2>
                                </div>
                                <div class="col text-end">
                                    <h6 class="title-sub mt-2" id="proyek">
                                        Status :
                                        @if ($tugas->proyek->status === 'Waiting')
                                            <span class="status-waiting">Sedang
                                                diproses</span>
                                        @elseif($tugas->proyek->status === 'Done')
                                            <span class="status-done">Selesai</span>
                                        @elseif ($tugas->proyek->status === 'Reject')
                                            <span class="status-reject">Tidak Selesai</span>
                                        @elseif($tugas->proyek->status === 'Review')
                                            <span class="status-review">Sedang
                                                direviu</span>
                                        @else
                                            <span class="">Status
                                                bermasalah</span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="text p-3">
                                        <label for="proyek" class="form-label mt-3">Dokumen Hasil Proyek</label>
                                        <h6 class="title-sub text-uppercase">
                                            <a href="{{ route('karyawan.download.proyek', $tugas->proyek->berkas) }}"
                                                class="justify-content-center align-content-center upload">
                                                @if (in_array(pathinfo($tugas->proyek->berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->proyek->berkas }}
                                                @elseif(pathinfo($tugas->proyek->berkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->proyek->berkas }}
                                                @elseif(in_array(pathinfo($tugas->proyek->berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->proyek->berkas }}
                                                @elseif(in_array(pathinfo($tugas->proyek->berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->proyek->berkas }}
                                                @elseif(in_array(pathinfo($tugas->proyek->berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->proyek->berkas }}
                                                @endif
                                            </a>
                                        </h6>


                                        <label for="proyek" class="form-label mt-3">Dokumen Berkas Proyek</label>
                                        <h6 class="title-sub text-uppercase">
                                            <a href="{{ route('karyawan.download.daftartugas', $tugas->uploadberkas) }}"
                                                class="justify-content-center align-content-center upload">
                                                @if (in_array(pathinfo($tugas->uploadberkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->uploadberkas }}
                                                @elseif(pathinfo($tugas->uploadberkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->uploadberkas }}
                                                @elseif(in_array(pathinfo($tugas->uploadberkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->uploadberkas }}
                                                @elseif(in_array(pathinfo($tugas->uploadberkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->uploadberkas }}
                                                @elseif(in_array(pathinfo($tugas->uploadberkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                    {{ $tugas->uploadberkas }}
                                                @endif
                                            </a>
                                        </h6>

                                        {{-- <label for="alamat" class="form-label mt-2">Catatan Tugas</label> --}}
                                        <textarea disabled class="form-control mt-4" placeholder="" id="floatingTextarea"style="height: 100px">{{ $tugas->catatan ?? 'Tidak ada catatan' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
