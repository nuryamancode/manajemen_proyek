<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email salah, berikan tanda @',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->email_verified_at === null) {
                switch ($user->role) {
                    case 'Human Resource':
                        return redirect('/hr');
                    case 'Direktur':
                        return redirect('/direktur');
                    default:
                        Auth::logout();
                        alert()->toast('Email harus terverifikasi', 'error');
                        return redirect('/login')->with('error', 'Email harus sudah terverifikasi ');
                }
            } else {
                if ($user->role == 'Karyawan') {
                    return redirect('/karyawann');
                } else {
                    Auth::logout();
                    alert()->toast('Email harus terverifikasi', 'error');
                    return redirect('/login')->with('error', 'Email harus sudah terverifikasi ');
                }
            }
        } else {
            return redirect()->back()->withErrors('Email dan Password tidak sesuai')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    function home()
    {
        return view('auth.home');
    }

    function register()
    {
        return view('auth.register');
    }
    function proses_register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'name' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'name.required' => 'Nama wajib diisi',
            'email.email' => 'Format email salah, berikan tanda @',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 ch',
        ]);

        $userexs = User::where('email', $request->input('email'))->first();
        if ($userexs) {
            Alert::toast('Email sudah terdaftar', 'error');
            return redirect()->back();
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        if ($user) {
            if (!empty($name)) {
                $karyawan = Karyawan::create([
                    'name' => $name,
                    'user_id' => $user->id,
                ]);

                if ($karyawan) {
                    event(new Registered($user));
                    Alert::toast('Registrasi Berhasil Silahkan Verifikasi Email', 'success');
                    if (Auth::login($user)) {
                        return redirect('/login')->with('success', 'Email sudah terverifikasi');
                    }

                    return redirect('/email/verify');
                } else {
                    $user->delete();
                    Alert::toast('Registrasi Gagal', 'error');
                    return redirect()->back();
                }
            } else {
                $user->delete();
                Alert::toast('Nama wajib diisi', 'error');
                return redirect()->back();
            }
        } else {
            Alert::toast('Registrasi Gagal', 'error');
            return redirect()->back();
        }
    }
}
