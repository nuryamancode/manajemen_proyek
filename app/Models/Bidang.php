<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';
    protected $primaryKey = 'id_bidang';
    public $timestamps = false;
    protected $fillable = [
        'nama_bidang'
    ];

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'bidang_id');
    }
}
