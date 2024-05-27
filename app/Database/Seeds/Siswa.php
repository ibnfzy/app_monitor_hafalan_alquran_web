<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Siswa extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 200; $i++) {
            $nisn = rand(1000000000, 9999999999);

            $data = [
                'id_kelas' => rand(1, 2), // Ganti 10 dengan jumlah kelas yang tersedia
                'kelas' => rand(1, 2), // Ganti 5 dengan jumlah kelas yang tersedia
                'nisn' => $nisn,
                'nama_siswa' => $faker->firstName(),
                'id_halaqoh' => rand(1, 7),
            ];

            $dataOrangTua = [
                'nisn_anak' => $nisn,
                'nama_orang_tua' => $faker->firstName(),
                'password' => password_hash('123456', PASSWORD_DEFAULT)
            ];

            $this->db->table('siswa')->insert($data);
            $this->db->table('orang_tua')->insert($dataOrangTua);
        }
    }
}