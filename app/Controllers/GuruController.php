<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;
use Google\Client;
use GuzzleHttp\Client as GuzzleClient;

class GuruController extends BaseController
{
    use ResponseTrait;
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        return view('guru/biodata_guru', [
            'dataGuru' => $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray(),
            'data' => $this->db->table('halaqoh')->where('id_guru', session()->get('id_guru'))->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->whereIn('id_halaqoh', $this->db->table('halaqoh')->select('id_halaqoh')->where('id_guru', session()->get('id_guru')))->countAllResults(),
        ]);
    }

    public function message($type, $nama_siswa, $nama_surah = null)
    {
        switch ($type) {
            case 'Tahsin':
                $message = "Tahsin $nama_siswa, telah dilakukan";
                break;

            case 'Murojaah':
                $message = "Murojaah $nama_siswa : $nama_surah telah dilakukan";
                break;

            case 'Hafalan Baru':
                $message = "Hafalan baru $nama_siswa : $nama_surah telah dilakukan";
                break;

            default:
                $message = "Tahsin $nama_siswa, telah dilakukan";
                break;
        }

        return $message;
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
            'nama_guru' => $this->request->getPost('nama_guru'),
            'kontak' => $this->request->getPost('kontak')
        ]);

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('message', 'Data berhasil diubah');
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

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('message', 'Password berhasil diubah');
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

        $file->move('uploads', $fileName);

        $this->db->table('guru')->where('id_guru', session()->get('id_guru'))->update([
            'gambar' => $fileName
        ]);

        return redirect()->to(base_url('GuruPanel'))->with('type-status', 'success')->with('message', 'Foto profil berhasil diubah');
    }

    public function hafalan($id_halaqoh)
    {
        return view('guru/hafalan', [
            'data' => $this->db->table('siswa')->where('id_halaqoh', $id_halaqoh)->get()->getResultArray(),
            'dataHalaqoh' => $this->db->table('halaqoh')->where('id_halaqoh', $id_halaqoh)->get()->getRowArray()
        ]);
    }

    public function hafalan_siswa($id_halaqoh)
    {
        return view('guru/hafalan_siswa', [
            'data' => $this->db->table('siswa')->where('id_halaqoh', $id_halaqoh)->get()->getResultArray(),
            'dataHalaqoh' => $this->db->table('halaqoh')->where('id_halaqoh', $id_halaqoh)->get()->getRowArray()
        ]);
    }

    public function hafalan_tahsin_insert()
    {
        $rules = [
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Siswa harus dipilih'
                ]
            ],
            'nisn_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Siswa harus dipilih'
                ]
            ],
            'halaman' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Halaman tidak boleh kosong',
                    'max_length' => 'Halaman maximal 250 karakter'
                ]
            ],
            'tanggal_tahsin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong'
                ]
            ],
            'jilid' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Jilid tidak boleh kosong',
                    'max_length' => 'Jilid maximal 250 karakter'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong',
                    'max_length' => 'Keterangan maximal 250 karakter'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->save_notifikasi($this->request->getPost('nisn_siswa'), 'Tahsin');

        $this->db->table('tahsin')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'halaman' => $this->request->getPost('halaman'),
            'jilid' => $this->request->getPost('jilid'),
            'tanggal_tahsin' => $this->request->getPost('tanggal_tahsin'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_guru' => session()->get('id_guru')
        ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Tahsin berhasil ditambahkan');
    }

    public function hafalan_murojaah_insert()
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
                    'required' => 'Wajib memilih surah'
                ]
            ],
            'ayat' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Ayat tidak boleh kosong',
                    'max_length' => 'Ayat maximal 255 karakter'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong',
                    'max_length' => 'Keterangan maximal 255 karakter'
                ]
            ],
            'tanggal_murojaah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $surah = $this->db->table('al_quran_surah')->where('nomor', $this->request->getPost('surah'))->get()->getRowArray();

        $this->save_notifikasi($this->request->getPost('nisn_siswa'), 'Murojaah ', $surah['nama_latin']);

        $this->db->table('murojaah')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'surah' => $surah['nama_latin'],
            'ayat' => $this->request->getPost('ayat'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_murojaah' => $this->request->getPost('tanggal_murojaah'),
            'id_guru' => session()->get('id_guru')
        ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Murojaah berhasil ditambahkan');
    }

    public function hafalan_baru_insert()
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
                    'required' => 'Wajib memilih surah'
                ]
            ],
            'ayat' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Ayat tidak boleh kosong',
                    'max_length' => 'Ayat maximal 255 karakter'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong',
                    'max_length' => 'Keterangan maximal 255 karakter'
                ]
            ],
            'tanggal_hafalan_baru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $surah = $this->db->table('al_quran_surah')->where('nomor', $this->request->getPost('surah'))->get()->getRowArray();

        $this->save_notifikasi($this->request->getPost('nisn_siswa'), 'Hafalan Baru', $surah['nama_latin']);

        $this->db->table('hafalan_baru')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'surah' => $surah['nama_latin'],
            'ayat' => $this->request->getPost('ayat'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_hafalan_baru' => $this->request->getPost('tanggal_hafalan_baru'),
            'id_guru' => session()->get('id_guru')
        ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Hafalan baru berhasil ditambahkan');
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
            ],
            'halaman' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Halaman tidak boleh kosong',
                    'max_length' => 'Maksimal 250 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $surah = $this->db->table('al_quran_surah')->where('nomor', $this->request->getPost('surah'))->get()->getRowArray();

        $response = $this->save_notifikasi($this->request->getPost('nisn_siswa'), $this->request->getPost('keterangan'), $surah['nama_latin']);

        $this->db->table('hafalan')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_guru' => session()->get('id_guru'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'id_surah' => $this->request->getPost('surah'),
            'nama_surah' => $surah['nama_latin'],
            'ayat' => $this->request->getPost('nomor_ayat'),
            'tanggal_input' => $this->request->getPost('tanggal_input'),
            'keterangan' => ($this->request->getPost('murojaah') != '') ? $this->request->getPost('keterangan') : 'belum hafal',
            'jilid' => $this->request->getPost('jilid') ?? '',
            'murojaah' => ($this->request->getPost('murojaah') != '') ? 1 : 0,
            'halaman' => $this->request->getPost('halaman'),
        ]);

        return redirect()->to(base_url('GuruPanel/HafalanPDF/' . $this->request->getPost('id_siswa')))->with('type-status', 'success')->with('message', 'Data hafalan berhasil ditambahkan');
    }

    public function save_notifikasi($nisn, $type, $namaSurah = null)
    {
        $getData = $this->db->table('siswa')->join('orang_tua', 'orang_tua.nisn_anak = siswa.nisn', 'left')->where('siswa.nisn', $nisn)->get()->getRowArray();

        $respon = 'Not Send Notification';

        try {
            if (!is_null($getData['token_device'])) {
                $message = $this->message($type, $getData['nama_siswa'], $namaSurah);

                $respon = $this->send_notifikasi('SDIT Bombang Talluna Bira', $message, $getData['token_device']);

                $this->db->table('orang_tua_notifikasi')->insert([
                    'id_orang_tua' => $getData['id_orang_tua'],
                    'nisn' => $getData['nisn'],
                    'title' => 'SDIT Bombang Talluna Bira',
                    'body' => $message,
                ]);

                return $respon;
            }

            return 'Token Device Null';
        } catch (\Exception $e) {
            throw $e;
            echo $e->getMessage() . "<br>";
            echo $respon;
        }
    }

    function sendMessage($message)
    {
        $serviceAccountPath = realpath(WRITEPATH . 'app-monitor-hafalan-alquran-7b090d6c1b06.json');
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->fetchAccessTokenWithAssertion();

        $accessToken = $client->getAccessToken();

        $httpClient = new GuzzleClient(['base_uri' => 'https://fcm.googleapis.com']);
        $response = $httpClient->request('POST', '/v1/projects/app-monitor-hafalan-alquran/messages:send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken['access_token'],
                'Content-Type' => 'application/json',
            ],
            'json' => $message
        ]);

        return $response->getBody()->getContents();
    }

    public function send_notifikasi(String $text, String $body, String $token)
    {
        $message = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $text,
                    'body' => $body
                ],
            ]
        ];

        try {
            $result = $this->sendMessage($message);
            return "Message sent successfully: " . $result;
        } catch (\Exception $e) {
            echo "Failed to send message: " . $e->getMessage();
        }
    }

    public function test_notifikasi()
    {
        $message = [
            'message' => [
                'token' => $this->request->getPost('token_device'),
                'notification' => [
                    'title' => $this->request->getPost('title'),
                    'body' => $this->request->getPost('body')
                ],
            ]
        ];

        try {
            $result = $this->sendMessage($message);
            return "Message sent successfully: " . $result;
        } catch (\Exception $e) {
            echo "Failed to send message: " . $e->getMessage();
        }
    }

    public function hafalan_detail($id)
    {
        return view('guru/hafalan_detail', [
            'data' => $this->db->table('hafalan')->where('id_siswa', $id)->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray()
        ]);
    }

    public function hafalan_siswa_detail($id)
    {
        return view('guru/hafalan_siswa_detail', [
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray(),
            'maxData' => $this->db->query('SELECT GREATEST((SELECT COUNT(*) FROM tahsin),(SELECT COUNT(*) FROM murojaah),(SELECT COUNT(*) FROM hafalan_baru)) as max_rows')->getRowArray(),
            'dataTahsin' => $this->db->table('tahsin')->where('id_siswa', $id)->get()->getResultArray(),
            'dataMurojaah' => $this->db->table('murojaah')->where('id_siswa', $id)->get()->getResultArray(),
            'dataHafalanBaru' => $this->db->table('hafalan_baru')->where('id_siswa', $id)->get()->getResultArray()
        ]);
    }

    public function hafalan_pdf($id_siswa)
    {
        $dataSiswa = $this->db->table('siswa')->where('id_siswa', $id_siswa)->get()->getRowArray();

        $filePdf = $this->request->getFile('pdf_hafalan');

        if (!$filePdf->isValid()) {
            return $this->fail('file is not valid');
        }

        $fileName = ($dataSiswa['pdf_hafalan'] != null) ? $dataSiswa['pdf_hafalan'] : $filePdf->getRandomName();

        if ($dataSiswa['pdf_hafalan'] != null) {
            unlink('uploads/' . $dataSiswa['pdf_hafalan']);
        }

        if ($dataSiswa['pdf_hafalan'] == null) {
            $this->db->table('siswa')->where('id_siswa', $id_siswa)->update([
                'pdf_hafalan' => $fileName
            ]);
        }

        if (!$filePdf->hasMoved()) {
            $filePdf->move('uploads', $fileName);
        }

        return $this->respond([], 200, 'Berhasil');
    }

    public function hafalan_($id)
    {
        return $this->response->setJSON($this->db->table('hafalan')->where('id_siswa', $id)->get()->getResultArray());
    }

    public function hafalan_siswa_($id)
    {
        $getTahsin = $this->db->table('tahsin')->where('id_siswa', $id)->get()->getResultArray();
        $getMurojaah = $this->db->table('murojaah')->where('id_siswa', $id)->get()->getResultArray();
        $getHafalanBaru = $this->db->table('hafalan_baru')->where('id_siswa', $id)->get()->getResultArray();
        $maxData = $this->db->query('SELECT GREATEST((SELECT COUNT(*) FROM tahsin),(SELECT COUNT(*) FROM murojaah),(SELECT COUNT(*) FROM hafalan_baru)) as max_rows')->getRowArray();

        $data = [];

        for ($i = 0; $i < $maxData['max_rows']; $i++) {
            $data[$i] = [
                'tanggal_tahsin' => $getTahsin[$i]['tanggal_tahsin'] ?? '',
                'halaman_tahsin' => $getTahsin[$i]['halaman'] ?? '',
                'jilid_tahsin' => $getTahsin[$i]['jilid'] ?? '',
                'keterangan_tahsin' => $getTahsin[$i]['keterangan'] ?? '',
                'tanggal_murojaah' => $getMurojaah[$i]['tanggal_murojaah'] ?? '',
                'surah_murojaah' => $getMurojaah[$i]['surah'] ?? '',
                'ayat_murojaah' => $getMurojaah[$i]['ayat'] ?? '',
                'keterangan_murojaah' => $getMurojaah[$i]['keterangan'] ?? '',
                'tanggal_hafalan_baru' => $getHafalanBaru[$i]['tanggal_hafalan_baru'] ?? '',
                'surah_hafalan_baru' => $getHafalanBaru[$i]['surah'] ?? '',
                'ayat_hafalan_baru' => $getHafalanBaru[$i]['ayat'] ?? '',
                'keterangan_hafalan_baru' => $getHafalanBaru[$i]['keterangan'] ?? '',
                'id_tahsin' => $getTahsin[$i]['id_tahsin'] ?? '',
                'id_murojaah' => $getMurojaah[$i]['id_murojaah'] ?? '',
                'id_hafalan_baru' => $getHafalanBaru[$i]['id_hafalan_baru'] ?? ''
            ];
        }

        return $this->response->setJSON($data);
    }

    public function hafalan_siswa_delete($type, $id)
    {
        switch ($type) {
            case 'Tahsin':
                $query = $this->db->table('tahsin')->where('id_tahsin', $id);
                break;

            case 'Murojaah':
                $query = $this->db->table('murojaah')->where('id_murojaah', $id);
                break;

            case 'HafalanBaru':
                $query = $this->db->table('hafalan_baru')->where('id_hafalan_baru', $id);
                break;

            default:
                $query = $this->db->table('tahsin')->where('id_tahsin', $id);
                break;
        }

        $query->delete();

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Data hafalan berhasil dihapus');
    }

    public function hafalan_delete($id)
    {
        $this->db->table('hafalan')->where('id_hafalan', $id)->delete();

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Data hafalan berhasil dihapus');
    }

    public function absen($id_halaqoh)
    {
        return view('guru/absensi', [
            'data' => $this->db->table('siswa')->where('id_halaqoh', $id_halaqoh)->get()->getResultArray(),
            'dataHalaqoh' => $this->db->table('halaqoh')->where('id_halaqoh', $id_halaqoh)->get()->getRowArray()
        ]);
    }

    public function absensi_proses()
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
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getSiswa = $this->db->table('siswa')->select('nisn, id_kelas')->where('id_siswa', $this->request->getPost('id_siswa'))->get()->getRowArray();

        $this->db->table('absensi')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'keterangan' => $this->request->getPost('absensi'),
            'tanggal' => date('Y-m-d', strtotime((string)$this->request->getPost('tanggal'))),
            'id_kelas' => $getSiswa['id_kelas'],
            'id_guru' => session()->get('id_guru'),
            'nisn' => $getSiswa['nisn']
        ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Absensi siswa ' . $getSiswa['nisn'] . ' berhasil ditambahkan');
    }

    public function absensi_proses_edit()
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
            return redirect()->to(previous_url())->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getSiswa = $this->db->table('siswa')->select('nisn, id_kelas')->where('id_siswa', $this->request->getPost('id_siswa'))->get()->getRowArray();

        $this->db->table('absensi')
            ->where('id_absensi', $this->request->getPost('id_absensi'))
            ->update([
                'id_siswa' => $this->request->getPost('id_siswa'),
                'keterangan' => $this->request->getPost('absensi'),
                'tanggal' => date('Y-m-d', strtotime((string)$this->request->getPost('tanggal'))),
                'id_kelas' => $getSiswa['id_kelas'],
                'id_guru' => session()->get('id_guru'),
                'nisn' => $getSiswa['nisn']
            ]);

        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Absensi siswa ' . $getSiswa['nisn'] . ' berhasil ditambahkan');
    }

    public function absensi_detail($id)
    {
        return view('guru/absensi_detail', [
            'data' => $this->db->table('absensi')->where('id_siswa', $id)->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray()
        ]);
    }

    public function absensi_($id)
    {
        return $this->response->setJSON($this->db->table('absensi')->where('id_siswa', $id)->get()->getResultArray());
    }

    public function absensi_delete($id)
    {
        $this->db->table('absensi')->where('id_absensi', $id)->delete();
        return redirect()->to(previous_url())->with('type-status', 'success')->with('message', 'Absensi siswa berhasil di hapus');
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
        $rules = [
            'id_siswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Siswa harus dipilih, tidak boleh kosong'
                ]
            ],
            'pres_adab_halaqoh' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prestasi Adab Halaqoh harus dipilih, Tidak boleh kosong'
                ]
            ],
            'pres_tahsin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prestasi Tahsin harus dipilih, Tidak boleh kosong'
                ]
            ],
            'pres_tahfidz' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prestasi Tahfidz harus dipilih, Tidak boleh kosong'
                ]
            ],
            'pres_murojaah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prestasi Murojaah harus dipilih, Tidak boleh kosong'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|max_length[500]',
                'errors' => [
                    'required' => 'Keterangan harus diisi, Tidak boleh kosong',
                    'max_length' => 'Maksimal 500 karakter'
                ]
            ],
            'nilai_uts' => [
                'rules' => 'required|max_length[3]',
                'errors' => [
                    'required' => 'Nilai UTS harus diisi, Tidak boleh kosong',
                    'max_length' => 'Maksimal 3 karakter'
                ]
            ],
            'nilai_tahsin' => [
                'rules' => 'required|max_length[3]',
                'errors' => [
                    'required' => 'Nilai Tahsin harus diisi, Tidak boleh kosong',
                ]
            ],
            'action' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Aksi harus dipilih, Tidak boleh kosong'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('GuruPanel/'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $checkAction = $this->request->getPost('action');

        $getSiswa = $this->db->table('siswa')->select('siswa.*, halaqoh.halaqoh')->where('id_siswa', $this->request->getPost('id_siswa'))->join('halaqoh', 'halaqoh.id_halaqoh = siswa.id_halaqoh')->get()->getRowArray();

        $getKelas = $this->db->table('kelas')->select('id_kelas, semester, tahun_ajaran, nama_kelas')->where('id_kelas', $getSiswa['id_kelas'])->get()->getRowArray();

        $getTotalSakit = $this->db->table('absensi')->where('keterangan', 'Sakit')->where('id_siswa', $getSiswa['id_siswa'])->get()->getResultArray();

        $getTotalIzin = $this->db->table('absensi')->where('keterangan', 'Izin')->where('id_siswa', $getSiswa['id_siswa'])->get()->getResultArray();

        $getTotalAlfa = $this->db->table('absensi')->where('keterangan', 'Alpa')->where('id_siswa', $getSiswa['id_siswa'])->get()->getResultArray();

        $data = [
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_guru' => session()->get('id_guru'),
            'nama_guru' => session()->get('nama_guru'),
            'nama_siswa' => $getSiswa['nama_siswa'],
            'kelas' => $getKelas['nama_kelas'],
            'semester' => $getKelas['semester'],
            'tahun_ajaran' => $getKelas['tahun_ajaran'],
            'halaqoh' => $getSiswa['halaqoh'],
            'prestasi_adab_halaqoh' => $this->request->getPost('pres_adab_halaqoh'),
            'prestasi_tahsin' => $this->request->getPost('pres_tahsin'),
            'prestasi_tahfidz' => $this->request->getPost('pres_tahfidz'),
            'prestasi_murojaah' => $this->request->getPost('pres_murojaah'),
            'nilai_uts' => $this->request->getPost('nilai_uts'),
            'nilai_tahsin' => $this->request->getPost('nilai_tahsin'),
            'keterangan_tambahan' => $this->request->getPost('keterangan'),
            'sakit' => count($getTotalSakit),
            'izin' => count($getTotalIzin),
            'alpa' => count($getTotalAlfa),
            'id_rekap_nilai' => 0
        ];

        if ($checkAction == 'both') {
            $checkUser = $this->db->table('rekap_nilai')->where([
                'id_siswa' => $this->request->getPost('id_siswa'),
                'id_guru' => session()->get('id_guru'),
                'semester' => $getKelas['semester'],
                'tahun_ajaran' => $getKelas['tahun_ajaran']
            ])->get()->getResultArray();

            if (count($checkUser) > 0) {
                return redirect()->to(base_url('GuruPanel/RekapNilai'))->with('type-status', 'error')->with('message', 'Data gagal disimpan, Data sudah ada. Silahkan hapus data yang lama dan simpan kembali');
            }

            $check = $this->db->table('rekap_nilai')->insert($data);
            $data['id_rekap_nilai'] = $this->db->insertID();
        }

        return view('guru/render_rekap', $data);
    }

    public function rekap_nilai()
    {
        $data = $this->db->table('rekap_nilai');

        $data->where('id_guru', session()->get('id_guru'));

        if ($this->request->getMethod() === 'post') {
            $data->where($this->request->getPost());
        }

        return view('guru/rekap', [
            'data' => $data->get()->getResultArray()
        ]);
    }

    public function rekap_delete($id)
    {
        $getData = $this->db->table('rekap_nilai')->where('id_rekap_nilai', $id)->get()->getRowArray();

        $pathFile = realpath('uploads/' . $getData['blob_pdf']);

        if (is_writable($pathFile)) {
            unlink($pathFile);
        }

        $this->db->table('rekap_nilai')->where('id_rekap_nilai', $id)->delete();


        return redirect()->to(base_url('GuruPanel/RekapNilai'))->with('type-status', 'success')->with('message', 'Data berhasil dihapus');
    }

    public function getBlobPDF($id_rekap_nilai)
    {
        $filePdf = $this->request->getFile('blobUri');

        if (!$filePdf->isValid()) {
            return $this->fail('file is not valid');
        }

        $fileName = $filePdf->getRandomName();

        if (!$filePdf->hasMoved()) {
            $filePdf->move('uploads', $fileName);
        }

        $this->db->table('rekap_nilai')->where('id_rekap_nilai', $id_rekap_nilai)->update([
            'blob_pdf' => $fileName
        ]);

        return $this->respond([], 200, 'Berhasil');
    }
}
