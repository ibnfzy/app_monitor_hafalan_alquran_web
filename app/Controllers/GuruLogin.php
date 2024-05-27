<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GuruLogin extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('login/guru');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = (string)  $this->request->getPost('password');

        $check = $this->db->table('guru')->where('id_unique_guru', $username)->get()->getRowArray();

        if ($check) {
            $verify = password_verify($password, $check['password']);

            if ($verify) {
                session()->set([
                    'id_guru' => $check['id_guru'],
                    'nama_guru' => $check['nama_guru'],
                    'id_unique_guru' => $check['id_unique_guru'],
                    'guru_logged_in' => true
                ]);

                return redirect()->to(base_url('GuruPanel'))->with('type-status', 'info')
                    ->with('message', 'Selamat Datang Kembali ' . $check['nama_guru']);
            }

            return redirect()->to(base_url('Login/Guru'))->with('type-status', 'error')
                ->with('message', 'Maaf password yang dimasukkan salah!');
        }

        return redirect()->to(base_url('Login/Guru'))->with('type-status', 'error')
            ->with('message', 'Maaf ID Guru tidak terdaftar, silahkan hubungi operator!');
    }

    public function logoff()
    {
        session()->set('guru_logged_in', false);

        return redirect()->to(base_url('Login/Guru'))->with('type-status', 'info')
            ->with('message', 'Berhasil keluar');
    }
}
