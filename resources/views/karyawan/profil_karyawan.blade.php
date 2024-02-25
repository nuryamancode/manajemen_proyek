@extends('karyawan.layouts.base_karyawan', ['title'=>'Profil'])


@section('content')
    <style>

        .account-settings .user-profile {
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            text-align: center;
        }

        .account-settings .user-profile .user-avatar {
            margin: 0 0 1rem 0;
        }

        .account-settings .user-profile .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .account-settings .user-profile h5.user-name {
            margin: 0 0 0.5rem 0;
        }

        .account-settings .user-profile h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .account-settings .about {
            margin: 2rem 0 0 0;
            text-align: center;
        }

        .account-settings .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }

        .account-settings .about p {
            font-size: 0.825rem;
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
            <div class="col-xl-5 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    @if ($karyawan === null || $karyawan->photo_profile === null)
                                        <img src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                            alt="User Profile">
                                    @else
                                        <img src="{{ asset('photo_user/' . $karyawan->photo_profile) }}"
                                            alt="User Profile">
                                    @endif
                                </div>
                                <h5 class="user-name text-primary">
                                    @if ($karyawan === null || $karyawan->user_id === null)
                                        Nama Tidak Diketahui
                                    @else
                                        {{ $karyawan->name }}
                                    @endif
                                </h5>
                                <h5 class="btn btn-danger disabled">
                                    {{ $karyawan->bidang->nama_bidang ?? 'Belum ada bidang' }}
                                </h5>
                                <h6 class="user-email text-primary">
                                    {{ Auth::user()->email }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <a href="{{ route('karyawan.edit.profil') }}" class="btn btn-primary">
                            <i class="bi bi-pen-fill"></i>
                            Ubah
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap </label>
                                    <textarea disabled class="form-control" placeholder="" id="floatingTextarea"
                                        name="alamat"style="height: 100px">{{ $karyawan->alamat ?? 'Alamat Tidak Diketahui'}}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Nomor Handphone </label>
                                    <input type="text" class="form-control" id="phone"
                                        placeholder="" name="no_handphone"
                                        value="{{ $karyawan->no_handphone ?? 'Nomor Handphone Tidak Diketahui' }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
