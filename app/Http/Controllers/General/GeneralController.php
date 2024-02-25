<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function download_berkas_proyek($berkas)
    {
        return response()->download(public_path('berkas_tugas/' . $berkas));
    }

    public function download_hasil_proyek($uploadberkas)
    {
        $filePath = public_path('upload_berkas/' . $uploadberkas);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
    }

    public function dibaca ($id_notifikasi){
        $notifikasi = Notifikasi::findOrFail($id_notifikasi);
        $notifikasi->update(['dibaca' => true]);
        return redirect()->back();
    }

    public function hapusSemuanotifikasi(Request $request)
{
    $user_id = auth()->id();
    Notifikasi::where('user_id', $user_id)->delete();
    return redirect()->back();

}
}
