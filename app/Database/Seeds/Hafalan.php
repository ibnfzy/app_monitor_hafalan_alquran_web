<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Hafalan extends Seeder
{
    public function run()
    {
        $getSiswaFirstRow = $this->db->table('siswa')->where('id_kelas', 2)->get()->getRowArray();
        $getHalaqoh = $this->db->table('halaqoh')->where('id_halaqoh', $getSiswaFirstRow['id_halaqoh'])->get()->getRowArray();
        $getGuru = $this->db->table('guru')->where('id_guru', $getHalaqoh['id_guru'])->get()->getRowArray();

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 1,
            'nama_surah' => 'Al-Fatihah',
            'ayat' => '1 - 7',
            'keterangan' => 'hafal',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 97,
            'nama_surah' => 'Al-Qadr',
            'ayat' => '1 - 5',
            'keterangan' => 'hafal',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'belum hafal',
            'jilid' => 'belum',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'belum hafal',
            'jilid' => 'fasih',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 79,
            'nama_surah' => "An-Nazi'at",
            'ayat' => '1 - 46',
            'keterangan' => 'belum hafal',
            'jilid' => 'belum',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'hafal',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'id_surah' => 79,
            'nama_surah' => "An-Nazi'at",
            'ayat' => '1 - 46',
            'keterangan' => 'hafal',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);
    }
}