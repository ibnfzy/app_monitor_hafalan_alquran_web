<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Hafalan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hafalan' => [
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
            'nip_guru' => [
                'type' => 'VARCHAR',
                'constraint' => 18
            ],
            'id_surah' => [
                'type' => 'INT',
            ],
            'nama_surah' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'ayat' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'tanggal_input' => [
                'type' => 'date',
                'default' => new RawSql('(CURRENT_DATE)')
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'jilid' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'murojaah' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ]
        ]);

        $this->forge->addKey('id_hafalan', true);

        $this->forge->createTable('hafalan');
    }

    public function down()
    {
        $this->forge->dropTable('hafalan');
    }
}