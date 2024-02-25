<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $fillable = [
        'karyawan_id',
        'proyek_id',
        'fase_proyek',
        'direktur_id',
        'nama_tugas',
        'catatan_karyawan',
        'keterangan_tugas',
        'deadline_tugas',
        'berkas_tugas',
        'catatan_revisi',
        'upload_berkas',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id_karyawan');
    }
    public function direktur(){
        return $this->belongsTo(Direktur::class, 'direktur_id');
    }
    public function proyek(){
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
    public function kuisioner(){
        return $this->hasOne(Tugas::class, 'tugas_id');
    }
}
