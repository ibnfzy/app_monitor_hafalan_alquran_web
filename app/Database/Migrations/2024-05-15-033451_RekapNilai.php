<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RekapNilai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rekap_nilai' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_siswa' => [
                'type' => 'INT',
            ],
            'id_guru'   => [
                'type' => 'INT',
            ],
            'nama_guru' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
            ],
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'halaqoh' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'prestasi_adab_halaqoh' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
            'prestasi_tahsin' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
            'prestasi_tahfidz' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
            'prestasi_murojaah' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
            'nilai_uts' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'nilai_tahsin' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'keterangan_tambahan' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'created_at' => [
                'type' => 'VARCHAR',
                'constraint' => 60
            ],
            'alpa' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'izin' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'sakit' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'blob_pdf' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_rekap_nilai', true);

        $this->forge->createTable('rekap_nilai');
    }

    public function down()
    {
        $this->forge->dropTable('rekap_nilai');
    }
}
