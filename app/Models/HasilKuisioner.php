<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKuisioner extends Model
{
    use HasFactory;
    protected $table = "hasil_kuisioner";
    protected $primaryKey ="id_hasil";
    protected $fillable = [
        'tugas_id',
        'total_nilai_akhir',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tugas(){
        return $this->belongsTo(Proyek::class, 'tugas_id');
    }
    public function subkriteria(){
        return $this->belongsTo(Proyek::class, 'subkriteria_id');
    }
}
