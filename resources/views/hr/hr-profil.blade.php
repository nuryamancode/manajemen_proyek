@extends('hr.layouts.base-hr', ['title' => 'Profilku'])

@section('content-hr')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="img-profil">
                                    @if ($hr === null || $hr->photo_profile === null)
                                        <img src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                            alt="User Profile" width="200px" height="200px">
                                    @else
                                        <img src="{{ asset('photo_user/' . $hr->photo_profile) }}"
                                            alt="User Profile" width="200px" height="200px">
                                    @endif
                                </div>
                            </div>
                            <div class="col-7">
                                @if ($hr === null || $hr->user_id === null)
                                    <h2 class="title-name">Nama Tidak Diketahui</h2>
                                    <h6 class="title-sub">Email Tidak Ditemukan</h6>
                                @else
                                    <h2 class="title-name">{{ $hr->name }}</h2>
                                    <h6 class="">{{ auth()->user()->email }}</h6>
                                    <h5 class="">{{ $role }}</h5>
                                    <div class="status" style="margin-top: 60px">
                                        <p class="btn btn-success disabled">
                                            Status Aktif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="title-sub">Akun Saya</h6>
                        <div class="mb-4">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                value="{{ auth()->user()->password }}" disabled>
                        </div>
                        <a href="#" class="btn btn-primary mt-1" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">Ganti Password</a>
                    </div>
                </div>
            </div>
        </div>
        @if ($hr === null || $hr->alamat === null)
            <div class="alert alert-danger mb-3 mt-3">
                Harap melengkapi profil anda
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <h2 clas s="title-name mb-3">Detail Profil</h2>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('hr.edit.profilku') }}" class="btn btn-warning text-end">Ubah Profil</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat Lengkap</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                value="{{ $hr->alamat ?? 'Tidak Diketahui' }}" disabled>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">No Handphone</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div> --}}
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">No Handphone</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                value="{{ $hr->no_handphone ?? 'Tidak Diketahui' }}" disabled>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ganti Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hr.gantipassword') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="old_password" class="form-label">{{ __('Password Lama') }}</label>
                            <input id="old_password" type="password"
                                class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                                autocomplete="off">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label">{{ __('Password Baru') }}</label>
                            <input id="new_password" type="password"
                                class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                autocomplete="off">
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input id="new_password_confirmation" type="password"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                name="new_password_confirmation" autocomplete="off">
                            @error('new_password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
