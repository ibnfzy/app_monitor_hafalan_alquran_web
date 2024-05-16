<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kelas extends Seeder
{
    public function run()
    {
        $this->db->table('kelas')->insertBatch([
            [
                'id_guru' => 1,
                'nama_kelas' => 'Kelas 1',
                'semester' => '1',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'id_guru' => 2,
                'nama_kelas' => 'Kelas 2',
                'semester' => '1',
                'tahun_ajaran' => '2024/2025',
            ]
        ]);
    }
}
