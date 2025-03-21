<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Petugas']);
        Role::create(['name' => 'KepalaSekolah']);
        Role::create(['name' => 'SiswaOrangTua']);


        $adminPermissions =
            [
                'dashboard',
                'siswa-index',
                'siswa-create',
                'siswa-edit',
                'siswa-delete',
                'biaya-index',
                'biaya-create',
                'biaya-edit',
                'biaya-delete',
                'tagihan-index',
                'tagihan-create',
                'tagihan-edit',
                'tagihan-delete',
                'download-kwitansi',
                'history-tagihan',
                'pembayaran-tagihan',
                'bayar-tagihan',
            ];

        $kepalaSekolahPermissions =
        [
            'dashboard',
            'history-tagihan',

        ];

        $siswaOrangTuaPermissions =
        [
            'dashboard',
            'download-kwitansi',
            'bayar-tagihan',
            'history-tagihan',

        ];

        $adminRole = Role::where('name', 'Petugas')->first();
        $adminRole->syncPermissions($adminPermissions);

        $kepsekRole = Role::where('name', 'KepalaSekolah')->first();
        $kepsekRole->syncPermissions($kepalaSekolahPermissions);

        $siswaOrangTuaRole = Role::where('name', 'SiswaOrangTua')->first();
        $siswaOrangTuaRole->syncPermissions($siswaOrangTuaPermissions);
    }
}
