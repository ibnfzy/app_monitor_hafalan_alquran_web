<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OperatorController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('operator/index', [
            'data' => $this->db->table('guru')->orderBy('id_guru', 'DESC')->get()->getResultArray()
        ]);
    }

    public function guru_insert()
    {
        $rules = [
            'nip' => [
                'rules' => 'required|is_unique[guru.nip]',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong',
                    'is_unique' => 'NIP sudah terdaftar'
                ]
            ],
            'nama_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('guru')->insert([
            'nip' => $this->request->getPost('nip'),
            'nama_guru' => $this->request->getPost('nama_guru'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'success')
            ->with('message', 'Data berhasil ditambahkan');
    }

    public function guru_update()
    {
        $rules = [
            'id_guru' => [
                'rules' => 'required',
            ],
            'nip' => [
                'rules' => 'required|is_unique[guru.nip, id_guru, {id_guru}]',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong'
                ]
            ],
            'nama_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('guru')->where('id_guru', $this->request->getPost('id_guru'))->update([
            'nip' => $this->request->getPost('nip'),
            'nama_guru' => $this->request->getPost('nama_guru'),
        ]);

        if ($this->request->getPost('password')) {
            $this->db->table('guru')->where('id_guru', $this->request->getPost('id_guru'))->update([
                'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            ]);
        }

        return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'success')
            ->with('message', 'Data berhasil diupdate');
    }

    public function guru_delete($id)
    {
        $this->db->table('guru')->where('id_guru', $id)->delete();
        return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'success')
            ->with('message', 'Data berhasil dihapus');
    }

    public function kelas()
    {
        return view('operator/kelas', [
            'data' => $this->db->table('kelas')->join('guru', 'guru.id_guru = kelas.id_guru', 'left')->orderBy('id_kelas', 'DESC')->get()->getResultArray(),
            'guru' => $this->db->table('guru')->orderBy('id_guru', 'DESC')->get()->getResultArray()
        ]);
    }

    public function kelas_insert()
    {
        $rules = [
            'nama_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'id_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Guru tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Kelas'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('kelas')->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_guru' => $this->request->getPost('id_guru')
        ]);

        return redirect()->to(base_url('OperatorPanel/Kelas'))->with('type-status', 'success')
            ->with('message', 'Data berhasil ditambahkan');
    }

    public function kelas_update()
    {
        $rules = [
            'id_kelas' => [
                'rules' => 'required',
            ],
            'nama_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'id_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Guru tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Kelas'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('kelas')->where('id_kelas', $this->request->getPost('id_kelas'))->update([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_guru' => $this->request->getPost('id_guru')
        ]);

        return redirect()->to(base_url('OperatorPanel/Kelas'))->with('type-status', 'success')
            ->with('message', 'Data berhasil diupdate');
    }

    public function kelas_delete($id)
    {
        $this->db->table('kelas')->where('id_kelas', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Kelas'))->with('type-status', 'success')
            ->with('message', 'Data berhasil dihapus');
    }

    public function siswa()
    {
        return view('operator/siswa', [
            'data' => $this->db->table('siswa')->orderBy('id_siswa', 'DESC')->get()->getResultArray(),
            'kelas' => $this->db->table('kelas')->orderBy('id_kelas', 'DESC')->get()->getResultArray()
        ]);
    }

    public function siswa_insert()
    {
        $rules = [
            'nisn' => [
                'rules' => 'required|is_unique[siswa.nisn]',
                'errors' => [
                    'required' => 'NISn tidak boleh kosong',
                    'is_unique' => 'NISn sudah terdaftar'
                ]
            ],
            'nama_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'id_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Siswa'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getKelas = $this->db->table('kelas')->where('id_kelas', $this->request->getPost('id_kelas'))->get()->getRowArray();

        $this->db->table('siswa')->insert([
            'nisn' => $this->request->getPost('nisn'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'nama_kelas' => $getKelas['nama_kelas'],
        ]);

        return redirect()->to(base_url('OperatorPanel/Siswa'))->with('type-status', 'success')
            ->with('message', 'Data berhasil ditambahkan');
    }

    public function siswa_update()
    {
        $rules = [
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID siswa tidak boleh kosong'
                ]
            ],
            'nisn' => [
                'rules' => 'required|is_unique[siswa.nisn, id_siswa, {id_siswa}]',
                'errors' => [
                    'required' => 'NISn tidak boleh kosong',
                    'is_unique' => 'NISn sudah terdaftar'
                ]
            ],
            'nama_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'id_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Siswa'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getKelas = $this->db->table('kelas')->where('id_kelas', $this->request->getPost('id_kelas'))->get()->getRowArray();

        $this->db->table('siswa')->where('id_siswa', $this->request->getPost('id_siswa'))->update([
            'nisn' => $this->request->getPost('nisn'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'nama_kelas' => $getKelas['nama_kelas'],
        ]);

        return redirect()->to(base_url('OperatorPanel/Siswa'))->with('type-status', 'success')
            ->with('message', 'Data berhasil diupdate');
    }

    public function siswa_delete($id)
    {
        $this->db->table('siswa')->where('id_siswa', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Siswa'))->with('type-status', 'success')
            ->with('message', 'Data berhasil dihapus');
    }

    public function operator()
    {
        return view('operator/operator', [
            'data' => $this->db->table('operator')->orderBy('id_operator', 'DESC')->get()->getResultArray()
        ]);
    }

    public function operator_insert()
    {
        $rules = [
            'username' => [
                'rules' => 'required|is_unique[operator.username]',
                'errors' => [
                    'required' => 'Username tidak boleh kosong',
                    'is_unique' => 'Username sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Operator'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('operator')->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to(base_url('OperatorPanel/Operator'))->with('type-status', 'success')
            ->with('message', 'Data berhasil ditambahkan');
    }

    public function operator_update()
    {
        $rules = [
            'id_operator' => [
                'rules' => 'required',
            ],
            'username' => [
                'rules' => 'required|is_unique[operator.username, id_operator, {id_operator}]',
                'errors' => [
                    'required' => 'Username tidak boleh kosong'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Operator'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('operator')->where('id_operator', $this->request->getPost('id_operator'))->update([
            'username' => $this->request->getPost('username'),
        ]);

        if ($this->request->getPost('password') != '') {
            $this->db->table('operator')->where('id_operator', $this->request->getPost('id_operator'))->update([
                'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            ]);
        }

        return redirect()->to(base_url('OperatorPanel/Operator'))->with('type-status', 'success')
            ->with('message', 'Data berhasil diupdate');
    }

    public function operator_delete($id)
    {
        $this->db->table('operator')->where('id_operator', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Operator'))->with('type-status', 'success')
            ->with('message', 'Data berhasil dihapus');
    }

    public function alquran()
    {
        return view('operator/alquran', [
            'data' => $this->db->table('al_quran_surah')->get()->getResultArray()
        ]);
    }
}