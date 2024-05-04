<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Guru extends Seeder
{
    public function run()
    {
        $this->db->table('guru')->where('id_guru !=', '0')->delete();

        $this->db->table('guru')->insertBatch([
            [
                'nip' => '2134567890',
                'nama_guru' => 'Hendra',
                'password' => password_hash('2134567890', PASSWORD_BCRYPT),
                'kontak' => '081234567890',
                'jenis_kelamin' => 'Laki-laki',
            ],
            [
                'nip' => '1234567890',
                'nama_guru' => 'Jini',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'kontak' => '081234567890',
                'jenis_kelamin' => 'Perempuan',
            ]
        ]);
    }
}