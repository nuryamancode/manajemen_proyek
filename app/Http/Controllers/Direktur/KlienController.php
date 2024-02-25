<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Klien;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlienController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'klien'=>$klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-klien', $data);
    }

    public function save_klien(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'alamat'=>'required',
            'nomor_handphone'=>'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus disertai dengan @',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'nomor_handphone.required' => 'No Handphone tidak boleh kosong',
        ]);

        $nama_klien = $request->input('name');
        $email = $request->input('email');
        $alamat = $request->input('alamat');
        $nomor_handphone = $request->input('nomor_handphone');

        $data = new Klien([
            'nama_klien'=>$nama_klien,
            'email'=>$email,
            'alamat'=>$alamat,
            'nomor_handphone'=>$nomor_handphone
        ]);

        if ($data->save()) {
            alert()->toast('Data berhasil ditambahkan', 'success');
            return redirect()->back();
        }
        else{
            alert()->toast('Data tidak berhasil ditambahkan', 'error');
            return redirect()->back();
        }
    }
    public function update_klien(Request $request, $id_klien)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'nomor_handphone' => 'required'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus disertai dengan @',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'nomor_handphone.required' => 'No Handphone tidak boleh kosong',
        ]);

        $data = Klien::find($id_klien);

        if (!$data) {
            abort(404, 'Data tidak ditemukan');
        }

        $data->nama_klien = $request->input('name');
        $data->email = $request->input('email');
        $data->alamat = $request->input('alamat');
        $data->nomor_handphone = $request->input('nomor_handphone');

        if ($data->save()) {
            alert()->toast('Data berhasil diperbaharui', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Data tidak berhasil diperbaharui', 'error');
            return redirect()->back();
        }
    }

    public function delete_klien(Klien $klien)
    {
        $klien->delete();
        alert()->toast('Data berhasil dihapus', 'success');
        return redirect()->back();
    }
}
