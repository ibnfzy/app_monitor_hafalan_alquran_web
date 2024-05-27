<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;

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

        switch ($this->request->getPost('keterangan')) {
            case 'hafal':
                $keterangan = 'hafal';
                $jilid = 'fasih';
                $murojaah = 0;
                break;

            case 'fasih':
                $keterangan = 'belum hafal';
                $jilid = 'fasih';
                $murojaah = 1;
                break;

            case 'belum':
                $keterangan = 'belum hafal';
                $jilid = 'belum fasih';
                $murojaah = 1;

            default:
                $keterangan = 'belum hafal';
                $jilid = 'belum fasih';
                $murojaah = 1;
                break;
        }

        $this->db->table('hafalan')->insert([
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_guru' => session()->get('id_guru'),
            'nisn' => $this->request->getPost('nisn_siswa'),
            'id_surah' => $this->request->getPost('surah'),
            'nama_surah' => $surah['nama_latin'],
            'ayat' => $this->request->getPost('nomor_ayat'),
            'tanggal_input' => $this->request->getPost('tanggal_input'),
            'keterangan' => $keterangan,
            'jilid' => $jilid,
            'murojaah' => $murojaah
        ]);

        return redirect()->to(base_url('GuruPanel/HafalanPDF/' . $this->request->getPost('id_siswa')))->with('type-status', 'success')->with('message', 'Data hafalan berhasil ditambahkan');
    }

    public function hafalan_detail($id)
    {
        return view('guru/hafalan_detail', [
            'data' => $this->db->table('hafalan')->where('id_siswa', $id)->get()->getResultArray(),
            'dataSiswa' => $this->db->table('siswa')->where('id_siswa', $id)->get()->getRowArray(),
            'dataGuru' => $this->db->table('guru')->select('nama_guru')->where('id_guru', session()->get('id_guru'))->get()->getRowArray()
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

        $getTotalSakit = $this->db->table('absensi')->select('SUM(keterangan) as total_sakit')->where('keterangan', 'Sakit')->where('id_siswa', $getSiswa['id_siswa'])->get()->getRowArray();

        $getTotalIzin = $this->db->table('absensi')->select('SUM(keterangan) as total_izin')->where('keterangan', 'Izin')->where('id_siswa', $getSiswa['id_siswa'])->get()->getRowArray();

        $getTotalAlfa = $this->db->table('absensi')->select('SUM(keterangan) as total_alfa')->where('keterangan', 'Alpa')->where('id_siswa', $getSiswa['id_siswa'])->get()->getRowArray();

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
            'sakit' => $getTotalSakit['total_sakit'] ?? 0,
            'izin' => $getTotalIzin['total_izin'] ?? 0,
            'alpa' => $getTotalAlfa['total_alfa'] ?? 0,
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
