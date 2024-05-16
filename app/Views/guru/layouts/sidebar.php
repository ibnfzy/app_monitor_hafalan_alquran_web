<?php $db = db_connect(); ?>

<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
      <div class="nav">
        <a class="nav-link text-white" href="/GuruPanel">
          <div class="sb-nav-link-icon text-white"><i class="fas fa-tachometer-alt"></i></div>
          Panel
        </a>
        <a href="/GuruPanel/Al-Quran" class="nav-link text-white">
          <div class="sb-nav-link-icon"><i class="fa-solid fa-book text-white"></i></div>
          Al-Quran Surah
        </a>
        <a href="/GuruPanel/Chart" class="nav-link text-white">
          <div class="sb-nav-link-icon text-white"><i class="fas fa-chart-area"></i></div>
          Grafik
        </a>
        <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
          <div class="sb-nav-link-icon text-white"><i class="fas fa-columns"></i></div>
          Rekap Nilai
          <div class="sb-sidenav-collapse-arrow text-white"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link text-white" href="#!" data-bs-toggle="modal" data-bs-target="#createRekap">Buat Rekap
              Nilai</a>
            <a class="nav-link text-white" href="/GuruPanel/RekapNilai">Tabel Rekap Nilai</a>
          </nav>
        </div>
      </div>
    </div>
    <div class="sb-sidenav-footer">
      <div class="small">Tanggal Server :</div>
      <?= date('D, d M Y'); ?>
    </div>
  </nav>
</div>

<?php
$getKelas = $db->table('kelas')->where('id_guru', session()->get('id_guru'))->get()->getResultArray();

$arrayIdKelas = [];
foreach ($getKelas as $item) {
  $arrayIdKelas[] = $item['id_kelas'];
}

$getSiswa = $db->table('siswa')->whereIn('id_kelas', $arrayIdKelas)->get()->getResultArray();
?>



<div class="modal fade" id="createRekap" tabindex="-1" aria-labelledby="createRekapLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="createRekapLabel">Tambah Data</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/RekapNilai" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="mb-3" id="siswaParent">
                <label for="siswa" class="form-label">Pilih Siswa</label>
                <select class="select2-siswa form-control col-12" style="width: 100%;" name="id_siswa" required>
                  <?php foreach ($getSiswa as $item) : ?>
                    <option value="<?= $item['id_siswa'] ?>"><?= $item['nama_siswa']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="halaqoh" class="form-label">Halaqoh</label>
                <input type="text" class="form-control" id="halaqoh" name="halaqoh" required>
              </div>
              <div class="mb-3">
                <label for="pres_adab_halaqoh" class="form-label">Prestasi Adab Halaqoh</label>
                <select name="pres_adab_halaqoh" id="pres_adab_halaqoh" class="form-select" required>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="pres_tahsin" class="form-label">Prestasi Tahsin</label>
                <select name="pres_tahsin" id="pres_tahsin" class="form-select" required>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="pres_tahfidz" class="form-label">Prestasi Tahfidz</label>
                <select name="pres_tahfidz" id="pres_tahfidz" class="form-select" required>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="pres_murojaah" class="form-label">Prestasi Muroja'ah</label>
                <select name="pres_murojaah" id="pres_murojaah" class="form-select" required>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" required></textarea>
              </div>
              <div class="mb-3">
                <label for="nilai_uts" class="form-label">Nilai UTS</label>
                <input type="number" class="form-control" id="nilai_uts" name="nilai_uts" required>
              </div>
              <div class="mb-3">
                <label for="nilai_tahsin" class="form-label">Nilai Tahsin</label>
                <input type="number" class="form-control" id="nilai_tahsin" name="nilai_tahsin" required>
              </div>

              <div class="mb-3" id="actionParent">
                <label for="action" class="form-label">Pilih Aksi</label>
                <select class="form-select" id="action" name="action" required>
                  <option value="download">Download</option>
                  <option value="both">Download dan Simpan</option>
                </select>
              </div>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Proses</button>
        </div>
      </form>
    </div>
  </div>
</div>