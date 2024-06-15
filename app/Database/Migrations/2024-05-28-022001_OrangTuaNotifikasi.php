<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrangTuaNotifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifikasi' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_orang_tua' => [
                'type' => 'INT'
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'body' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(NOW())')
            ]
        ]);

        $this->forge->addKey('id_notifikasi', true);
        $this->forge->createTable('orang_tua_notifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('orang_tua_notifikasi');
    }
}
