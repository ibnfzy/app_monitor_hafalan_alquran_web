<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrangTua extends Seeder
{
    public function run()
    {
        $this->db->table('orang_tua')->insert([
            'nis_anak'
        ]);
    }
}