@component('mail::message')
    {{-- Subject --}}
    @slot('subject')
        Verifikasi Email Anda
    @endslot

    {{-- Body --}}
    @slot('body')
        <p>
            Silakan klik tautan berikut untuk memverifikasi email Anda:
        </p>
        @component('mail::button', ['url' => $url])
            {{ url('auth/verify', $url) }}
        @endcomponent
    @endslot
@endcomponent
