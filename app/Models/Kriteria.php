<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        "nama_kriteria",
        "bobot_kriteria",
    ];
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function sub_kriteria(){
        return $this->hasOne(SubKriteria::class, 'kriteria_id');
    }
}
