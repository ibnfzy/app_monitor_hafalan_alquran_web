<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Semester extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     'id_semester' => [
        //         'type' => 'INT',
        //         'auto_increment' => true
        //     ],
        //     'semester' => [
        //         'type' => 'VARCHAR',
        //         'constraint' => 1,
        //         'default' => '1'
        //     ],
        //     'tahun_ajaran' => [
        //         'type' => 'VARCHAR',
        //         'constraint' => 10
        //     ],
        //     'is_semester_berjalan' => [
        //         'type' => 'TINYINT',
        //         'constraint' => 1,
        //     ]
        // ]);

        // $this->forge->addKey('id_semester', true);

        // $this->forge->createTable('semester');
    }

    public function down()
    {
        // $this->forge->dropTable('semester');
    }
}
