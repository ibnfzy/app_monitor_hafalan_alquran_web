<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Corousel extends Seeder
{
    public function run()
    {
        $this->db->table('corousel')->insertBatch([
            [
                'gambar' => 'slide-1.jpg',
            ],
            [
                'gambar' => 'slide-2.jpg',
            ]
        ]);
    }
}