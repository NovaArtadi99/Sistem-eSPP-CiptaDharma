<?php

namespace Database\Seeders;

use App\Models\Biaya;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahun = ['2019', '2020', '2021', '2022', '2023', '2024'];
        $level = [];

        for ($i = 1; $i <= 6; $i++) {
            foreach (range('A', 'E') as $huruf) {
                array_push($level, $i . $huruf);
            }
        }
        Biaya::create([
            'nama_biaya' => 'SPP',
            'nominal' => rand(10000, 200000),
            'nama_nominal' => 'SPP',
            'tahun' => $tahun[array_rand($tahun)],
            'bulan' => $bulan[array_rand($bulan)],
            'level' => $level[array_rand($level)],
        ]);
        Biaya::create([
            'nama_biaya' => 'Uang Bangunan',
            'nominal' => rand(10000, 200000),
            'nama_nominal' => 'Uang Bangunan',
            'tahun' => $tahun[array_rand($tahun)],
            'bulan' => $bulan[array_rand($bulan)],
            'level' => $level[array_rand($level)],
        ]);
        Biaya::create([
            'nama_biaya' => 'Uang Kegiatan',
            'nominal' => rand(10000, 200000),
            'nama_nominal' => 'Uang Kegiatan',
            'tahun' => $tahun[array_rand($tahun)],
            'bulan' => $bulan[array_rand($bulan)],
            'level' => $level[array_rand($level)],
        ]);
        Biaya::create([
            'nama_biaya' => 'Uang Lain-Lain',
            'nominal' => rand(10000, 200000),
            'nama_nominal' => 'Uang Lain-Lain',
            'tahun' => $tahun[array_rand($tahun)],
            'bulan' => $bulan[array_rand($bulan)],
            'level' => $level[array_rand($level)],
        ]);

        for ($i=0; $i < 30; $i++) {
            Biaya::create([
                'nama_biaya' => 'Uang Kegiatan ' . $i,
                'nominal' => rand(10000, 200000),
                'nama_nominal' => 'Uang Kegiatan ' . $i,
                'tahun' => $tahun[array_rand($tahun)],
                'bulan' => $bulan[array_rand($bulan)],
                'level' => $level[array_rand($level)],
            ]);
            Biaya::create([
                'nama_biaya' => 'Uang Lain-Lain ' . $i,
                'nominal' => rand(10000, 200000),
                'nama_nominal' => 'Uang Lain-Lain ' . $i,
                'tahun' => $tahun[array_rand($tahun)],
                'bulan' => $bulan[array_rand($bulan)],
                'level' => $level[array_rand($level)],
            ]);
        }
    }
}
