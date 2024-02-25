<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Notifikasi;
use App\Models\Proyek;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\confirm;

class DaftarTugasController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $klien = Klien::all();
        $tugas = Tugas::where('karyawan_id', $karyawan->id_karyawan)->get();
        $data = [

            'role' => $role,
            'proyek' => $proyek,
            'klien' => $klien,
            'karyawan' => $karyawan,
            'tugas' => $tugas,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('karyawan.karyawan-daftar-tugas', $data);
    }

    public function detail_daftar_tugas(string $id_tugas)
    {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $klien = Klien::all();
        $tugas = Tugas::find($id_tugas);
        $data = [

            'role' => $role,
            'proyek' => $proyek,
            'klien' => $klien,
            'karyawan' => $karyawan,
            'tugas' => $tugas,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('karyawan.karyawan-detail-tugas', $data);
    }

    public function upload_berkas(Request $request, string $id_tugas)
    {
        $request->validate([
            'upload_berkas' => 'required|mimes:pdf,doc,docx,jpeg,png,xls,xlsx,zip,csv,rar'
        ], [
            'upload_berkas.required' => 'File harus diisi',
            'upload_berkas.mimes' => 'File harus berformat jpeg, png, pdf, doc, docx, zip, rar, xls, csv atau xlsx',
        ]);

        $file = $request->file('upload_berkas');
        $filename = $file->getClientOriginalName();
        $file->move('upload_berkas/', $filename);

        $data = Tugas::find($id_tugas);

        if ($data) {
            $data->update([
                'upload_berkas' => $filename,
                'catatan_karyawan' => $request->input('catatan_karyawan'),
            ]);

            $karyawan = Auth::user()->karyawan;
            $pesan = 'Berkas telah diunggah oleh ' . $karyawan->name;

            // Ambil direktur_id dari objek $data
            $direkturId = $data->direktur_id;

            // Ambil user_id dari tabel direktur berdasarkan direktur_id
            $direktur = Direktur::find($direkturId);
            $direkturUserId = $direktur->user_id;

            // Tambah notifikasi untuk direktur yang sesuai
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $direkturUserId;
            $notifikasi->judul = 'Berkas Telah Diunggah';
            $notifikasi->pesan = $pesan;
            $notifikasi->save();

            alert()->toast('Berkas berhasil ditambahkan', 'success');
            return redirect()->back();
        } else {
            alert()->toast('Berkas tidak berhasil ditambahkan', 'error');
            return redirect()->back();
        }
    }




    public function daftar_tugas_selesai()
    {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $klien = Klien::all();
        $tugas = Tugas::where('karyawan_id', $karyawan->id_karyawan)->whereIn('proyek_id', function ($query) {
            $query->select('id_proyek')->from('proyek')->where('status_tugas', 'Selesai');
        })
            ->get();
        $data = [

            'role' => $role,
            'proyek' => $proyek,
            'klien' => $klien,
            'karyawan' => $karyawan,
            'tugas' => $tugas,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('karyawan.karyawan-tugas-selesai', $data);
    }

    public function detail_daftar_tugas_selesai(string $id_tugas)
    {
        $user_id = auth()->id();
        $karyawan = Karyawan::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $klien = Klien::all();
        $tugas = Tugas::find($id_tugas);
        $data = [

            'role' => $role,
            'proyek' => $proyek,
            'klien' => $klien,
            'karyawan' => $karyawan,
            'tugas' => $tugas,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];
        return view('karyawan.karyawan-detail-tugas-selesai', $data);
    }
}
