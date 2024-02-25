<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\HR;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Auth\Events\Registered;


class ManageUserController extends Controller
{
    function manage_user()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $user = User::whereIn('role', ['Direktur', 'Karyawan'])->get();
        $role = Auth::user()->role;
        $direktur = Direktur::where('user_id')->get();
        $karyawan = Karyawan::where('user_id')->get();
        $data = [
            'role' => $role,
            'user' => $user,
            'hr' => $hr,
            'direktur' => $direktur,
            'karyawan' => $karyawan,
        ];
        return view('hr.hr-manageuser', $data);
    }

    function save_data_user(Request $request)
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
            } elseif ($role == 'Karyawan') {
                $karyawan = Karyawan::create([
                    'name' => $name,
                    'user_id' => $user->id
                ]);
                if ($karyawan) {
                    event(new Registered($user));
                    Alert::toast('Registrasi Berhasil Silahkan Verifikasi Email', 'success');
                    Auth::login($user);
                    return redirect()->back()->with('success', 'Email sudah terverifikasi');
                } else {
                    $user->delete();
                    Alert::toast('Registrasi Gagal', 'error');
                    return redirect()->back();
                }
            }
            alert()->toast('Berhasil menambahkan data', 'success');
            return redirect()->back();
        } else {
            Alert::toast('Registrasi Gagal', 'error');
            return redirect()->back();
        }
    }

    function update_data_user(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'email.email' => 'Email harus ada "@"',
            'password.min' => 'Password harus minimal 8 character',
        ]);
        $user = User::find($id);
        $name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $create = $user->save();
        if ($create) {
            if ($user->role == 'Human Resource') {
                $hr = HR::where('user_id', $user->id)->first();
                if ($hr) {
                    $hr->update(['name' => $name]);
                } else {
                    HR::create(['user_id' => $user->id, 'name' => $name]);
                }
            } elseif ($user->role == 'Direktur') {
                $direktur = Direktur::where('user_id', $user->id)->first();
                if ($direktur) {
                    $direktur->update(['name' => $name]);
                } else {
                    Direktur::create(['user_id' => $user->id, 'name' => $name]);
                }
            } elseif ($user->role == 'Karyawan') {
                $karyawan = Karyawan::where('user_id', $user->id)->first();
                if ($karyawan) {
                    $karyawan->update(['name' => $name]);
                } else {
                    Karyawan::create(['user_id' => $user->id, 'name' => $name]);
                }
            }
            alert()->toast('Data berhasil diperbarui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Data tidak berhasil diperbarui', 'error');
            return redirect()->back();
        }
    }

    function delete_data_user(User $user)
    {
        alert()->toast('Data berhasil dihapus', 'success');
        $user->delete();
        return redirect()->back();
    }
}
