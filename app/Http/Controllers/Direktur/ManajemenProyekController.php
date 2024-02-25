<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Klien;
use App\Models\Notifikasi;
use App\Models\Proyek;
use App\Models\Tugas;
use App\Models\TugasKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManajemenProyekController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'proyek' => $proyek,
            'klien' => $klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-proyek', $data);
    }

    public function save_proyek(Request $request)
    {
        $request->validate(
            [
                'nama_proyek' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ],
            [
                'nama_proyek.required' => 'Nama Proyek harus diisi',
                'tanggal_mulai.required' => 'Tanggal Mulai harus diisi',
                'tanggal_selesai.after_or_equal' => 'Tanggal Selesai harus setelah atau sama dengan Tanggal Mulai',
            ]
        );

        $klienId = $request->input('klien_id');
        $klien = Klien::find($klienId);

        $data = new Proyek([
            'nama_proyek' => $request->input('nama_proyek'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'level_proyek' => $request->input('level_proyek'),
            'klien_id' => $klien->id_klien
        ]);
        if ($data->save()) {
            alert()->toast('Data berhasil ditambahkan', 'success');
            return redirect()->back();
        }
    }


    public function detail_proyek(string $id_proyek)
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::find($id_proyek);
        $allproyek = Proyek::all();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'proyek' => $proyek,
            'allproyek' => $allproyek,
            'klien' => $klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        if (!$proyek) {
            abort(404, 'Data tidak ditemukan');
        }
        return view('direktur.direktur-detail-proyek', $data);
    }

    public function update_proyek(Request $request, string $id_proyek)
    {
        $request->validate(
            [
                'nama_proyek' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ],
            [
                'nama_proyek.required' => 'Nama Proyek harus diisi',
                'tanggal_mulai.required' => 'Tanggal Mulai harus diisi',
                'tanggal_selesai.after_or_equal' => 'Tanggal Selesai harus setelah atau sama dengan Tanggal Mulai',
            ]
        );

        $proyek = Proyek::find($id_proyek);

        if (!$proyek) {
            abort(404, 'Data tidak ditemukan');
        }
        $klienId = $request->input('klien_id');
        $klien = Klien::find($klienId);

        $proyek->update([
            'nama_proyek' => $request->input('nama_proyek'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'level_proyek' => $request->input('level_proyek'),
            'klien_id' => $klien->id_klien,
        ]);

        alert()->toast('Data berhasil diperbarui', 'success');
        return redirect()->back();
    }

    public function delete_proyek(Proyek $proyek)
    {
        $proyek->delete();
        alert()->toast('Data berhasil dihapus', 'success');
        return redirect()->route('direktur.proyek');
    }

    // in progress
    public function proses_proyek()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::whereIn('status_proyek', ['In Progress'])->get();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'proyek' => $proyek,
            'klien' => $klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-waiting-proyek', $data);
    }

    // done
    public function done_proyek()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::whereIn('status_proyek', ['Done'])->get();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'proyek' => $proyek,
            'klien' => $klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-done-proyek', $data);
    }

    public function laporan()
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::whereIn('status_proyek', ['Done'])->get();
        $klien = Klien::all();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'proyek' => $proyek,
            'klien' => $klien,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('direktur.direktur-laporan-selesai', $data);
    }

    public function button_proyek_selesai($proyek_id) {
        $proyek = Proyek::findOrFail($proyek_id);
        $checktugas = Tugas::where('proyek_id', $proyek_id)->where('status_tugas', '!=', 'Done')->exists();

        if ($checktugas) {
            alert()->toast('Proyek belum selesai, karena ada tugas yang belum selesai', 'error');
            return redirect()->back();
        }

        $proyek->status_proyek = 'Done';
        $proyek->save();
        alert()->toast('Proyek Sudah Selesai', 'success');
        return redirect()->route('direktur.proyek');
    }

}
