<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TagihanExport implements FromCollection,WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $counter = 0;

    use Exportable;


    public function collection()
    {
        $siswa = Tagihan::select([
            'no_invoice',
            'keterangan',
            'tanggal_terbit',
            'tanggal_lunas',
            'status',
            'user_penerbit_id',
            'user_melunasi_id',
            'biaya_id',
            'user_id',
            'bulan',
            'tahun',
        ])->with(['penerbit','melunasi','biaya','siswa'])->get();

        return $siswa;
    }


    public function headings(): array
    {
        return [
            '#',
            'Keterangan',
            'Tanggal Terbit',
            'Tanggal Lunas',
            'Status',
            'Admin Penerbit',
            'Admin Melunasi',
            'Biaya',
            'Siswa',
            'Bulan',
            'Tahun',
        ];
    }


    public function map($siswa): array
    {
        return [
            ++$this->counter,
            $siswa->keterangan,
            $siswa->tanggal_terbit,
            $siswa->tanggal_lunas,
            $siswa->status,
            $siswa->penerbit->nama,
            $siswa->melunasi->nama ?? '-',
            $siswa->biaya->nama_biaya,
            $siswa->siswa->nama,
            $siswa->bulan,
            $siswa->tahun,
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
