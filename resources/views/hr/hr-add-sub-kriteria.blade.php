@extends('hr.layouts.base-hr', ['title' => 'Tambah Sub Kriteria'])

@section('content-hr')
    <div class="container-fluid">
        <span class="mb-4 mt-4"><a href="{{ route('hr.sub.kriteria') }}" class="btn-primary">
                <i class="bi bi-caret-left-fill"></i>
                Kembali</a></span>
        <div class="card mt-2">
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h2 class="title-name"><i class="bi bi-info-circle"></i> Informasi !!</h2>
                    </div>
                    <div class="card-body bg-success">
                        <p class="p-3 text-white">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repellendus officiis
                            nulla dignissimos mollitia neque? Id blanditiis ullam facere exercitationem numquam deleniti
                            delectus, consectetur sunt velit, corrupti est dolores maxime.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="title-name">Tambah Data</h2>
                    <div class="text-start">
                        <a href="#" class="btn btn-warning mt-2 mb-2" id="addInput"><i
                                class="bi bi-plus-circle-dotted"></i> Tambah Penginputan</a>
                    </div>
                    <form action="{{ route('hr.add.sub.kriteria') }}" method="post">
                        @csrf
                        <div id="inputContainer" class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="kriteria_id" class="form-label">Kriteria</label>
                                    <select name="kriteria_id" class="form-select">
                                        @if (count($kriteria) > 0)
                                            @foreach ($kriteria as $item)
                                                <option value="{{ $item->id_kriteria }}">{{ $item->nama_kriteria }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled selected>Data belum ada</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_sub" class="form-label">Sub Kriteria</label>
                                    <textarea class="form-control" placeholder="" id="floatingTextarea" name="nama_sub" style="height: 80px"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Bobot Sub Kriteria</label>
                                    <input type="number" class="form-control" name="bobot" max="50" id="bobot">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('hr-js')
    <script>
        $(document).ready(function() {
            var inputCount = 1;
            $("#addInput").click(function(event) {
                event.preventDefault();
                var newInput = $("#inputContainer").clone();

                newInput.find('select').attr('name', 'kriteria_id[' + inputCount + ']');
                newInput.find('textarea').attr('name', 'nama_sub[' + inputCount + ']');

                newInput.find('select').val('');
                newInput.find('textarea').val('');

                $("#inputContainer").after(newInput);
                inputCount++;
                $('html, body').animate({
                    scrollTop: newInput.offset().top
                }, 100);
            });
        });
    </script>
@endsection
