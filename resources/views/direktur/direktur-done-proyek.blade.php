@extends('direktur.layouts.base-direktur', ['title' => 'Proyek Selesai'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Tabel Proyek Selesai</h2>
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
                <table id="done" class="table table-responsive table-striped table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="text-center text-nowrap align-middle table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Proyek</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Nama Klien</th>
                            <th class="text-center">Email Klien</th>
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
                                <td>

                                    @if ($item->status_proyek === 'Done')
                                        <span class="status-waiting">Selesai</span>
                                    @else
                                        <span class="status-reject">Status bermasalah</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('direktur.tugas', $item->id_proyek) }}"
                                        class="btn btn-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('direktur-js')
    <script>
        new DataTable('#done', {
            fixedColumns: {
                left: 0,
                right: 1
            },
            scrollX: true,
            scrollXInner: "100%",
            autoWidth: false,

        });

    </script>
@endsection
