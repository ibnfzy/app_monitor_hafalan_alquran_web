<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HafalanSiswa extends Seeder
{
    public function run()
    {
        $getSiswaFirstClass = $this->db->table('siswa')->where('id_halaqoh', 1)->get()->getRowArray();

        $getGuru = $this->db->table('halaqoh')->where('id_halaqoh', 1)->get()->getRowArray();

        $this->db->table('tahsin')->insertBatch([
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'halaman' => 'test',
                'jilid' => 'test',
                'keterangan' => 'Hafalan',
                'tanggal_tahsin' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'halaman' => 'test',
                'jilid' => 'test',
                'keterangan' => 'Hafalan',
                'tanggal_tahsin' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'halaman' => 'test',
                'jilid' => 'test',
                'keterangan' => 'Hafalan',
                'tanggal_tahsin' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
        ]);

        $this->db->table('murojaah')->insertBatch([
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Al-Fath',
                'ayat' => '1-8',
                'keterangan' => 'Murojaah',
                'tanggal_murojaah' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Az-Zariyat',
                'ayat' => '1-9',
                'keterangan' => 'Murojaah',
                'tanggal_murojaah' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Al-Hadid',
                'ayat' => '1-5',
                'keterangan' => 'Murojaah',
                'tanggal_murojaah' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Al-Hadid',
                'ayat' => '6-7',
                'keterangan' => 'Murojaah',
                'tanggal_murojaah' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
        ]);

        $this->db->table('hafalan_baru')->insertBatch([
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Al-An\'am',
                'ayat' => '1-5',
                'keterangan' => 'Hafal',
                'tanggal_hafalan_baru' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
            [
                'id_siswa' => $getSiswaFirstClass['id_siswa'],
                'nisn' => $getSiswaFirstClass['nisn'],
                'surah' => 'Al-Anfal',
                'ayat' => '1-3',
                'keterangan' => 'Hafal',
                'tanggal_hafalan_baru' => date('Y-m-d'),
                'id_guru' => $getGuru['id_guru']
            ],
        ]);
    }
}