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
                'siswa' => $this->db->table('siswa')->join('halaqoh', 'halaqoh.id_halaqoh = siswa.id_halaqoh')->where('nisn', $nisn)->get()->getRowArray(),
                'total_hafalan_berhasil' => $this->db->table('hafalan')->where('nisn', $nisn)->where('keterangan', 'lulus')->countAllResults(),
                'total_kehadiran' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'Hadir')->countAllResults(),
                'total_alfa' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'Alpa')->countAllResults(),
                'total_izin' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'Izin')->countAllResults(),
                'total_sakit' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'Sakit')->countAllResults(),
                'total_tanpa_keterangan' => $this->db->table('absensi')->where('nisn', $nisn)->where('keterangan', 'Tanpa Keterangan')->countAllResults()
            ]
        ]);
    }

    public function absensi_siswa($nisn)
    {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'absensi_siswa' => $this->db->table('absensi')->select('absensi.*, guru.id_guru, guru.nama_guru')->join('guru', 'guru.id_guru = absensi.id_guru')->where('nisn', $nisn)->get()->getResultArray()
            ]
        ]);
    }

    public function informasi_guru($nisn)
    {
        $getSiswa = $this->db->table('siswa')->where('nisn', $nisn)->get()->getRowArray();

        $getHalaqoh = $this->db->table('halaqoh')->where('id_halaqoh', $getSiswa['id_halaqoh'])->get()->getRowArray();

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'guru' => $this->db->table('guru')->where('id_guru', $getHalaqoh['id_guru'])->get()->getRowArray(),
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

    public function webview_blobpdf($id_rekap_nilai)
    {
        $data = $this->db->table('rekap_nilai')->where('id_rekap_nilai', $id_rekap_nilai)->get()->getRowArray();

        echo "<iframe style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; border: none;' src='/uploads/" . $data['blob_pdf'] . "'></iframe>";
    }

    public function rekap_nilai($nisn)
    {
        $getSiswa = $this->db->table('siswa')->where('nisn', $nisn)->get()->getRowArray();
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'rekap_nilai' => $this->db->table('rekap_nilai')->where('id_siswa', $getSiswa['id_siswa'])->orderBy('id_rekap_nilai', 'DESC')->get()->getResultArray()
            ]
        ]);
    }
}
