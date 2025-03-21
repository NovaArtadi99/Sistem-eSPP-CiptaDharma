<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [

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

        foreach ($modules as $module => $permissions) {
            Permission::create([
                'name' => $permissions,
                'guard_name' => 'web',
            ]);
        }
    }
}
