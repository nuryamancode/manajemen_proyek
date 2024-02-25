<?php

namespace App\Http\Controllers\Auth\RegisterAccountHD;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\HR;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register_hr');
    }
    public function index2()
    {
        return view('auth.register_direktur');
    }

    public function register(Request $request)
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
            'password.min' => 'Password minimal 8 character',
        ]);


        $userexs = User::where('email', $request->input('email'))->first();
        if ($userexs) {
            Alert::toast('Email sudah terdaftar', 'error');
            return redirect()->back();
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role');
        $name = $request->input('name');

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        if ($user) {
            if ($role == 'Human Resource') {
                HR::create([
                    'name' => $name,
                    'user_id' => $user->id
                ]);
            } elseif ($role == 'Direktur') {
                Direktur::create([
                    'name' => $name,
                    'user_id' => $user->id
                ]);
            }
            return redirect('/login')->with('success', 'Silahkan Login');
        } else {
            Alert::toast('Registrasi Gagal', 'error');
            return redirect()->back();
        }
    }
}
