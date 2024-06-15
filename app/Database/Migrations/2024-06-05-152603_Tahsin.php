<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Tahsin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahsin' => [
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
            'halaman' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'jilid' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'tanggal_tahsin' => [
                'type' => 'DATE'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('(CURRENT_TIMESTAMP)')
            ]
        ]);

        $this->forge->addKey('id_tahsin', true);
        $this->forge->createTable('tahsin');
    }

    public function down()
    {
        $this->forge->dropTable('tahsin');
    }
}
