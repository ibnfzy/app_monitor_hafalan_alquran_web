<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Operator extends Seeder
{
    public function run()
    {
        $this->db->table('operator')->insert([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'nomor_wa' => '6285241275696',
            'nama_operator' => 'Rini',
        ]);
    }
}
