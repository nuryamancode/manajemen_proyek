<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\HasilKuisioner;
use App\Models\Kuisioner;
use App\Models\Notifikasi;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function kuisioner($tugas_id)
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $sub = SubKriteria::all();
        $subkriteria = SubKriteria::where('nama_subkriteria')->get();
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'sub' => $sub,
            'subkriteria' => $subkriteria,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah,
            'tugas_id' => $tugas_id
        ];
        return view('direktur.direktur-penilaian', $data);
    }

    public function hitung_jumlah_kuisioner(Request $request)
{
    $request->validate([
        'nilai.*' => 'required|numeric|between:1,5',
    ]);

    $nilai = $request->input('nilai');
    $tugas_id = $request->input('tugas_id');

    // Inisialisasi array untuk menyimpan jumlah nilai dari setiap kriteria
    $totalNilaiKriteria = [];

    if (!empty($nilai)) {
        foreach ($nilai as $idSubKriteria => $nilaiSubKriteria) {
            $subKriteria = SubKriteria::findOrFail($idSubKriteria);

            // Tambahkan nilai subkriteria ke dalam total nilai kriteria yang sesuai
            if (!isset($totalNilaiKriteria[$subKriteria->kriteria_id])) {
                $totalNilaiKriteria[$subKriteria->kriteria_id] = 0;
            }
            $totalNilaiKriteria[$subKriteria->kriteria_id] += $nilaiSubKriteria;

            Kuisioner::create([
                'tugas_id' => $tugas_id,
                'subkriteria_id' => $idSubKriteria,
                'kriteria_id' => $subKriteria->kriteria_id,
                'rating' => $nilaiSubKriteria,
            ]);
        }

        // Hitung total jumlah subkriteria untuk setiap kriteria dan simpan dalam array
        $jumlahSubKriteriaPerKriteria = [];
        foreach ($totalNilaiKriteria as $kriteriaId => $totalNilai) {
            $jumlahSubKriteriaPerKriteria[$kriteriaId] = SubKriteria::where('kriteria_id', $kriteriaId)->count();
        }

        // Hitung total nilai akhir dari semua kriteria
        $totalNilaiAkhir = 0;
        foreach ($totalNilaiKriteria as $kriteriaId => $totalNilai) {
            $jumlahSubKriteria = $jumlahSubKriteriaPerKriteria[$kriteriaId];
            $nilaiRataRata = $totalNilai / $jumlahSubKriteria;
            $totalNilaiAkhir += $nilaiRataRata;
        }

        // Simpan total nilai akhir ke dalam tabel hasiljumlah
        HasilKuisioner::create([
            'tugas_id' => $tugas_id,
            'total_nilai_akhir' => $totalNilaiAkhir,
        ]);

        alert()->toast('Berhasil dinilai', 'success');
        return redirect()->route('direktur.tugaskaryawan');
    } else {
        alert()->toast('Rating tidak boleh kosong', 'error');
        return redirect()->back();
    }
}

}
