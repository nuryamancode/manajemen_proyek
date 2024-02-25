@extends('auth.layouts.app_auth', ['title' => 'Email Verifikasi'])

@section('contents_auth')
    <div class="text border-container">
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
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
        @endif
        <div class="">
            <div class="card-body" style="margin-left: 20px; margin-right: 20px; margin-top: 150px">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center text-uppercase">Peringatan!</h4>
                        <p class="text-start mb-3">
                            Silahkan untuk membuka gmail dan melakukan verifikasi agar dapat masuk dengan akun yang
                            sudah di daftarkan sebelumnya, dan jika tidak mendapatkan email silahkan untuk mengirim ulang email
                        </p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4 mx-4 mb-3 mb-lg-4">
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Resend Email
                        </button>
                    </form>
                </div>
                <div class="text-center">
<<<<<<< HEAD
                    <a href="{{ url('/home') }}" style="text-decoration: none;">Kembali</a>
=======
                    <a href="{{ route('logout') }}" style="text-decoration: none;">Kembali</a>
>>>>>>> 712c05ef5196bc95eedc5fc7ff54baad76789018
                </div>
            </div>
        </div>
    </div>
@endsection
