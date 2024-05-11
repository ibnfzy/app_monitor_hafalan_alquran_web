<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class API extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function login_orang_tua()
    {
        $check = $this->db->table('orang_tua')->where('nisn_anak', $this->request->getPost('nis'))->get()->getRowArray();

        if ($check) {
            $verify = password_verify((string)$this->request->getPost('password'), $check['password']);

            if ($verify) {
                return $this->response->setJSON([
                    'status' => 200,
                    'message' => 'Login Success',
                    'data' => $check
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 401,
            'message' => 'Login Failed',
            'data' => []
        ]);
    }

    public function informasi_siswa($nisn)
    {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'siswa' => $this->db->table('siswa')->where('nisn', $nisn)->get()->getRowArray(),
                'total_hafalan_berhasil' => $this->db->table('hafalan')->where('nisn', $nisn)->where('keterangan', 'lulus')->countAllResults(),
                'total_kehadiran' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'hadir')->countAllResults(),
                'total_alfa' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'alfa')->countAllResults(),
                'total_izin' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'izin')->countAllResults(),
                'total_sakit' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'sakit')->countAllResults(),
                'total_tanpa_keterangan' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'tanpa_keterangan')->countAllResults()
            ]
        ]);
    }

    public function absensi_siswa($nisn)
    {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'absensi_siswa' => $this->db->table('absensi')->select('keterangan, tanggal')->where('nisn', $nisn)->get()->getResultArray()
            ]
        ]);
    }

    public function informasi_guru($nisn)
    {
        $getSiswa = $this->db->table('siswa')->where('nisn', $nisn)->get()->getRowArray();

        $getKelas = $this->db->table('kelas')->where('id_kelas', $getSiswa['id_kelas'])->get()->getRowArray();

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'guru' => $this->db->table('guru')->where('id_guru', $getKelas['id_guru'])->get()->getRowArray(),
            ]
        ]);
    }

    public function hafalan($nisn)
    {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'hafalan' => $this->db->table('hafalan')->where('nisn', $nisn)->orderBy('id_hafalan', 'DESC')->get()->getResultArray()
            ]
        ]);
    }
}
