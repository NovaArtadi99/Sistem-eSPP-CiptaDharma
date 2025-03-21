<?php

namespace App\Exports;

use App\Models\user;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{

    private $counter = 0;

    use Exportable;
    public function collection()
    {
        $siswa = User::role('SiswaOrangTua')->get();

        return $siswa;
    }


    public function headings(): array
    {
        return [
            '#',
            'Username',
            'Nama',
            'NIS',
            'NISN',
            'Email',
            'Password',
            'Nama Orang Tua',
            'Alamat',
            'Telepon',
            'Angkatan',
            'Kelas',
            'Jenis Kelamin',
            'Agama',
            'Tanggal Lahir'
        ];
    }


    public function map($siswa): array
    {
        return [
            ++$this->counter,
            $siswa->username,
            $siswa->nama,
            $siswa->nis,
            $siswa->nisn,
            $siswa->email,
            $siswa->password,
            $siswa->nama_wali,
            $siswa->alamat,
            $siswa->no_telp,
            $siswa->angkatan,
            $siswa->kelas,
            $siswa->jenis_kelamin,
            $siswa->agama,
            $siswa->tanggal_lahir
        ];
    }



    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 20,
    //         'B' => 20,
    //         'C' => 20,
    //         'D' => 20,
    //         'E' => 20,
    //         'F' => 20,
    //         'G' => 50,
    //         'H' => 50,
    //         'I' => 50,
    //         'J' => 50,
    //         'K' => 50,
    //     ];
    // }



    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            'A1:K1'    => ['font' => ['bold' => true]],
        ];
    }
}
