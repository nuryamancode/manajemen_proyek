<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;

    protected $table = "kuisioner";
    protected $primaryKey ="id_kuisioner";
    protected $fillable = [
        'rating',
        'subkriteria_id',
        'kriteria_id',
        'tugas_id',
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
