<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswa' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_kelas' => [
                'type' => 'INT'
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => '10'
            ],
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'halaqoh' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
        ]);

        $this->forge->addKey('id_siswa', true);

        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}