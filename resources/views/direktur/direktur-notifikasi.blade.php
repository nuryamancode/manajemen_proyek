@extends('direktur.layouts.base-direktur', ['title' => 'Notifikasi'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card" style="width: 100%;">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h6>Notifikasi</h6>
                    </div>
                    <div class="col text-end">
                        @if (!$notifikasi1->isEmpty())
                        <form action="{{ route('direktur.hapus.notifikasi') }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Hapus Semua</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                @if ($notifikasi1->isEmpty())
                    <li class="list-group-item">
                        <div class="text-center">
                            <h6>Tidak ada notifikasi</h6>
                        </div>
                    </li>
                @else
                    @foreach ($notifikasi1 as $item)
                       <a href="{{ route('direktur.baca.notifikasi', $item->id_notifikasi) }}">
                        <li class="list-group-item">
                            <h4>{{ $item->judul }}
                                @if (!$item->dibaca)
                                    <span class="badge bg-danger">Belum Dibaca</span>
                                @endif
                            </h4>
                            <p>
                                {{ $item->pesan }}
                            </p>
                            <small>{{ $item->created_at->locale('id')->diffForHumans() }}</small>
                        </li>
                       </a>
                    @endforeach
                @endif
            </ul>
        </div>


    @endsection
