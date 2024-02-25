<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Kriteria as ModelsKriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Kriteria extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsKriteria::create([
            "nama_kriteria" => "Pencapaian",
            "bobot_kriteria" => 20,
        ]);
        ModelsKriteria::create([
            "nama_kriteria" => "Kemampuan",
            "bobot_kriteria" => 20,
        ]);
        ModelsKriteria::create([
            "nama_kriteria" => "Sikap",
            "bobot_kriteria" => 20,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Kualitas Target",
            "kriteria_id" => 1,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Kualitas Pekerjaan",
            "kriteria_id" => 1,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Ketepatan Tugas",
            "kriteria_id" => 1,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Pekerjaan Sesuai SOP",
            "kriteria_id" => 2,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Kemampuan Dalam TIM",
            "kriteria_id" => 2,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Tanggung Jawab Terhadap Pekerjaan",
            "kriteria_id" => 2,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Kehadiran Karyawan",
            "kriteria_id" => 3,
        ]);
        SubKriteria::create([
            "nama_subkriteria" => "Ketepatan Waktu",
            "kriteria_id" => 3,
        ]);
        Bidang::create([
            "nama_bidang" => "Programmer Senior",
        ]);
        Bidang::create([
            "nama_bidang" => "Programmer Junior",
        ]);
    }
}
