<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absensi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_absensi' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_siswa' => [
                'type' => 'INT'
            ],
            'id_guru' => [
                'type' => 'INT'
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'id_kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'tanggal' => [
                'type' => 'DATE'
            ]
        ]);

        $this->forge->addKey('id_absensi', true);

        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}