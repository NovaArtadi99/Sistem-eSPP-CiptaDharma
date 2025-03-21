<?php

namespace Database\Seeders;

use DB;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahun = ['2019', '2020', '2021', '2022', '2023', '2024'];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $use = User::pluck('id')->toArray();
        $biaya = Biaya::pluck('id')->toArray();
        $buktiLunas = [null, 'Ada'];
        $namaInvoice = ['Tagihan','Pembayaran','SPP','Bimbingan'];
        for ($i = 1; $i <= 20; $i++) {
            $noInvoice = 'INV' . sprintf('%03d', $i);
            // $namaInvoice = 'Tagihan Bulanan ' . $i;
            $tagihan = Tagihan::insert([
                'no_invoice' => $noInvoice,
                'keterangan' => $namaInvoice[array_rand($namaInvoice)].' '.$i,
                'user_id' => $use[array_rand($use)],
                'biaya_id' => $biaya[array_rand($biaya)],
                'bulan' => $bulan[array_rand($bulan)],
                'tahun' => $tahun[array_rand($tahun)],
                'tanggal_terbit' => \Carbon\Carbon::now(),
                'tanggal_lunas' => null,
                'user_penerbit_id' => 1,
                'bukti_pelunasan' => $buktiLunas[array_rand($buktiLunas)],
                'created_at' => \Carbon\Carbon::now(),

            ]);
        }
    }
}
