@extends('auth.layouts.registerHD.app_register', ['title' => 'Register Akun Secret'])

@section('content_register')
    <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        Selamat Menikmati <br />
                        <span class="text-primary">Kemudahan dalam pengolaan data</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">
                            <h3 class="text-center text-uppercase mb-2">Registrasi Account</h3>
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
                                <div class="alert alert-success mt-2" style="margin-left: 45px; margin-right: 45px">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close">x</button>
                                </div>
                            @endif
                            <form action="{{ route('register.send') }}" method="POST">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1">Nama Lengkap</label>
                                    <input type="name" id="form3Example1" name="name" class="form-control" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example2">Email</label>
                                    <input type="email" id="form3Example2" name="email" class="form-control" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Password</label>
                                    <input type="password" id="form3Example3" name="password" class="form-control" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1">Peran</label>
                                    <select class="form-select" name="role" aria-label="Default select example">
                                        <option value="Human Resource">Human Resource</option>
                                        <option value="Direktur">Direktur</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block mb-4">
                                        Registrasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
