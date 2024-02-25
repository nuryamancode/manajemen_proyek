<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klien extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'klien';
    protected $primaryKey = 'id_klien';
    protected $fillable = [
        'nama_klien',
        'alamat',
        'nomor_handphone',
        'email',

    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function proyek()
    {
        return $this->hasOne(Proyek::class, 'klien_id');
    }


}
