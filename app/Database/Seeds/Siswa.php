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
            $data = [
                'id_kelas' => rand(1, 2), // Ganti 10 dengan jumlah kelas yang tersedia
                'kelas' => 'Kelas ' . rand(1, 2), // Ganti 5 dengan jumlah kelas yang tersedia
                'nisn' => rand(1000000000, 9999999999),
                'nama_siswa' => $faker->firstName()
            ];

            $this->db->table('siswa')->insert($data);
        }
    }
}
