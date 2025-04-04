<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanSPPExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize,WithStyles
{

    private $counter = 0;

    use Exportable;

    public function collection()
    {
        $tagihan = Tagihan::with('siswa')->latest()->get();

        return $tagihan;
    }


    public function headings(): array
    {
        return [
            '#',
            'No Invoice',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Bulan',
            'Tahun',
            'Total Bayar',
            'Tanggal Terbit',
            'Tanggal Lunas',
            'Admin Penerbit',
            'User Melunasi',
            'Status',
        ];
    }

    public function map($tagihan) : array
    {
        return [
            ++$this->counter,
            $tagihan->no_invoice,
            $tagihan->siswa->nis,
            $tagihan->siswa->nama,
            $tagihan->siswa->kelas,
            $tagihan->bulan,
            $tagihan->tahun,
            'Rp. ' . number_format($tagihan->biaya->nominal, 0, ',', '.'),
$tagihan->tanggal_terbit,
            $tagihan->tanggal_lunas,
            $tagihan->penerbit->nama ?? '-',
            $tagihan->melunasi->nama ?? '-',
            $tagihan->status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            'A1:M1'    => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFD700',
                    ],
                ],
            ],
        ];
    }
}
