@extends('direktur.layouts.base-direktur', ['title' => 'Detail Tugas'])

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
        <span class="mb-3"><a href="javascript:history.back()" class="btn-primary">
                <i class="bi bi-caret-left-fill"></i>
                Kembali</a></span>
        <div class="card mt-3">
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h2 class="main-title">Detail Tugas Karyawan</h2>
                            </div>
                            <div class="col text-end">
                                <a href="#" class="btn btn-danger" data-confirm-delete="true"
                                    onclick="konfirmasiHapus('{{ route('direktur.tugas', $tugas->id_tugas) }}')">
                                    <i class="bi bi-trash-fill"></i>
                                    Hapus Tugas
                                </a>
                                @if (in_array($tugas->proyek->status, ['Waiting', 'Review', 'Reject']))
                                    <a href="#" class="btn btn-success"
                                        data-bs-target="#modalEdit{{ $tugas->id_tugas }}" data-bs-toggle="modal">
                                        <i class="bi bi-pen-fill"></i>
                                        Ubah Tugas
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                </div>

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
                        window.location = deleteUrl;
                    }
                });
            }
        </script>
    @endsection
