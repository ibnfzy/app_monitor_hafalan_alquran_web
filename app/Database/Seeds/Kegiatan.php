<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Kegiatan extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 3; $i++) {
            $this->db->table('kegiatan')->insert([
                'judul' => $faker->sentence(),
                'deskripsi' => $faker->paragraph(5),
                'gambar' => 'bg.jpg'
            ]);
        }
    }
}
