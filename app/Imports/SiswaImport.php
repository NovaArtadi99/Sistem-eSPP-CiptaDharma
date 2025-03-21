<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
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
        $user = new User([
            'username' => $row[1] ?? '',
            'nama'     => $row[2] ?? '',
            'nis'      => $row[3] ?? '',
            'nisn'     => $row[4] ?? '',
            'email'    => $row[5] ?? '',
            'password' => $row[6] ?? '',
            'nama_wali' => $row[7] ?? '',
            'alamat'   => $row[8] ?? '',
            'no_telp'  => $row[9] ?? '',
            'angkatan' => $row[10] ?? '',
            'kelas'    => $row[11] ?? '',
            'jenis_kelamin' => $row[12] ?? '',
            'agama'    => $row[13] ?? '',
            'tanggal_lahir' => $row[14] ?? '',
        ]);
        $user->assignRole('SiswaOrangTua');
        return $user;
    }
}
