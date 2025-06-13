<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'nip',
        // 'username',
        'email',
        'password',
        'nama_wali',
        'alamat',
        'no_telp',
        'angkatan',
        'kelas',
        'jenis_kelamin',
        // 'id_telegram',
        'agama',
        'chat_id',
        'tanggal_lahir'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function menerbitkan()
    {
        return $this->hasMany(Tagihan::class, 'user_penerbit_id');
    }

    public function melunasi()
    {
        return $this->hasMany(Tagihan::class, 'user_melunasi_id');
    }
}
