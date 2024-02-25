<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktur extends Model
{
    use HasFactory;
    protected $table = 'direktur';
    protected $primaryKey = 'id_direktur';
    protected $fillable = [
        'name',
        'email',
        'alamat',
        'no_handphone',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
