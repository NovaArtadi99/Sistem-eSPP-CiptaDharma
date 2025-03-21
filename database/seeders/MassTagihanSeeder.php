<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biaya;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MassTagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereIn('id',[3,4,5,6,7])->pluck('id')->toArray();
        // $user = [3];
        $tahun = ['2019', '2020', '2021', '2022', '2023', '2024'];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $biaya = Biaya::pluck('id')->toArray();
        $buktiLunas = [null, 'Ada'];
        $namaInvoice = ['Tagihan','Pembayaran','SPP','Bimbingan'];
        $status = ['Belum Lunas','Sedang Diverifikasi','Lunas'];
        $userInternal = [1,2];
        $statusKuitansi = ['0','1'];
        for ($i = 1; $i <= 100; $i++) {
            // $namaInvoice = 'Tagihan Bulanan ' . $i;
            $noInvoice = 'INV' . sprintf('%03d', $i);
            $tagihan = Tagihan::insert([
                'no_invoice' => $noInvoice,
                'keterangan' => $namaInvoice[array_rand($namaInvoice)].' '.$i,
                'user_id' => $user[array_rand($user)],
                'biaya_id' => $biaya[array_rand($biaya)],
                'bulan' => $bulan[array_rand($bulan)],
                'tahun' => $tahun[array_rand($tahun)],
                'tanggal_terbit' => \Carbon\Carbon::createFromTimestamp(rand(strtotime('2015-01-01'), strtotime('2025-12-31'))),
                'tanggal_lunas' => \Carbon\Carbon::createFromTimestamp(rand(strtotime('2015-01-01'), strtotime('2025-12-31'))),
                'user_penerbit_id' =>$userInternal[array_rand($userInternal)],
                'user_melunasi_id' => $userInternal[array_rand($userInternal)],
                'bukti_pelunasan' => $buktiLunas[array_rand($buktiLunas)],
                'created_at' => \Carbon\Carbon::now(),
                'status' => $status[array_rand($status)],
                'isSentKuitansi' => $statusKuitansi[array_rand($statusKuitansi)],
            ]);

        }
    }
}
