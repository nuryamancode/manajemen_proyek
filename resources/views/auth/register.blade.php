@extends('auth.layouts.app_auth', ['title' => 'Registrasi'])

@section('contents_auth')
    <div class="text border-container">
        <h2 class="judul3" style="margin-top: 50px">Register</h2>
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
        <!-- Form Login -->
        <form class="login-form" action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan Nama Lengkap">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <button class="neon-button login-button mt-3 mb-3" type="submit">Register</button>
        </form>
    </div>

@endsection
