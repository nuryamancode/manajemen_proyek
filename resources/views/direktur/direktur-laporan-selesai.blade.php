@extends('direktur.layouts.base-direktur', ['title' => 'Laporan Proyek Selesai'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Laporan Proyek Selesai</h2>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mt-2 text-start" style="margin-left: 45px; margin-right: 45px">
                        {{ session('success') }}
                    </div>
                @endif
                <table id="proyekselesai" class="table table-responsive table-striped table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr class="text-center text-nowrap align-middle table-dark">
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Proyek</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Nama Klien</th>
                            <th class="text-center">Email Klien</th>
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
        $(document).ready(function() {
            var table = $('#proyekselesai').DataTable({
                buttons: [
                    'excel',

                    {
                        extend: 'print',
                        customize: function(win) {
                            var letterhead =
                                '<div style="display: flex; align-items: center; margin-bottom: 20px;">' +
                                '<div style="flex: 1; text-align: left;">' +
                                '<img src="{{ asset('assets/image/mareca.png') }}" style="max-width: 100px;" />' +
                                '</div>' +
                                '<div style="flex: 2; text-align: right;">' +
                                '<h2>CV Mareca Yasa Media</h2>' +
                                '<p>Perumahan Cempaka Arum B5 No. 14, Rancanumpang,<br>Gedebage, Kota Bandung</p>' +
                                '<p style="margin-bottom: 0;"><span style="text-decoration: underline; color: blue;">Phone: +62 813-2032-4274</span></p>' +
                                '</div>' +
                                '</div>' +
                                '<hr style="border: 1px solid blue; margin: 0;">';

                            $(win.document.body).prepend(letterhead);
                            $(win.document.body).find('h1').css({
                                'text-align': 'center',
                                'font-size': '20px'
                            });

                            $(win.document.body).find('table').css('font-size', '10pt');
                            $(win.document.body).find('thead').css({
                                'border': '1px solid black'
                            });

                            $(win.document.body).find('tbody').css({
                                'border': '1px solid black'
                            });

                            $(win.document.body).find('thead th').css({
                                'border': '1px solid black'
                            });

                            $(win.document.body).find('tbody td').css({
                                'border': '1px solid black'
                            });
                        }
                    }
                ],
                dom: 'Bfrtip',
                fixedColumns: {
                    left: 0,
                    right: 1
                },
                scrollX: true,
                scrollXInner: "100%",
                autoWidth: false,
                "bPaginate": true, // Enable pagination
                "bLengthChange": true, // Show number of entries per page dropdown
                "bFilter": true, // Enable search
                "bInfo": true, // Show information (e.g., "Showing 1 to 10 of 50 entries")
                "bAutoWidth": false, // Disable automatic column width calculation
                "border": true,
            });
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
