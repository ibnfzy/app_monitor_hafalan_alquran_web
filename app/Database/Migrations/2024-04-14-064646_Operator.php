<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Operator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_operator' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'password' => [
                'type' => 'TEXT'
            ],
            'nomor_wa' => [
                'type' => 'VARCHAR',
                'constraint' => 13
            ],
            'nama_operator' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ]
        ]);

        $this->forge->addKey('id_operator', true);

        $this->forge->createTable('operator');
    }

    public function down()
    {
        $this->forge->dropTable('operator');
    }
}
