<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');
        $agama = ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha'];
        $jk = ['Laki-laki', 'Perempuan'];
        $angkatan = [2019, 2020, 2021, 2022, 2023, 2024];
        $kelas = ['1A', '1B', '1C', '1D', '1E', '2A', '2B', '2C', '2D', '2E', '3A', '3B', '3C', '3D', '3E', '4A', '4B', '4C', '4D', '4E', '5A', '5B', '5C', '5D', '5E', '6A', '6B', '6C', '6D', '6E'];


        $admin =  User::create(
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'alamat' => $faker->address,
                'no_telp' => $faker->phoneNumber,
                'jenis_kelamin' => $jk[array_rand($jk)],
                'username' => 'admin',
                'agama' => $agama[array_rand($agama)],
                'nip' => $faker->numberBetween(1000000000, 9999999999),
                'no_telp' => 0 + $faker->numberBetween(1000000000, 9999999999),
            ]
        );

        $admin->assignRole('petugas');

        $kepsek = User::create(
            [
                'nama' => 'Kepsek',
                'email' => 'kepsek@gmail.com',
                'password' => bcrypt('password'),
                'alamat' => $faker->address,
                'no_telp' => $faker->phoneNumber,
                'jenis_kelamin' => $jk[array_rand($jk)],
                'username' => 'kepsek',
                'agama' => $agama[array_rand($agama)],
                'nip' => $faker->numberBetween(1000000000, 9999999999),
                'no_telp' => 0 + $faker->numberBetween(1000000000, 9999999999),

            ]
        );

        $kepsek->assignRole('KepalaSekolah');


        $jk = ['Laki-laki', 'Perempuan'];
        for ($i = 1; $i < 30; $i++) {
            $user = User::create(
                [
                    'nama' => $faker->unique()->name('female' | 'male'),
                    'email' => 'user' . $i . '@gmail.com',
                    'username' => 'username' . $i,
                    'agama' => $agama[array_rand($agama)],
                    'nis' => $faker->unique()->numerify('######'),
                    'nisn' => $faker->unique()->numerify('##########'),
                    'jenis_kelamin' => $jk[array_rand($jk)],
                    'password' => bcrypt('password'),
                    'nama_wali' => $faker->name,
                    'alamat' => $faker->address,
                    'no_telp' => $faker->phoneNumber,
                    'angkatan' => $angkatan[array_rand($angkatan)],
                    'kelas' => $kelas[array_rand($kelas)],
                    'id_telegram' => null,
                    'created_at' => now(),
                    'tanggal_lahir' => $faker->dateTimeBetween('2000-01-01', '2020-12-31'),
                ]
            );

            $user->assignRole('SiswaOrangTua');
        }
    }
}
