<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $this->call('guru');
        $this->call('operator');
        $this->call('kelas');
        $this->call('siswa');
        $this->call('Hafalan');
        $this->call('Kegiatan');
        $this->call('Corousel');
    }
}