<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'name',
        'alamat',
        'no_handphone',
        'user_id',
        'bidang_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }


    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'karyawan_id', 'id_karyawan');
    }
}
