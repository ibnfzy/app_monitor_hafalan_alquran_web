<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kelas extends Seeder
{
    public function run()
    {
        $this->db->table('kelas')->insertBatch([
            [
                'nama_kelas' => '1',
                'semester' => '1',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nama_kelas' => '2',
                'semester' => '1',
                'tahun_ajaran' => '2024/2025',
            ]
        ]);
    }
}