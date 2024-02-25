<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Direktur;
use App\Models\Notifikasi;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KalenderProyekController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user_id = auth()->id();
        $direktur = Direktur::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $notifikasi = Notifikasi::where('user_id', $user_id)->latest()->take(5)->get();
        $jumlahnotif = Notifikasi::where('user_id', $user_id)->where('dibaca', false)->get();
        $jumlah = $jumlahnotif->count();
        $proyek = Proyek::all();
        $detail_events = Calendar::all();
        $events = [];
        $timeline = Calendar::with('proyek')->get();

        foreach ($timeline as $value) {
            $events[] = [
                'title' => $value->events_name . '(' . $value->proyek->nama_proyek . ')',
                'start' => $value->proyek->tanggal_mulai,
                'end' => $value->proyek->tanggal_selesai,
                'description' => $value->description,
            ];
        }
        $data = [

            'role' => $role,
            'direktur' => $direktur,
            'events' => $events,
            'proyek' => $proyek,
            'detail_events' => $detail_events,
            'notifikasi' => $notifikasi,
            'jumlah' => $jumlah
        ];

        return view('direktur.direktur-kalender-proyek', $data);
    }


    public function save_data(Request $request)
    {
        $nama_acara = $request->input('nama_acara');
        $proyek_id = $request->input('proyek_id');
        $proyek = Proyek::find($proyek_id);
        $description = $request->input('description');

        $data = new Calendar([
            'events_name' => $nama_acara,
            'proyek_id' => $proyek->id_proyek,
            'description' => $description,
        ]);

        if ($data->save()) {
            alert()->toast('Acara berhasil ditambahkan', 'success');
            return redirect()->back();
        }
    }

    public function update_data(Request $request, $id_calendar)
    {
        $calender = Calendar::find($id_calendar);
        if (!$calender) {
            alert()->toast('Acara tidak ditemukan', 'error');
        }

        $proyek_id = $request->input('proyek_id');
        $proyek = Proyek::find($proyek_id);

        $calender->update([
            'events_name' => $request->input('nama_acara'),
            'proyek_id' => $proyek->id_proyek,
            'description' => $request->input('description'),
        ]);

            alert()->toast('Acara berhasil diperbaharui', 'success');
            return redirect()->back();
    }


    public function delete_data(Calendar $calendar)
    {
        $calendar->delete();
        alert()->toast('Acara berhasil dihapus', 'success');
        return redirect()->back();
    }
}
