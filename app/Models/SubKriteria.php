<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        "nama_subkriteria",
        "kriteria_id",
    ];
    protected $table = 'sub_kriteria';
    protected $primaryKey = 'id_subkriteria';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function kriteria(){
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
    public function kuisioner(){
        return $this->hasOne(Kriteria::class, 'subkriteria_id');
    }
}
