<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Guru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_guru' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 18
            ],
            'nama_guru' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'password' => [
                'type' => 'TEXT'
            ],
            'kontak' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'default' => 'users.png',
                'constraint' => 255
            ],
            'halaqoh' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ]
        ]);

        $this->forge->addKey('id_guru', true);

        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}