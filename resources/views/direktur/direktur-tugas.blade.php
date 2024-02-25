@extends('direktur.layouts.base-direktur', ['title' => 'Tugas Karyawan'])

@section('content-direktur')
    <style>
        .upload {
            color: #2A3547;
        }

        .upload:hover {
            color: #5D87FF;
        }
    </style>
    <div class="container-fluid">
        <span class="mb-3"><a href="{{ route('direktur.proyek') }}" class="btn-primary">
                <i class="bi bi-caret-left-fill"></i>
                Kembali</a></span>
        <div class="card mt-3">

            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h2 class="main-title">Tugas Karyawan</h2>
                            </div>
                            <div class="col text-end">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formFilterTugas" action=""{{ route('direktur.tugas', ['id_proyek' => $id_proyek]) }}
                            method="GET">
                            @csrf
                            <input type="hidden" name="proyek_id" id="" value="{{ $id_proyek }}">
                            <div class="mb-3">
                                <label for="inputGroupFile04" class="form-label fw-bold">Fase Proyek</label>
                                <div class="input-group">
                                    <select class="form-select" id="floatingSelectGrid" name="nama_fase"
                                        onchange="this.form.submit()">
                                        @if (!$fase->isEmpty())
                                            @if (!$tugas->isEmpty())
                                                @foreach ($fase->unique('fase_proyek') as $item)
                                                    <option value="{{ $item->fase_proyek }}"
                                                        @if ($selected_phase == $item->fase_proyek) selected @endif>
                                                        {{ $item->fase_proyek }}</option>
                                                @endforeach
                                            @else
                                                <option disabled selected>Pilih Fase</option>
                                                @foreach ($fase->unique('fase_proyek') as $item)
                                                    <option value="{{ $item->fase_proyek }}">{{ $item->fase_proyek }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @else
                                            <option disabled selected>Fase tidak tersedia</option>
                                        @endif
                                    </select>
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab">
                    <div class="text-end mb-3">
                        @if ($proyek->status_proyek === 'Done')
                            {{ null }}
                        @else
                            @if (!$fase->isEmpty())
                                @if (!$tugas->isEmpty())
                                    <a href="#" class="btn btn-success" data-bs-target="#modalProyek"
                                        data-bs-toggle="modal">
                                        <i class="bi bi-folder-check"></i>
                                        Proyek Selesai
                                    </a>
                                @else
                                    {{ null }}
                                @endif
                            @else
                                {{ null }}
                            @endif
                            <a href="#" class="btn btn-primary" data-bs-target="#modalTambah" data-bs-toggle="modal">
                                <i class="bi bi-patch-plus-fill"></i>
                                Tambah Data
                            </a>
                        @endif
                    </div>
                    <table id="tugaskar" class="table table-responsive table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr class="text-center text-nowrap align-middle table-dark">
                                <th class="text-center">No</th>
                                <th class="text-center">Tugas</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Deadline Tugas</th>
                                <th class="text-center">Penanggung Jawab</th>
                                <th class="text-center">Berkas Tugas</th>
                                <th class="text-center">Upload Berkas</th>
                                <th class="text-center">Status Tugas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas as $item)
                                <tr class="text-nowrap align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_tugas }}</td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($item->keterangan_tugas, 10) ?? 'Tidak ada keterangan' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->deadline_tugas)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    </td>

                                    <td>{{ $item->karyawan->name }}</td>
                                    <td>
                                        <a href="{{ route('direktur.download.proyek', $item->berkas_tugas) }}"
                                            class="justify-content-center align-content-center">
                                            @if (in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->upload_berkas)
                                            <a href="{{ route('direktur.download.tugas', $item->upload_berkas ?? 'Belum ditambahkan') }}"
                                                class="justify-content-center align-content-center">
                                                @if (in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(pathinfo($item->upload_berkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @endif
                                                {{ $item->upload_berkas }}
                                            </a>
                                        @else
                                            Belum ditambahkan
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status_tugas === 'Proses')
                                            <span class="status-waiting">Sedang dikerjakan</span>
                                        @elseif($item->status_tugas === 'Selesai')
                                            <span class="status-done">Selesai</span>
                                        @elseif ($item->status_tugas === 'Revisi')
                                            <span class="status-reject">Sedang direvisi</span>
                                        @elseif($item->status_tugas === 'Review')
                                            <span class="status-review">Sedang direview</span>
                                        @else
                                            <span class="">Status bermasalah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success"
                                            data-bs-target="#modalDetail{{ $item->id_tugas }}" data-bs-toggle="modal">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if (in_array($item->status_tugas, ['Review', 'Proses', 'Revisi']))
                                            <a href="#" class="btn btn-primary"
                                                data-bs-target="#modalEdit{{ $item->id_tugas }}" data-bs-toggle="modal">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif
                                        <a href="#" class="btn btn-secondary"
                                            data-bs-target="#modalTugas{{ $item->id_tugas }}" data-bs-toggle="modal">
                                            <i class="bi bi-folder-check"></i>
                                        </a>
                                        @if ($item->status_tugas == 'Revisi')
                                            <a href="#" class="btn btn-warning"
                                                data-bs-target="#selesaiModal{{ $item->id_tugas }}"
                                                data-bs-toggle="modal">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                        @endif
                                        @if (in_array($item->status_tugas, ['Review', 'Proses']))
                                            <a href="#" class="btn btn-warning"
                                                data-bs-target="#selesaiModal{{ $item->id_tugas }}"
                                                data-bs-toggle="modal">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger"
                                                data-bs-target="#belumSelesaiModal{{ $item->id_tugas }}"
                                                data-bs-toggle="modal">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- modal tambah --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">
                            <i class="bi bi-patch-plus-fill"></i>
                            Tambah Tugas
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('direktur.tambah.tugas') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="proyek_id" id="" value="{{ $id_proyek }}">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Fase Proyek</label>
                                <input type="text" class="form-control" id="recipient-name" name="fase_proyek">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Tugas</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_tugas">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Deadline Tugas</label>
                                <input type="date" class="form-control" id="recipient-name" name="deadline_tugas">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Berkas Tugas</label>
                                <input type="file" class="form-control" id="recipient-name" name="berkas_tugas">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Rekomendasi PJ</label>
                                <select name="karyawan_id" id="" class="form-select">
                                    @if ($tugas_all->isEmpty())
                                        @foreach ($karyawan as $item)
                                            <option value="{{ $item->id_karyawan }}">{{ $item->name }} - Proyek Belum Ada</option>
                                        @endforeach
                                    @else
                                        @php
                                        $alreadyDisplayed = []; @endphp
                                        @foreach ($tugas_all as $item)
                                            @php
                                                $karyawanProyek = $item->karyawan->name . '-' . $item->proyek->level_proyek;
                                            @endphp
                                            @if (!in_array($karyawanProyek, $alreadyDisplayed))
                                                @php $alreadyDisplayed[] = $karyawanProyek; @endphp
                                                <option value="{{ $item->karyawan->id_karyawan }}">
                                                    {{ $item->karyawan->name }} - Proyek {{ $item->proyek->nama_proyek }} Level ({{ $item->proyek->level_proyek }})
                                                </option>
                                            @endif
                                        @endforeach
                                        @foreach ($karyawan as $item)
                                            <option value="{{ $item->id_karyawan }}">{{ $item->name }} - Proyek Belum Ada</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Keterangan Tugas</label>
                                <textarea class="form-control" id="floatingTextarea" style="height: 100px" name="keterangan_tugas"></textarea>
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

        {{-- modal edit --}}
        @foreach ($tugas as $item)
            <div class="modal fade" id="modalEdit{{ $item->id_tugas }}" tabindex="-1" aria-labelledby="modalEditLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditLabel">
                                <i class="bi bi-patch-plus-fill"></i>
                                Edit Tugas
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('direktur.edit.tugas', $item->id_tugas) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input type="hidden" name="proyek_id" id="" value="{{ $id_proyek }}">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Tugas</label>
                                    <input type="text" class="form-control" id="recipient-name" name="nama_tugas"
                                        value="{{ $item->nama_tugas }}">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Deadline Tugas</label>
                                    <input type="date" class="form-control" id="recipient-name" name="deadline_tugas"
                                        value="{{ $item->deadline_tugas }}">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Berkas Tugas</label>
                                    <input type="file" class="form-control" id="recipient-name" name="berkas_tugas">
                                    <label for="recipient-name" class="col-form-label">Berkas tugas saat ini :
                                        <a href="{{ route('direktur.download.proyek', $item->berkas_tugas) }}"
                                            class="justify-content-center align-content-center">
                                            @if (in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                    srcset="" width="18px">
                                                {{ $item->berkas_tugas }}
                                            @endif
                                        </a>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Keterangan Tugas</label>
                                    <textarea class="form-control" id="floatingTextarea" style="height: 100px" name="keterangan_tugas">{{ $item->keterangan_tugas ?? 'Tidak ada keterangan' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Fase Proyek</label>
                                    <input type="text" class="form-control" id="recipient-name" name="fase_proyek"
                                        value="{{ $item->fase_proyek }}">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Rekomendasi Penanggung Jawab</label>
                                    <select name="karyawan_id" id="" class="form-select">
                                        @if ($tugas_all->isEmpty())
                                            @foreach ($karyawan as $item)
                                                <option value="{{ $item->id_karyawan }}">{{ $item->name }} - Proyek Belum Ada</option>
                                            @endforeach
                                        @else
                                            @php
                                            $alreadyDisplayed = []; @endphp
                                            @foreach ($tugas_all as $item)
                                                @php
                                                    $karyawanProyek = $item->karyawan->name . '-' . $item->proyek->level_proyek;
                                                @endphp
                                                @if (!in_array($karyawanProyek, $alreadyDisplayed))
                                                    @php $alreadyDisplayed[] = $karyawanProyek; @endphp
                                                    <option value="{{ $item->karyawan->id_karyawan }}">
                                                        {{ $item->karyawan->name }} - Proyek {{ $item->proyek->nama_proyek }} Level ({{ $item->proyek->level_proyek }})
                                                    </option>
                                                @endif
                                            @endforeach
                                            @foreach ($karyawan as $item)
                                                <option value="{{ $item->id_karyawan }}">{{ $item->name }} - Proyek Belum Ada</option>
                                            @endforeach
                                        @endif
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
        @endforeach
        {{-- modal edit --}}

        {{-- modal detail --}}
        @foreach ($tugas as $item)
            <div class="modal fade" id="modalDetail{{ $item->id_tugas }}" tabindex="-1"
                aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 me-5 me-5" id="modalDetailLabel">
                                <i class="bi bi-eye-fill"></i>
                                Detail Tugas
                            </h1>
                            @if ($item->status_tugas === 'Proses')
                                <span class="status-waiting">Sedang dikerjakan</span>
                            @elseif($item->status_tugas === 'Selesai')
                                <span class="status-done">Selesai</span>
                            @elseif ($item->status_tugas === 'Revisi')
                                <span class="status-reject">Sedang direvisi</span>
                            @elseif($item->status_tugas === 'Review')
                                <span class="status-review">Sedang direview</span>
                            @else
                                <span class="">Status bermasalah</span>
                            @endif
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Tugas</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_tugas"
                                    disabled value="{{ $item->nama_tugas }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Keterangan Tugas</label>
                                <textarea class="form-control" id="floatingTextarea" style="height: 100px" name="keterangan_tugas" disabled>{{ $item->keterangan_tugas ?? 'Tidak ada keterangan' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Fase Proyek</label>
                                <input type="text" class="form-control" id="recipient-name" name="fase_proyek"
                                    disabled value="{{ $item->fase_proyek }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Penanggung Jawab</label>
                                <input type="text" class="form-control" id="recipient-name" name="fase_proyek"
                                    disabled value="{{ $item->karyawan->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Berkas Tugas :
                                    <a href="{{ route('direktur.download.proyek', $item->berkas_tugas) }}"
                                        class="justify-content-center align-content-center">
                                        @if (in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                            <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                srcset="" width="18px">
                                            {{ $item->berkas_tugas }}
                                        @elseif(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION) == 'pdf')
                                            <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                srcset="" width="18px">
                                            {{ $item->berkas_tugas }}
                                        @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                            <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                srcset="" width="18px">
                                            {{ $item->berkas_tugas }}
                                        @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                            <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                srcset="" width="18px">
                                            {{ $item->berkas_tugas }}
                                        @elseif(in_array(pathinfo($item->berkas_tugas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                            <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                srcset="" width="18px">
                                            {{ $item->berkas_tugas }}
                                        @endif
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                onclick="konfirmasiHapus('{{ route('direktur.hapus.tugas', $item->id_tugas) }}')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- modal detail --}}

        {{-- modal progres tugas --}}
        @foreach ($tugas as $item)
            <div class="modal fade" id="modalTugas{{ $item->id_tugas }}" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" aria-labelledby="modalTugasLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 me-5 me-5" id="modalTugasLabel">
                                <i class="bi bi-folder-check"></i>
                                Progress Tugas Proyek
                            </h1>
                            <div>
                                @if ($item->status_tugas === 'Proses')
                                    <span class="status-waiting">Sedang dikerjakan</span>
                                @elseif($item->status_tugas === 'Selesai')
                                    <span class="status-done">Selesai</span>
                                @elseif ($item->status_tugas === 'Revisi')
                                    <span class="status-reject">Sedang direvisi</span>
                                @elseif($item->status_tugas === 'Review')
                                    <span class="status-review">Sedang direview</span>
                                @else
                                    <span class="">Status bermasalah</span>
                                @endif
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Tugas</label>
                                <input type="text" class="form-control" id="recipient-name" name="nama_tugas"
                                    disabled disabled value="{{ $item->nama_tugas }}">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Hasil Tugas :
                                    @if ($item->upload_berkas !== null)
                                        @if (in_array($item->status_tugas, ['Review', 'Done']))
                                            <a href="{{ route('direktur.download.tugas', $item->upload_berkas ?? 'Belum ditambahkan') }}"
                                                class="justify-content-center align-content-center">
                                                @if (in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['docx', 'doc']))
                                                    <img src="{{ asset('assets/image/icons/word.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(pathinfo($item->upload_berkas, PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('assets/image/icons/pdf.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']))
                                                    <img src="{{ asset('assets/image/icons/excel.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['zip', 'rar']))
                                                    <img src="{{ asset('assets/image/icons/zip.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @elseif(in_array(pathinfo($item->upload_berkas, PATHINFO_EXTENSION), ['jpeg', 'png']))
                                                    <img src="{{ asset('assets/image/icons/image.png') }}" alt=""
                                                        srcset="" width="18px">
                                                @endif
                                                {{ $item->upload_berkas }}
                                            </a>
                                        @else
                                            <form action="{{ route('direktur.proses.review.proyek', $item->id_tugas) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                File sudah ditambahkan
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="bi bi-folder-fill"></i>
                                                    Lihat Tugas
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        Belum ditambahkan
                                    @endif
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Catatan Karyawan</label>
                                <textarea class="form-control" id="floatingTextarea" style="height: 100px" name="catatan_karyawan" disabled>{{ $item->catatan_karyawan ?? 'Tidak ada catatan' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- modal progres tugas --}}


        {{-- modal selesai proyek --}}
        <div class="modal fade" id="modalProyek" aria-hidden="true" aria-labelledby="modalProyekLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalProyekLabel">Proses Lanjutan Selesai</h1>
                    </div>
                    <form action="{{ route('direktur.button.proyek.selesai', $id_proyek) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            Apakah anda yakin ingin menyelesaikan tugas?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Yakin</button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"
                                aria-label="Close">Tidak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- modal selesai proyek --}}

        {{-- modal selesai tugas --}}
        @foreach ($tugas as $item)
            <div class="modal fade" id="selesaiModal{{ $item->id_tugas }}" aria-hidden="true"
                aria-labelledby="selesaiModalLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="selesaiModalLabel">Memberi Status Selesai</h1>
                        </div>
                        <form action="{{ route('direktur.tugas.selesai', $item->id_tugas) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                Apakah anda yakin ingin menyelesaikan tugas?
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Yakin</button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"
                                    aria-label="Close">Tidak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- modal selesai tugas --}}

        {{-- modal belum selesai tugas --}}
        @foreach ($tugas as $item)
            <div class="modal fade" id="belumSelesaiModal{{ $item->id_tugas }}" aria-hidden="true"
                aria-labelledby="belumSelesaiModalLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="belumSelesaiModalLabel">Catatan Revisi</h1>
                        </div>
                        <form action="{{ route('direktur.tugas.belum.selesai', $item->id_tugas) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                Apakah anda yakin tugas belum selesai?
                                <div class="form-group mt-4">
                                    <label for="catatan">Catatan</label>
                                    <textarea class="form-control" placeholder="Masukan catatan (jika ada)" id="floatingTextarea" name="catatan_revisi"
                                        style="height: 200px"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Yakin</button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"
                                    aria-label="Close">Tidak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- modal belum selesai --}}

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
                        window.location = deleteUrl;
                    }
                });
            }
        </script>
    @endsection
