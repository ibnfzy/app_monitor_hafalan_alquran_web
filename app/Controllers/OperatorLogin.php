<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OperatorLogin extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('login/operator');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = (string)  $this->request->getPost('password');

        $check = $this->db->table('operator')->where('username', $username)->get()->getRowArray();

        if ($check) {
            $verify = password_verify($password, $check['password']);

            if ($verify) {
                session()->set([
                    'id_operator' => $check['id_operator'],
                    'username' => $check['username'],
                    'operator_logged_in' => true
                ]);

                return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'info')
                    ->with('message', 'Selamat Datang Kembali ' . $check['username']);
            }

            return redirect()->to(base_url('Login/Operator'))->with('type-status', 'error')
                ->with('message', 'Maaf password yang dimasukkan salah!');
        }

        return redirect()->to(base_url('Login/Operator'))->with('type-status', 'error')
            ->with('message', 'Maaf username tidak terdaftar, silahkan hubungi operator!');
    }

    public function logoff()
    {
        session()->set('operator_logged_in', false);

        return redirect()->to(base_url('Login/Operator'))->with('type-status', 'info')
            ->with('message', 'Berhasil keluar');
    }
}
