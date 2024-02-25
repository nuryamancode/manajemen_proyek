<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\HR;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKaryawanController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $karyawan = Karyawan::with('user')->get();
        $bidang = Bidang::all();
        $data = [

            'role' => $role,
            'hr' => $hr,
            'karyawan' => $karyawan,
            'bidang' => $bidang,
        ];
        return view('hr.hr-datakaryawan', $data);
    }

    public function tambah_bidang(string $id_karyawan, Request $request)
    {

        $karyawan = Karyawan::find($id_karyawan);
        $bidang_id = $request->input('bidang_id');
        $karyawan->update([
            'bidang_id'=>$bidang_id
        ]);
        alert()->toast('Bidang berhasil ditambahkan', 'success');
        return redirect()->back();

    }

    function delete_data_karyawan($id)
    {
        alert()->toast('Data berhasil dihapus', 'success');
        $karyawan = Karyawan::find($id);

        if ($karyawan) {
            $karyawan->delete();
            return redirect()->back();
        }
    }

    public function bidang()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $bidang = Bidang::all();
        $data = [

            'role' => $role,
            'hr' => $hr,
            'bidang' => $bidang,
        ];
        return view('hr.hr-bidang', $data);
    }

    public function save_bidang(Request $request)
    {
        $request->validate([
            'nama_bidang'=>'required'
        ],[
            'nama_bidang.required'=>'Nama tidak boleh kosong'
        ]);

        $bidang = $request->input('nama_bidang');
        $data = Bidang::create([
            'nama_bidang'=>$bidang
        ]);
        $data->save();
        alert()->toast('Data berhasil ditambahkan', 'success');
        return redirect()->back();
    }
    public function update_bidang(Request $request, $id_bidang)
    {
        $request->validate([
            'nama_bidang'=>'required'
        ],[
            'nama_bidang.required'=>'Nama tidak boleh kosong'
        ]);

        $bidang = Bidang::find($id_bidang);
        $bidang->update(['nama_bidang'=> $request->input('nama_bidang')]);
        alert()->toast('Data berhasil diperbaharui', 'success');
        return redirect()->back();
    }

    public function delete_bidang(Bidang $bidang)
    {
        $bidang->delete();
        alert()->toast('Data berhasil dihapus', 'success');
        return redirect()->back();
    }
}
