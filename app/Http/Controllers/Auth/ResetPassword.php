<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPassword extends Controller
{
    function index($token)
    {
        return view('auth.reset_password', ['token'=>$token]);
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ],[
            'token.required'=>'Token wajib diisi',
            'email.reqiuired'=>'Email wajib diisi',
            'password.required'=>'Password wajib diisi',
            'password.min'=>'Password minimal 8 character',
            'password.confirmed'=>'Password harus sama'
        ]);

        $status = Password::reset(
            $request->only('email','password', 'password_confirmation','token'),
            function(User $user, string $password){
                $user->forceFill([
                    'password'=> Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Reset password berhasil')
        : back()->with('error', 'Terjadi kesalahan!');
    }
}
