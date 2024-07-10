<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        return view('web/home', [
            'data' => $this->db->table('corousel')->get()->getResultArray()
        ]);
    }

    public function notonline()
    {
        return view('errors/html/mt');
    }

    public function new_home()
    {
        return view('web/new_home');
    }

    public function kegiatan()
    {
        return view('web/kegiatan', [
            'data' => $this->db->table('kegiatan')->get()->getResultArray()
        ]);
    }

    public function kegiatan_detail($id)
    {
        return view('web/kegiatan-detail', [
            'data' => $this->db->table('kegiatan')->getWhere(['id_kegiatan' => $id])->getRowArray(),
            'kegiatan' => $this->db->table('kegiatan')->orderBy('id_kegiatan', 'RANDOM')->get(4)->getResultArray()
        ]);
    }

    public function registrasi()
    {
        return view('web/registrasi', [
            'dataOperator' => $this->db->table('operator')->select('nama_operator, nomor_wa')->get()->getResultArray()
        ]);
    }

    public function registrasi_save()
    {
        $rules = [
            'nik' => [
                'rules' => 'required|is_unique[orang_tua.nik]',
                'errors' => [
                    'required' => 'NIK tidak boleh kosong',
                    'is_unique' => 'NIK sudah terdaftar'
                ]
            ],
            'nisn' => [
                'rules' => 'required|is_unique[orang_tua.nisn_anak]|',
                'errors' => [
                    'required' => 'NISN tidak boleh kosong',
                    'is_unique' => 'Akun Orang Tua sudah terdaftar, silahkan hubungi operator'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong'
                ]
            ],
            'nama' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong',
                    'max_length' => 'Nama terlalu panjang'
                ]
            ]
        ];

        $checkNisnExist = $this->db->table('siswa')->getWhere(['nisn' => $this->request->getPost('nisn')])->getResultArray();

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('Registrasi'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        if (empty($checkNisnExist)) {
            return redirect()->to(base_url('Registrasi'))->with('type-status', 'error')->with('message', 'NISN tidak terdaftar, silahkan hubungi operator');
        }

        $this->db->table('orang_tua')->insert([
            'nik' => $this->request->getPost('nik'),
            'nisn_anak' => $this->request->getPost('nisn'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            'nama_orang_tua' => $this->request->getPost('nama')
        ]);

        return redirect()->to(base_url('Registrasi'))->with('type-status', 'success')->with('message', 'Registrasi Berhasil, silahkan menunggu operator memvalidasi akun anda');
    }
}
