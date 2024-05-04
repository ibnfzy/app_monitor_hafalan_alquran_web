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
}
