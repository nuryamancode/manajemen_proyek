@extends('karyawan.layouts.base_karyawan', ['title' => 'Daftar Tugas'])

@section('content')
    <div class="container">
        <div class="page-content">
            <div class="card mt-3">
                <div class="card-header">
                    <h2 class="page-heading">Tabel Daftar Tugas</h2>
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
                    </div>
                    <table id="tugasdaftar" class="table table-responsive table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead class="bg-dark text-white table-hover">
                            <tr class="text-center text-nowrap ">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Proyek</th>
                                <th class="text-center">Nama Tugas</th>
                                <th class="text-center">Keterangan Tugas</th>
                                <th class="text-center">Deadline Tugas</th>
                                <th class="text-center">Divisi</th>
                                <th class="text-center">Status Tugas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas as $item)
                                <tr class="text-center text-nowrap">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->proyek->nama_proyek ?? 'Tidak ada' }}</td>
                                    <td>{{ $item->nama_tugas }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->keterangan_tugas, 10) ?? 'Tidak ada keterangan' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->deadline_tugas)->locale('id_ID')->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ $item->karyawan->bidang->nama_bidang ?? 'Belum ditambahkan' }}</td>
                                    <td>
                                        @if ($item->status_tugas === 'Proses')
                                            <span class="status-waiting">{{$item->status_tugas  }}</span>
                                        @elseif($item->status_tugas === 'Selesai')
                                            <span class="status-done">{{ $item->status_tugas }}</span>
                                        @elseif ($item->status_tugas === 'Revisi')
                                            <span class="status-reject">{{ $item->status_tugas }}</span>
                                        @elseif($item->status_tugas === 'Review')
                                            <span class="status-review">{{ $item->status_tugas }}</span>
                                        @else
                                            <span class="">Status bermasalah</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('karyawan.detail.daftartugas', $item->id_tugas) }}"
                                            class="btn btn-primary">
                                            <i data-feather="eye" class="feather-icon "></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
