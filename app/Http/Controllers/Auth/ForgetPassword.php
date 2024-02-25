<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgetPassword extends Controller
{
    public function index()
    {
        return view('auth.forget_password');
    }

    public function forget_password_send(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email harus berupa @'
            ]
        );

        $status = Password::sendResetLink(
            $request->only('email'),
        );

        return $status === Password::RESET_LINK_SENT ?
            back()->with('success', 'Reset password berhasil terkirim ke email') :
            back()->with('error', 'Terjadi kesalahan!');
    }
}
