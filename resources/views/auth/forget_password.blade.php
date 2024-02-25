@extends('auth.layouts.app_auth', ['title' => 'Lupa Password'])

@section('contents_auth')
    <div class="text border-container">
        <h2 class="judul3" style="margin-top: 50px">Lupa Password</h2>
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
        <form class="login-form" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email">
            </div>
            <button class="neon-button login-button mt-3 mb-3" type="submit">Send Email</button>
        </form>
    </div>
@endsection
