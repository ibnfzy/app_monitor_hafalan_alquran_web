<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Halaqoh extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_halaqoh' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_guru' => [
                'type' => 'INT'
            ],
            'halaqoh' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
        ]);

        $this->forge->addKey('id_halaqoh', true);

        $this->forge->createTable('halaqoh');
    }

    public function down()
    {
        $this->forge->dropTable('halaqoh');
    }
}
