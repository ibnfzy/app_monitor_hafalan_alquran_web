<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
                'default' => '1'
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'nama_kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ]
        ]);

        $this->forge->addKey('id_kelas', true);

        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}
