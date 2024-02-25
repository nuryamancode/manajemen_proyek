@extends('karyawan.layouts.base_karyawan', ['title'=>'Edit Profil'])


@section('content')
    <style>

        .user-avatar img {
            width: 200px;
            height: 200px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #435ebe;
        }


        .form-control {
            border: 1px solid #cfd1d8;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }
    </style>


    <div class="container mt-3">
        @if ($karyawan === null || $karyawan->alamat === null)
            <div class="alert alert-danger">
                <p>
                    Harap melengkapi profil anda
                </p>

            </div>
        @endif
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ url('/karyawann/profil') }}" method="POST" enctype="multipart/form-data">
                            @if (isset($karyawan))
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">Personal Details</h6>
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
                                </div>
                                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="user-avatar">
                                        @if ($karyawan === null || $karyawan->photo_profile === null)
                                            <img id="previewImage" src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                                alt="User Profile">
                                        @else
                                            <img id="previewImage" src="{{ asset('storage/photo_user/' . $karyawan->photo_profile) }}"
                                                alt="User Profile">
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-start mt-3 mb-4">
                                        <div class="btn btn-primary btn-rounded">
                                            <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                                            <input type="file" class="form-control d-none" id="customFile1"
                                                name="photo_profile" onchange="previewFile()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="fullName">Nama Lengkap </label>
                                        <input type="text" class="form-control" id="fullName"
                                            placeholder="Masukan nama lengkap" name="name"
                                            value="{{ old('name', $karyawan->name ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="alamat">Alamat Lengkap</label>
                                        <textarea class="form-control" placeholder="Masukan alamat" id="floatingTextarea" name="alamat"style="height: 100px">{{ old('alamat', $karyawan->alamat ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="phone">Nomor Handphone </label>
                                        <input type="text" class="form-control" id="phone"
                                            placeholder="Masukan nomor handphone" name="no_handphone"
                                            value="{{ $karyawan->no_handphone ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function previewFile() {
            var input = document.getElementById('customFile1');
            var preview = document.getElementById('previewImage');

            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>

@endsection
