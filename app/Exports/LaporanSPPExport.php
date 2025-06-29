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
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanSPPExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{

    private array $fields;
    private $counter = 0;

    use Exportable;
    protected $tahun;
    protected $bulan;
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $stts;
    protected $kelas;


    public function __construct($tahun = null, $bulan = null, $tanggalAwal = null, $tanggalAkhir = null, array $fields = [], $stts = null, $kelas = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->fields = $fields ?: ['NoInvoice', 'NIS', 'NamaSiswa', 'Kelas', 'Bulan', 'Tahun'];
        $this->stts = $stts;
        $this->kelas = $kelas;
    }
    
    protected function fieldMap(): array
    {
        return [
            'NoInvoice'     => ['No Invoice',   fn($t) => $t->no_invoice],
            'NIS'           => ['NIS',          fn($t) => $t->siswa->nis],
            'NamaSiswa'     => ['Nama Siswa',   fn($t) => $t->siswa->nama],
            'Kelas'         => ['Kelas',        fn($t) => $t->siswa->kelas],
            'Bulan'         => ['Bulan',        fn($t) => $t->bulan],
            'Tahun'         => ['Tahun',        fn($t) => $t->tahun],
            'TotalBayar'    => ['Total Bayar',  fn($t) => 'Rp. ' . number_format($t->biaya->nominal, 0, ',', '.')],
            'TanggalTerbit' => ['Tanggal Terbit', fn($t) => $t->tanggal_terbit],
            'TanggalLunas'  => ['Tanggal Lunas', fn($t) => $t->tanggal_lunas],
            'AdminPenerbit' => ['Admin Penerbit', fn($t) => $t->penerbit->nama ?? '-'],
            'UserMelunasi'  => ['User Melunasi', fn($t) => $t->melunasi->nama ?? '-'],
            'Status'        => ['Status',        fn($t) => $t->status],
        ];
    }


    public function collection()
    {
        $query = Tagihan::with(['siswa', 'biaya', 'penerbit', 'melunasi']);

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        if ($this->bulan) {
            $query->where('bulan', $this->bulan);
        }

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal_lunas', [$this->tanggalAwal, $this->tanggalAkhir]);
        }
        if ($this->stts) {
            $query->where('status', $this->stts);
        }
        if ($this->kelas) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas', $this->kelas);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        $heading = ['#'];
        $fieldMap = $this->fieldMap();

        foreach ($this->fields as $field) {
            if (isset($fieldMap[$field])) {
                $heading[] = $fieldMap[$field][0];
            }
        }
        return $heading;
    }

    public function map($tagihan): array
    {
        $row = [++$this->counter];
        $fieldMap = $this->fieldMap();

        foreach ($this->fields as $field) {
            if (isset($fieldMap[$field])) {
                $row[] = ($fieldMap[$field][1])($tagihan); // panggil closure
            }
        }
        return $row;
    }

    protected function getLastColumnLetter(): string
    {
        $totalColumns = count($this->fields) + 1;

        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumns);
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $this->getLastColumnLetter();
        return [
            "A5:{$lastCol}5" => [
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
                $lastCol = $this->getLastColumnLetter();

                // Header
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue('A1', 'Pemerintah Provinsi Bali');

                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->setCellValue('A2', 'SD CHIPTA DHARMA');

                $sheet->mergeCells("A3:{$lastCol}3");
                $sheet->setCellValue('A3', 'Laporan Pembayaran SPP Siswa');

                $periode = 'Periode : ';
                if ($this->bulan && $this->tahun) {
                    $periode .= $this->bulan . ' ' . $this->tahun;
                } elseif ($this->tahun) {
                    $periode .= $this->tahun;
                } else {
                    $periode .= '-';
                }

                $sheet->mergeCells("A4:B4");
                $sheet->setCellValue('A4', $periode);

                foreach (['A1', 'A2', 'A3'] as $cell) {
                    $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(14);
                    $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $sheet->getStyle('A4')->getFont()->setBold(true);

                // Logo Sekolah
                $logoPath = public_path('logo_sekolah.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo Sekolah');
                    $drawing->setPath($logoPath);
                    $drawing->setHeight(80);
                    $drawing->setCoordinates('A1');
                    $drawing->setWorksheet($sheet);
                }
            },

            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastCol = $this->getLastColumnLetter();

                // Hitung baris paling bawah dari data
                $lastRow = $sheet->getHighestRow() + 3;

                // Buat cell tanda tangan
                $sheet->mergeCells("{$lastCol}{$lastRow}:{$lastCol}" . ($lastRow + 2));
                $sheet->setCellValue("{$lastCol}{$lastRow}", "Penanggung Jawab\n\n\n\n(__________________)");

                $sheet->getStyle("{$lastCol}{$lastRow}")
                    ->getAlignment()->setWrapText(true)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

}
