<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Hafalan extends Seeder
{
    public function run()
    {
        $getSiswaFirstRow = $this->db->table('siswa')->get()->getRowArray();
        $getKelas = $this->db->table('kelas')->where('id_kelas', $getSiswaFirstRow['id_kelas'])->get()->getRowArray();
        $getGuru = $this->db->table('guru')->where('id_guru', $getKelas['id_guru'])->get()->getRowArray();

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 1,
            'nama_surah' => 'Al-Fatihah',
            'ayat' => '1 - 7',
            'keterangan' => 'lulus',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 97,
            'nama_surah' => 'Al-Qadr',
            'ayat' => '1 - 5',
            'keterangan' => 'lulus',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'belum lulus',
            'jilid' => 'belum',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'belum lulus',
            'jilid' => 'fasih',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 79,
            'nama_surah' => "An-Nazi'at",
            'ayat' => '1 - 46',
            'keterangan' => 'belum lulus',
            'jilid' => 'belum',
            'murojaah' => 1
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 93,
            'nama_surah' => 'Ad-Duha',
            'ayat' => '1 - 11',
            'keterangan' => 'lulus',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $getSiswaFirstRow['id_siswa'],
            'id_guru' => $getGuru['id_guru'],
            'nisn' => $getSiswaFirstRow['nisn'],
            'nip_guru' => $getGuru['nip'],
            'id_surah' => 79,
            'nama_surah' => "An-Nazi'at",
            'ayat' => '1 - 46',
            'keterangan' => 'lulus',
            'jilid' => 'fasih',
            'murojaah' => 0
        ]);
    }
}
