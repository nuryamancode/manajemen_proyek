<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Fase;
use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Notifikasi;
use App\Models\Proyek;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TugasKaryawanController extends Controller
{
    public function tugas(Request $request, $id_proyek)
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $karyawan = Karyawan::whereDoesntHave('tugas')->get();
        $tugas_all = Tugas::join('proyek', 'tugas.proyek_id', '=', 'proyek.id_proyek')
            ->orderBy('proyek.level_proyek', 'asc')
            ->get();
        $proyek = Proyek::findOrFail($id_proyek);
        $fase = Tugas::where('proyek_id', $id_proyek)->get();
        $selected_phase = $request->input('nama_fase');

        if ($selected_phase) {
            $tugas = Tugas::where('proyek_id', $id_proyek)
                ->where('fase_proyek', $selected_phase)
                ->get();
        } else {
            $tugas = Tugas::whereNull('fase_proyek')->get();
        }

        $data = [
            'role' => $role,
            'direktur' => $direktur,
            'tugas' => $tugas,
            'tugas_all' => $tugas_all,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah,
            'id_proyek' => $id_proyek,
            'karyawan' => $karyawan,
            'fase' => $fase,
            'proyek' => $proyek,
            'selected_phase' => $selected_phase,
        ];
        return view('direktur.direktur-tugas', $data);
    }


    public function detail_tugas_karyawan($id_tugas)
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $karyawan = Karyawan::all();
        $tugas = Tugas::find($id_tugas);


        $data = [
            'role' => $role,
            'direktur' => $direktur,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah,
            'tugas' => $tugas,
            'karyawan' => $karyawan,
        ];
        return view('direktur.direktur-detail-tugas', $data);
    }


    // tambah_tugas method
    public function tambah_tugas(Request $request)
    {
        $proyekid = $request->input('proyek_id');
        $proyek = Proyek::find($proyekid);

        $karyawanid = $request->input('karyawan_id');
        $karyawan = Karyawan::find($karyawanid);

        // Mendapatkan objek direktur
        $direktur = auth()->user()->direktur;
        $file = $request->file('berkas_tugas');
        $filename = $file->getClientOriginalName();
        $file->move('berkas_tugas/', $filename);

        // Membuat objek Tugas
        $data = new Tugas([
            'fase_proyek' => $request->input('fase_proyek'),
            'nama_tugas' => $request->input('nama_tugas'),
            'deadline_tugas' => $request->input('deadline_tugas'),
            'keterangan_tugas' => $request->input('keterangan_tugas'),
            'berkas_tugas' => $filename,
            'direktur_id' => $direktur->id_direktur,
            'karyawan_id' => $karyawanid,
            'proyek_id' => $proyekid,
        ]);

        // Simpan objek Tugas
        if ($data->save()) {
            alert()->toast('Data berhasil ditambahkan', 'success');
            $user_id_karyawan = $karyawan->user_id;
            $judul = 'Tugas Baru';
            $pesan = 'Direktur menambahkan tugas baru untuk kamu';
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $user_id_karyawan;
            $notifikasi->judul = $judul;
            $notifikasi->pesan = $pesan;
            $notifikasi->save();

            return redirect()->back();
        } else {
            alert()->toast('Data gagal ditambahkan', 'error');
            return redirect()->back()->withErrors('Data gagal ditambahkan');
        }
    }




    public function edit_tugas(Request $request, $id_tugas)
    {
        $tugas = Tugas::find($id_tugas);

        $proyekid = $request->input('proyek_id');
        $proyek = Proyek::find($proyekid);

        $karyawanid = $request->input('karyawan_id');
        $karyawan = Karyawan::find($karyawanid);
        $direktur = auth()->user()->direktur;

        if ($request->hasFile('berkas_tugas')) {
            $file = $request->file('berkas_tugas');

            if ($tugas->berkas_tugas) {
                Storage::disk('public')->delete('berkas/' . $tugas->berkas_tugas);
            }

            $filename = $file->getClientOriginalName();
            $file->move('berkas_tugas/', $filename);

            $tugas->update(['berkas_tugas' => $filename]);
        }

        $tugas->update([
            'fase_proyek' => $request->input('fase_proyek'),
            'nama_tugas' => $request->input('nama_tugas'),
            'deadline_tugas' => $request->input('deadline_tugas'),
            'keterangan_tugas' => $request->input('keterangan_tugas'),
            'proyek_id' => $proyek->id_proyek,
            'karyawan_id' => $karyawan->id_karyawan,
            'direktur_id' => $direktur->id_direktur,
        ]);

        if ($tugas->wasChanged()) {
            alert()->toast('Data berhasil diperbaharui', 'success');

            $user_id_karyawan = $karyawan->user_id;
            $judul = 'Tugas Diperbaharui';
            $pesan = 'Direktur memperbaharui tugas untuk kamu';
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $user_id_karyawan;
            $notifikasi->judul = $judul;
            $notifikasi->pesan = $pesan;
            $notifikasi->save();

            return redirect()->back();
        } else {
            // Pesan error
            alert()->toast('Data gagal ditambahkan', 'error');
            return redirect()->back()->withErrors('Data gagal ditambahkan');
        }
    }

    public function hapus_tugas(Tugas $tugas)
    {
        $tugas->delete();
        alert()->toast('Data berhasil dihapus');
        return redirect()->back();
    }


    public function tugas_selesai(string $id_tugas)
    {
        $tugas = Tugas::find($id_tugas);

        if (!$tugas) {
            alert()->toast('Tugas tidak ditemukan', 'error');
            return redirect()->back();
        }

        if (!$tugas->upload_berkas) {
            alert()->toast('File tugas kosong', 'error');
            return redirect()->back();
        }

        if ($tugas->status_tugas !== 'Review') {
            alert()->toast('Proyek belum direview', 'error');
            return redirect()->back();
        }

        $tugas->status_tugas = 'Selesai';
        $tugas->save();

        alert()->toast('Tugas Selesai', 'success');

        return redirect()->route('direktur.kuisioner', ['tugas_id' => $tugas->id_tugas]);
    }



    public function tugas_belumselesai(string $id_tugas, Request $request)
    {
        $tugas = Tugas::find($id_tugas);
        if (!$tugas) {
            alert()->toast('Proyek tidak ditemukan', 'error');
            return redirect()->back();
        }
        if (!in_array($tugas->status_tugas, ['Review', 'Selesai'])) {
            alert()->toast('Tugas belum direview', 'error');
            return redirect()->back();
        }
        if ($tugas->status_tugas === 'Revisi') {
            alert()->toast('Status sudah ditolak', 'error');
            return redirect()->back();
        }
        $tugasKaryawan = Tugas::where('proyek_id', $id_tugas)->get();
        foreach ($tugasKaryawan as $tugas) {
            $karyawan = Karyawan::find($tugas->karyawan_id);
            if ($karyawan) {
                $notifikasi = new Notifikasi();
                $notifikasi->user_id = $karyawan->user_id;
                $notifikasi->judul = 'Tugas Belum Selesai';
                $notifikasi->pesan = 'Tugas Anda ' . $tugas->nama_tugas . ' belum selesai dengan catatan: ' . $request->input('catatan');
                $notifikasi->save();
            }
        }

        $tugas->status_tugas = 'Revisi';
        $tugas->upload_berkas = null;
        $tugas->catatan_karyawan = null;
        $tugas->save();
        $catatan = $request->input('catatan_revisi');
        Tugas::where('proyek_id', $id_tugas)->update([
            'catatan_revisi' => $catatan,
        ]);

        alert()->toast('Tugas direvisi', 'success');
        return redirect()->back();
    }


    public function lihat_tugas(string $id_tugas)
    {
        $tugas = Tugas::find($id_tugas);
        $tugas->status_tugas = 'Review';
        $tugas->save();
        alert()->toast('Tugas sedang direview', 'success');
        return redirect()->back();
    }
}
