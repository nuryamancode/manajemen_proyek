<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HRController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $data = [

            'role' => $role,
            'hr' => $hr,
        ];
        return view('hr.hr-dashboard', $data);
    }

    function profil_hr()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $password = Auth::user()->password;
        $data = [

            'role' => $role,
            'password' => $password,
            'hr' => $hr,
        ];
        return view('hr.hr-profil', $data);
    }

    public function ganti_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            alert()->toast('Password tidak sesuai', 'error');
            return back();
        }

        User::whereId(auth()->user()->id)->update([
            'password' => bcrypt($request->new_password),
        ]);
        alert()->toast('Password berhasil diperbarui', 'success');
        return back()->with('Password berhasil diperbarui');
    }
    function edit_profil_hr()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $data = [
            'role' => $role,
            'hr' => $hr,
        ];
        return view('hr.hr-editprofil', $data);
    }

    // function save_profil_hr(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'alamat' => 'required|string',
    //         'no_handphone' => 'required',
    //     ], [
    //         'name.required' => 'Nama Lengkap wajib diisi',
    //         'alamat.required' => 'Alamat wajib diisi',
    //         'no_handphone.required' => 'Nomor Handphone wajib diisi',
    //         'name.string' => 'Nama harus berupa huruf',
    //         'alamat.string' => 'Alamat harus berupa huruf',
    //     ]);

    //     $user_id = auth()->id();
    //     $data = new HR([
    //         'name' => $request->name,
    //         'alamat' => $request->alamat,
    //         'no_handphone' => $request->no_handphone,
    //         'user_id' => $user_id,
    //     ]);
    //     if ($data->save()) {
    //         Alert::toast('Profil berhasil diperbarui', 'success');
    //         return redirect('/hr/profil');
    //     } else {
    //         Alert::toast('Profil mengalami kesalahan check terlebih dahulu', 'error');
    //     }
    // }

    function update_profil_hr(Request $request)
    {
        $user_id = auth()->id();

        $request->validate([
            'name' => 'required|string',
            'photo_profile' => 'image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required',
            'no_handphone' => 'required'
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'no_handphone.required' => 'Nomor Handphone wajib diisi',
            'name.string' => 'Nama harus berupa huruf',
            'photo_profile.image' => 'File harus berupa gambar',
            'photo_profile.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg',
            'photo_profile.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
        ]);

        $hr = HR::where('user_id', $user_id)->first();

        $hr->name = $request->input('name');
        $hr->alamat = $request->input('alamat');
        $hr->no_handphone = $request->input('no_handphone');
        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $fotoName = $file->getClientOriginalExtension();
            $file->move('photo_user', $fotoName);
            $hr->photo_profile = $fotoName;
        }

        if ($hr->save()) {
            alert()->toast('Profil berhasil diperbarui', 'success');
            return redirect('/hr/profil');
        }
    }


}
