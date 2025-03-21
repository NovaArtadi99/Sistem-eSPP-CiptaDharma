<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TagihanImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public function startRow(): int
     {
         return 2;
     }
    public function model(array $row)
    {
        $tagihan = new Tagihan([
            'keterangan' => $row[1] ?? '',
            'tanggal_terbit'     => $row[2] ?? '',
            'tanggal_lunas'      => $row[3] ?? Carbon::now()->format('Y-m-d'),
            'status'     => $row[4] ?? '',
            'user_penerbit_id'    => User::where('nama',$row[5])->first()->id,
            'user_melunasi_id' => User::where('nama',$row[6])->first()->id ?? null,
            'biaya_id' => Biaya::where('nama_biaya',$row[7])->first()->id ?? '',
            'user_id'   => User::where('nama',$row[8])->first()->id ?? '',
            'bulan'  => $row[9] ?? '',
            'tahun'  => $row[10] ?? '',

        ]);

        return $tagihan;
    }
}
