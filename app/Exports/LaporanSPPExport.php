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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class LaporanSPPExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{

    private $counter = 0;

    use Exportable;
    protected $tahun;
    protected $bulan;
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tahun = null, $bulan = null, $tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        $tagihan = Tagihan::with('siswa')->where('status', 'Lunas');
        if ($this->tahun) {
            $tagihan->where('tahun', $this->tahun);
        }

        if ($this->bulan) {
            $tagihan->where('bulan', $this->bulan);
        }

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $tagihan->whereBetween('tanggal_lunas', [$this->tanggalAwal, $this->tanggalAkhir]);
        }

        return $tagihan->get();
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

    public function map($tagihan): array
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
            'A2:M2'    => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFD700',
                    ],
                ],
            ],
            'A1' => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->setCellValue('A1', 'Laporan Data Spp');
            },
        ];
    }
}
