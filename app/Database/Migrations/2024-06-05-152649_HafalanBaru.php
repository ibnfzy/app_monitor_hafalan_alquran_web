<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class HafalanBaru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hafalan_baru' => [
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
            'surah' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ayat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tanggal_hafalan_baru' => [
                'type' => 'DATE'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('(CURRENT_TIMESTAMP)')
            ],
        ]);

        $this->forge->addKey('id_hafalan_baru', true);
        $this->forge->createTable('hafalan_baru');
    }

    public function down()
    {
        $this->forge->dropTable('hafalan_baru');
    }
}
