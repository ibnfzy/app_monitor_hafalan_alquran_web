<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemesterAktif extends Seeder
{
    public function run()
    {
        $this->db->table('semester')->insert([
            'semester' => '1',
            'tahun_ajaran' => '2024/2025',
            'is_semester_berjalan' => 1
        ]);
    }
}
