<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Halaqoh extends Seeder
{
    public function run()
    {
        $this->db->table('halaqoh')->insertBatch([
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Abu bakar Ash-Shiddiq'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Ali bin Abi Thalib'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Umar bin Khattab'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Utsman bin Affan'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Mus\'ab bin Umair'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Zaid bin Tsabit 1'
            ],
            [
                'id_guru' => rand(1, 2),
                'halaqoh' => 'Zaid bin Tsabit 2'
            ],
        ]);
    }
}