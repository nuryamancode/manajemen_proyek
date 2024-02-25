@extends('direktur.layouts.base-direktur', ['title' => 'Penilaian Karyawan'])

@section('content-direktur')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="title-name">Penilaian Karyawan</h2>
            </div>
            <div class="card-body">
                <div id="periode">
                    <form action="{{route('direktur.add.periode')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="datetime-local" class="form-control" name="tanggal" id="tanggal">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="tahun" id="tahun">
                                        <span class="input-group-text">Tahun</span>
                                        <style>
                                            #tahun::-webkit-inner-spin-button,
                                            #tahun::-webkit-outer-spin-button {
                                                -webkit-appearance: none;
                                                margin: 0;
                                            }

                                            #tahun {
                                                -moz-appearance: textfield;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mb-4">
                            <button class="btn btn-primary" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('direktur-js')
    <script></script>
@endsection
