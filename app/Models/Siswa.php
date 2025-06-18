<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama',
        'nama_wali',
        'alamat',
        'no_telp',
        'email',
        'angkatan',
        'kelas',
        'user_id',
        'nama_orang_tua'
    ];


    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}
