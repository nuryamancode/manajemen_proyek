<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Bobot;
use App\Models\HR;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function kriteria()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $kriteria = Kriteria::all();
        $data = [

            'role' => $role,
            'hr' => $hr,
            'kriteria' => $kriteria,
        ];
        return view('hr.hr-kriteria', $data);
    }

    function add_data_kriteria(Request $request)
    {
        $nama_kriteria = $request->input('nama_kriteria');
        $bobot_kriteria = $request->input('bobot');
        $existingKriteria = Kriteria::where('nama_kriteria', $nama_kriteria)->first();
        if ($existingKriteria) {
            alert()->toast('Nama kriteria sudah ada', 'error');
            return redirect()->back();
        }
        $total_bobot = Kriteria::sum('bobot_kriteria') + $bobot_kriteria;

        if ($total_bobot > 100) {
            alert()->toast('Total bobot kriteria melebihi 100', 'error');
            return redirect()->back();
        }

        $data = new Kriteria([
            'nama_kriteria' => $nama_kriteria,
            'bobot_kriteria' => $bobot_kriteria,
        ]);

        if ($data->save()) {
            alert()->toast('Data berhasil ditambahkan', 'success');
            return redirect()->back();
        }
    }

    function update_data_kriteria(Request $request, $id_kriteria)
    {
        $kriteria = Kriteria::find($id_kriteria);
        $nama_kriteria = $request->input('nama_kriteria');

        $existingKriteria = Kriteria::where('nama_kriteria', $nama_kriteria)
            ->where('id_kriteria', '<>', $id_kriteria)
            ->first();

        if ($existingKriteria) {
            alert()->toast('Nama kriteria sudah ada', 'error');
            return redirect()->back();
        }

        $total_bobot = Kriteria::where('id_kriteria', '<>', $id_kriteria)->sum('bobot_kriteria') + $request->input('bobot');

        if ($total_bobot > 100) {
            alert()->toast('Total bobot kriteria melebihi 100', 'error');
            return redirect()->back();
        }

        $kriteria->update($request->all());
        alert()->toast('Data berhasil diperbaharui', 'success');
        return redirect()->back();
    }

    function delete_data_kriteria(Kriteria $kriteria)
    {
        $kriteria->delete();
        alert()->toast('Data berhasil dihapus', 'success');
        return redirect()->back();
    }


    // sub-kriteria

    public function sub_kriteria()
    {
        $user_id = auth()->id();
        $hr = HR::where('user_id', $user_id)->first();
        $role = Auth::user()->role;
        $sub = SubKriteria::all();
        $uniqueKriterias = $sub->unique('kriteria.nama_kriteria');
        $kri = Kriteria::all();
        $data = [

            'role' => $role,
            'hr' => $hr,
            'sub' => $sub,
            'uniqueKriterias' => $uniqueKriterias,
            'kri' => $kri,
        ];
        return view('hr.hr-sub-kriteria', $data);
    }

    // public function add_sub_view()
    // {
    //     $user_id = auth()->id();
    //     $hr = HR::where('user_id', $user_id)->first();
    //     $role = Auth::user()->role;
    //     $sub = SubKriteria::all();
    //     $kriteria = Kriteria::all();
    //     $data = [

    //         'role' => $role,
    //         'hr' => $hr,
    //         'sub' => $sub,
    //         'kriteria' => $kriteria,

    //     ];
    //     return view('hr.hr-add-sub-kriteria', $data);
    // }

    function add_data_sub(Request $request)
    {
        $kriteriaid = $request->input('kriteria_id');

        SubKriteria::create([
            'kriteria_id' => $kriteriaid,
            'nama_subkriteria' => $request->input('nama_sub'),
        ]);

        alert()->toast('Data berhasil ditambahkan', 'success');
        return redirect()->route('hr.sub.kriteria');
    }


    function update_data_sub(Request $request, $id_subkriteria)
    {
        $kriteriaid = $request->input('kriteria_id');

        $sub = SubKriteria::find($id_subkriteria);

        if (!$sub) {
            alert()->toast('Sub kriteria tidak ditemukan', 'error');
            return redirect()->back();
        }

        $sub->update([
            'nama_subkriteria' => $request->input('nama_sub'),
            'kriteria_id' => $kriteriaid,
        ]);

        alert()->toast('Data berhasil diperbaharui', 'success');
        return redirect()->back();
    }


    function delete_data_sub(SubKriteria $subKriteria)
    {
        $subKriteria->delete();
        alert()->toast('Data berhasil dihapus', 'success');
        return redirect()->back();
    }
}
