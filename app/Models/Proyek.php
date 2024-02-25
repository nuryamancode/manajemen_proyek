<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';
    protected $fillable = [
        'nama_proyek',
        'tanggal_mulai',
        'tanggal_selesai',
        'berkas',
        'level_proyek',
        'status_proyek',
        'klien_id'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id');
    }

    public function tugas()
    {
        return $this->hasOne(Tugas::class, 'proyek_id');
    }
    public function calendar()
    {
        return $this->hasOne(Calendar::class, 'proyek_id');
    }

}
