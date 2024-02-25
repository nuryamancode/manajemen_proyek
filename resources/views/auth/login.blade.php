@extends('auth.layouts.app_auth', ['title'=>'Login'])

@section('contents_auth')
    <div class="text border-container">
        <h2 class="judul3" style="margin-top: 50px">Login</h2>
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
            <div class="alert alert-success mt-2 text-start" style="margin-left: 45px; margin-right: 45px">
                {{ session('success') }}
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
            </div>
        @endif
        <!-- Form Login -->
        <form class="login-form" action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <button class="neon-button login-button mt-3 mb-3" type="submit">Login</button>
            <p class="text-center">Belum punya akun? <a class="text-center" href="{{ route('register') }}"
                    style="text-decoration: none">Registrasi</a>
            </p>
            <p class="text-center">Lupa Password? <a class="text-center" href="{{ route('password.request') }}"
                    style="text-decoration: none">Reset Password</a>
            </p>
        </form>
    </div>
@endsection
