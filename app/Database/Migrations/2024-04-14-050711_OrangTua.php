<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrangTua extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_orang_tua' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nisn_anak' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'nama_orang_tua' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'password' => [
                'type' => 'TEXT'
            ],
            'token_device' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_orang_tua', true);

        $this->forge->createTable('orang_tua');
    }

    public function down()
    {
        $this->forge->dropTable('orang_tua');
    }
}
