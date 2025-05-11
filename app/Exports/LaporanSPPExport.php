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
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
            'A5:M5' => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD700'],
                ],
            ],
            'A1' => ['font' => ['bold' => true, 'size' => 14]],
            'A2' => ['font' => ['bold' => true, 'size' => 14]],
            'A3' => ['font' => ['bold' => true, 'size' => 14]],
            'A4' => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set judul utama
                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'Pemerintah Provinsi Bali');

                $sheet->mergeCells('A2:M2');
                $sheet->setCellValue('A2', 'SD CHIPTA DHARMA');

                $sheet->mergeCells('A3:M3');
                $sheet->setCellValue('A3', 'Laporan Data SPP');

                $periode = 'Periode : ';
                if ($this->bulan && $this->tahun) {
                    $periode .= $this->bulan . ' ' . $this->tahun;
                } elseif ($this->tahun) {
                    $periode .= $this->tahun;
                } else {
                    $periode .= '-';
                }

                $sheet->mergeCells('A4:B4');
                $sheet->setCellValue('A4', $periode);

                // Atur rata tengah dan bold
                foreach (['A1', 'A2', 'A3'] as $cell) {
                    $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(14);
                    $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $sheet->getStyle('A4')->getFont()->setBold(true);
            },
        ];
    }

}
