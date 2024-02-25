<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Karyawan;
use App\Models\Kecamatan;
use App\Models\Notifikasi;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    function index() {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'karyawan' => $karyawan,
            'notifikasi'=> $notifikasi,
            'jumlah'=> $jumlah
        ];

        return view('karyawan.karyawan-dashboard', $data);
    }
    function profil_karyawan() {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id',$user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'karyawan' => $karyawan,
            'notifikasi'=> $notifikasi,
            'jumlah'=> $jumlah
        ];
        return view('karyawan.profil_karyawan', $data, compact('karyawan'));
    }
    function edit_profil_karyawan() {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'karyawan' => $karyawan,
            'notifikasi'=> $notifikasi,
            'jumlah'=> $jumlah
        ];
        return view('karyawan.edit_profil_karyawan', $data, compact('karyawan'));
    }

    function save_profil_karyawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.string' => 'Nama harus berupa huruf',
        ]);

        $user_id = auth()->id();
        $data = new Karyawan([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_handphone' => $request->no_handphone,
            'user_id' => $user_id,
        ]);
        if ($data->save()) {
            Alert::toast('Profil berhasil diperbarui', 'success');
            return redirect('/karyawann/profil');
        } else {
            Alert::toast('Profil mengalami kesalahan check terlebih dahulu', 'error');
        }
    }

    function update_profil_karyawan(Request $request)
    {
        $user_id = auth()->id();

        $request->validate([
            'name' => 'required|string',
            'photo_profile' => 'image|mimes:jpeg,png,jpg|max:2048',
            'alamat'=> 'required',
            'no_handphone'=> 'required'
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'no_handphone.required' => 'Nomor Handphone wajib diisi',
            'name.string' => 'Nama harus berupa huruf',
            'photo_profile.image' => 'File harus berupa gambar',
            'photo_profile.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg',
            'photo_profile.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
        ]);

        $karyawan = Karyawan::where('user_id', $user_id)->first();


        $karyawan->name = $request->input('name');
        $karyawan->alamat = $request->input('alamat');
        $karyawan->no_handphone = $request->input('no_handphone');

        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $fotoName = $file->getClientOriginalExtension();
            $file->move('photo_user', $fotoName);
            $karyawan->photo_profile = $fotoName;
        }

        if ($karyawan->save()) {
            Alert::toast('Profil berhasil diperbarui', 'success');
            return redirect('/karyawann/profil');
        }
    }

    public function notifikasi(){
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $notifikasi1 = Notifikasi::where('user_id', $user_id)->latest()->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'karyawan' => $karyawan,
            'notifikasi'=> $notifikasi,
            'notifikasi1'=> $notifikasi1,
            'jumlah'=> $jumlah
        ];
        return view('karyawan.karyawan-notifikasi-semua', $data);
    }
}
