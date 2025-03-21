<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_biaya',
        'nominal',
        'nama_nominal',
        'tahun',
        'bulan',
        'level',
    ];
}
