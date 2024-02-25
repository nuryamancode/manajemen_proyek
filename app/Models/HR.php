<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HR extends Model
{
    use HasFactory;
    protected $table = 'hr';
    protected $primaryKey = 'id_hr';
    protected $fillable = [
        'name',
        'alamat',
        'no_handphone',
        'photo_profile',
        'user_id',
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
