<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\RawSql;
use CodeIgniter\HTTP\ResponseInterface;

class GuruController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        return view('guru/biodata_guru', [
            'dataGuru' => $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray(),
            'data' => $this->db->table('kelas')->join('semester', 'semester.id_semester = kelas.id_semester', 'left')->where('kelas.id_guru', session()->get('id_guru'))->get()->getResultArray(),
            'dataKelasGuru' => $this->db->table('kelas')->where('id_guru', session()->get('id_guru'))->countAllResults(),
            'dataSiswa' => count($this->db->table('siswa')->whereIn('id_kelas', $this->db->table('kelas')->select('id_kelas')->where('id_guru', session()->get('id_guru')))->select('id_siswa')->get()->getResultArray())
        ]);
    }

    public function edit_biodata()
    {
        $rules = [
            'nama_guru' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Tidak boleh kosong',
                    'max_length' => 'Maksimal 250 karakter'
                ]
            ],
            'nip' => [
                'rules' => 'required|max_length[18]',
                'errors' => [
                    'required' => 'Tidak boleh kosong',
                    'max_length' => 'Maksimal 18 karakter'
                ]
            ],
            'kontak' => [
                'rules' => 'required|max_length[15]',
                'errors' => [
                    'required' => 'Tidak boleh kosong',
                    'max_length' => 'Maksimal 15 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->update([
            'nip' => $this->request->getPost('nip'),
            'nama_guru' => $this->request->getPost('nama_guru'),
            'kontak' => $this->request->getPost('kontak')
        ]);

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('dataMessage', 'Data berhasil diubah');
    }

    public function edit_password()
    {
        $rules = [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->update([
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('dataMessage', 'Password berhasil diubah');
    }

    public function edit_foto()
    {
        $rules = [
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded' => 'Tidak ada file yang diupload',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload harus jpg/jpeg/png',
                    'max_size' => 'Ukuran file terlalu besar, maximal 2 MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $file = $this->request->getFile('foto');

        $fileName = $file->getRandomName();

        $file->move(WRITEPATH . 'uploads', $fileName);

        $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->update([
            'foto' => $fileName
        ]);

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('dataMessage', 'Foto profil berhasil diubah');
    }

    public function hafalan($id)
    {
        return view('guru/hafalan', [
            'data' => $this->db->table('siswa')->select('id_siswa, nama_siswa, nisn')->where('id_kelas', $id)->get()->getResultArray(),
            'dataKelas' => $this->db->table('kelas')->where('id_kelas', $id)->get()->getRowArray()
        ]);
    }

    public function hafalan_insert()
    {
        $rules = [
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'nisn_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'surah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'nomor_ayat' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Tidak boleh kosong',
                    'max_length' => 'Maksimal 250 karakter'
                ]
            ],
            'tanggal_input' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Tidak boleh kosong',
                    'max_length' => 'Maksimal 250 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $surah = $this->db->table('al_quran_surah')->where('nomor', $this->request->getPost('surah'))->get()->getRowArray();

        $this->db->table('hafalan')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_guru' => session()->get('id_guru'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'nip_guru' => session()->get('nip'),
            'id_surah' => $this->request->getPost('surah'),
            'nama_surah' => $surah['nama_latin'],
            'ayat' => $this->request->getPost('nomor_ayat'),
            'tanggal_input' => $this->request->getPost('tanggal_input'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Data hafalan berhasil ditambahkan');
    }

    public function hafalan_detail($id)
    {
        return view('guru/hafalan_detail', [
            'data' => $this->db->table('hafalan')->where('id_siswa', $id)->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray()
        ]);
    }

    public function absen($id)
    {
        return view('guru/absensi', [
            'data' => $this->db->table('siswa')->select('id_siswa, nama_siswa, nisn')->where('id_kelas', $id)->get()->getResultArray(),
            'dataKelas' => $this->db->table('kelas')->where('id_kelas', $id)->get()->getRowArray()
        ]);
    }

    public function absensi_proses($id)
    {
        $rules = [
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'absensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel/Absensi/' . $id))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getSiswa = $this->db->table('siswa')->select('nisn')->where('id_siswa', $this->request->getPost('id_siswa'))->get()->getRowArray();

        $this->db->table('absensi')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'keterangan' => $this->request->getPost('absensi'),
            'tanggal' => date('Y-m-d', strtotime((string)$this->request->getPost('tanggal'))),
            'id_kelas' => $id,
            'id_guru' => session()->get('id_guru'),
            'nip' => session()->get('nip'),
            'nisn' => $getSiswa['nisn']
        ]);

        return redirect()->to(base_url('GuruPanel/Absensi/' . $id))->with('type-status', 'success')->with('message', 'Absensi siswa ' . $getSiswa['nisn'] . ' berhasil ditambahkan');
    }

    public function absensi_proses_edit($id)
    {
        $rules = [
            'id_absensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'absensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel/Absensi/' . $id))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getSiswa = $this->db->table('siswa')->select('nisn')->where('id_siswa', $this->request->getPost('id_siswa'))->get()->getRowArray();

        $this->db->table('absensi')
            ->where('id_absensi', $this->request->getPost('id_absensi'))
            ->update([
                'id_siswa' => $this->request->getPost('id_siswa'),
                'keterangan' => $this->request->getPost('absensi'),
                'tanggal' => date('Y-m-d', strtotime((string)$this->request->getPost('tanggal'))),
                'id_kelas' => $id,
                'id_guru' => session()->get('id_guru'),
                'nip' => session()->get('nip'),
                'nisn' => $getSiswa['nisn']
            ]);

        return redirect()->to(base_url('GuruPanel/Absensi/' . $id))->with('type-status', 'success')->with('message', 'Absensi siswa ' . $getSiswa['nisn'] . ' berhasil ditambahkan');
    }

    public function absensi_detail($id)
    {
        return view('guru/absensi_detail', [
            'data' => $this->db->table('absensi')->where('id_siswa', $id)->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray()
        ]);
    }

    public function alquran()
    {
        return view('guru/alquran', [
            'data' => $this->db->table('al_quran_surah')->get()->getResultArray()
        ]);
    }

    public function chart()
    {
        return view('guru/chart', [
            'data' => $this->db->table('siswa')->select('id_siswa, nama_siswa, nisn')->get()->getResultArray()
        ]);
    }

    public function getDataChart()
    {
        $getRandomSiswa = $this->db->table('siswa')->select('id_siswa, nama_siswa')->orderBy('id_siswa', 'RAND()')->limit(5)->get()->getRowArray();

        $getDistinctNamaSurah = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah'))->where('id_siswa', $getRandomSiswa['id_siswa'])->groupBy('nama_surah')->get()->getResultArray();

        $getSetoranHafalan = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah, COUNT(nama_surah), jilid, id_siswa'))->where('jilid', 'fasih')->where('id_siswa', $getRandomSiswa['id_siswa'])->groupBy('nama_surah')->get()->getResultArray();

        $getMurojaah = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah, COUNT(nama_surah), murojaah, id_siswa'))->where('id_siswa', $getRandomSiswa['id_siswa'])->where('murojaah', 1)->groupBy('nama_surah')->get()->getResultArray();

        $setoranHafalanData = [];
        foreach ($getSetoranHafalan as $item) {
            $setoranHafalanData[$item['nama_surah']] = $item['COUNT(nama_surah)'];
        }

        $murojaahData = [];
        foreach ($getMurojaah as $item) {
            $murojaahData[$item['nama_surah']] = $item['COUNT(nama_surah)'];
        }

        $namaSurah = array_column($getDistinctNamaSurah, 'nama_surah');

        $datasets = [
            [
                'label' => 'Setoran Hafalan',
                'data' => $setoranHafalanData,
                'borderColor' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            ],
            [
                'label' => "Muroja'ah",
                'data' => $murojaahData,
                'borderColor' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            ]
        ];

        $data = [
            'datasets' => $datasets,
            'label' => $namaSurah,
            'id_siswa' => $getRandomSiswa['id_siswa'],
            'nama_siswa' => $getRandomSiswa['nama_siswa']
        ];

        return $this->response->setJSON($data);
    }

    public function getDataChartSelect($id_siswa)
    {
        $getDataSiswa = $this->db->table('siswa')->select('id_siswa, nama_siswa')->where('id_siswa', $id_siswa)->get()->getRowArray();

        $getDistinctSurah = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah'))->where('id_siswa', $id_siswa)->groupBy('nama_surah')->get()->getResultArray();

        $getSetoranHafalan = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah, COUNT(nama_surah), jilid, id_siswa'))->where('jilid', 'fasih')->where('id_siswa', $id_siswa)->groupBy('nama_surah')->get()->getResultArray();

        $getMurojaah = $this->db->table('hafalan')->select(new RawSql('DISTINCT nama_surah, COUNT(nama_surah), murojaah, id_siswa'))->where('id_siswa', $id_siswa)->where('murojaah', 1)->groupBy('nama_surah')->get()->getResultArray();

        $setoranHafalanData = [];
        foreach ($getSetoranHafalan as $item) {
            $setoranHafalanData[$item['nama_surah']] = $item['COUNT(nama_surah)'];
        }

        $murojaahData = [];
        foreach ($getMurojaah as $item) {
            $murojaahData[$item['nama_surah']] = $item['COUNT(nama_surah)'];
        }

        $namaSurah = array_column($getDistinctSurah, 'nama_surah');

        $datasets = [
            [
                'label' => 'Setoran Hafalan',
                'data' => $setoranHafalanData,
                'borderColor' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            ],
            [
                'label' => "Muroja'ah",
                'data' => $murojaahData,
                'borderColor' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            ]
        ];

        $data = [
            'datasets' => $datasets,
            'label' => $namaSurah,
            'id_siswa' => $getDataSiswa['id_siswa'],
            'nama_siswa' => $getDataSiswa['nama_siswa']
        ];

        return $this->response->setJSON($data);
    }

    public function render_rekap()
    {
        return view('guru/render_rekap', []);
    }

    public function rekap()
    {
        return view('guru/rekap');
    }
}
