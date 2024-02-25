@extends('auth.layouts.app_auth', ['title' => 'Reset Password'])

@section('contents_auth')
    <div class="text border-container">
        <h2 class="judul3" style="margin-top: 50px">Reset Password</h2>
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
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-2 text-start" style="margin-left: 45px; margin-right: 45px">
                {{ session('error') }}
            </div>
        @endif
        <!-- Form Login -->
        <form class="login-form" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <div class="form-group">
                <label for="password">Konfirmasi Password Baru</label>
                <input type="password" id="password" name="password_confirmation" placeholder="Masukkan Password">
            </div>
            <button class="neon-button login-button mt-3 mb-3" type="submit">Reset Password</button>
        </form>
    </div>
@endsection
