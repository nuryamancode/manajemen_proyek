@extends('direktur.layouts.base-direktur', ['title' => 'Kuisioner Karyawan'])

@section('content-direktur')
    <div class="container-fluid">
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
                <h2 class="title-name">Penilaian Karyawan</h2>
            </div>
            <div class="card-body">
                @if ($subkriteria === null)
                    <div class="text-center">
                        <h1 class="main-title">Data Kosong</h1>
                    </div>
                @else
                    <form action="{{ route('direktur.hitung.kuisioner') }}" method="post">
                        @csrf
                        <input type="hidden" name="tugas_id" value="{{ $tugas_id }}">
                        <div id="penilaian">
                            @foreach ($sub as $item)
                                @if (!$loop->first && $item->kriteria->nama_kriteria !== $sub[$loop->index - 1]->kriteria->nama_kriteria)
                        </div>
                @endif

                @if ($loop->first || $item->kriteria->nama_kriteria !== $sub[$loop->index - 1]->kriteria->nama_kriteria)
                    <div class="card-header">
                        <h3 class="font-bold">{{ $item->kriteria->nama_kriteria }}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                @endif

                <div class="row">
                    <div class="" style="width: 66%">


                        <li class="list-group-item">{{ $item->nama_subkriteria }}</li>
                    </div>
                    <div class="" style="width: 34%">
                        <li class="list-group-item text-end">
                            {{-- <input type="number" name="subkriteria_id[]" value="{{ $item->id_subkriteria }}"> --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{ $item->id_subkriteria }}]"
                                    id="1_{{ $item->id_subkriteria }}" value="1">
                                <label class="form-check-label" for="1_{{ $item->id_subkriteria }}">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{ $item->id_subkriteria }}]"
                                    id="2_{{ $item->id_subkriteria }}" value="2">
                                <label class="form-check-label" for="2_{{ $item->id_subkriteria }}">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{ $item->id_subkriteria }}]"
                                    id="3_{{ $item->id_subkriteria }}" value="3">
                                <label class="form-check-label" for="3_{{ $item->id_subkriteria }}">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{ $item->id_subkriteria }}]"
                                    id="4_{{ $item->id_subkriteria }}" value="4">
                                <label class="form-check-label" for="4_{{ $item->id_subkriteria }}">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{ $item->id_subkriteria }}]"
                                    id="5_{{ $item->id_subkriteria }}" value="5">
                                <label class="form-check-label" for="5_{{ $item->id_subkriteria }}">5</label>
                            </div>
                        </li>
                    </div>
                </div>

                @if ($loop->last)
                    </ul>
            </div>
            @endif
            @endforeach
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">Kirim</button>
        </div>
        </form>
        @endif
    </div>
    </div>
    </div>
@endsection

@section('direktur-js')
    <script></script>
@endsection
