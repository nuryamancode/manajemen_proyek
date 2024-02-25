<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Notifikasi;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirekturController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-dashboard', $data);
    }

    function profil_direktur()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-profil', $data, compact('direktur'));
    }
    function edit_profil_direktur()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-edit-profil', $data);
    }

    function update_profil_direktur(Request $request)
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

        $direktur = Direktur::where('user_id', $user_id)->first();

        $direktur->name = $request->input('name');
        $direktur->alamat = $request->input('alamat');
        $direktur->no_handphone = $request->input('no_handphone');

        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');

            // Pastikan file yang diunggah adalah file gambar
            if ($file->isValid()) {
                $fotoName = $file->getClientOriginalExtension();
                $file->move('photo_user', $fotoName);
                $direktur->photo_profile = $fotoName;
            } else {
                return redirect()->back()->withErrors(['photo_profile' => 'File tidak valid']);
            }
        }

        if ($direktur->save()) {
            alert()->toast('Profil berhasil diperbarui', 'success');
            return redirect('/direktur/profil');
        }
    }


    public function notifikasi(){
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $notifikasi1 = Notifikasi::where('user_id', $user_id)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'notifikasi'=> $notifikasi,
            'notifikasi1'=> $notifikasi1,
            'jumlah'=> $jumlah
        ];
        return view('direktur.direktur-notifikasi', $data);
    }

}
