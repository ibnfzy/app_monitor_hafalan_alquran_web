<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<?php $db = db_connect(); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Halaqoh <?= $dataHalaqoh['halaqoh']; ?> | Halaman Hafalan</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" onclick="history.back()">Kembali</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Status PDF Kartu Kontrol</th>
            <th>Total Tahsin</th>
            <th>Total Muroja'ah</th>
            <th>Total Hafalan Baru</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['nisn'] ?></td>
            <td><?= $item['nama_siswa'] ?></td>
            <td><?= $item['kelas'] ?></td>
            <td class="text-center">
              <?= ($item['pdf_hafalan'] != null ? '<span class="badge text-bg-success">Tersedia</span>' : '<span class="badge text-bg-danger" onclick="alert(`Silahkan membuka file PDF untuk menyimpan pdf`)">Tidak Tersedia</span>'); ?>
            </td>
            <td>
              <?= $db->table('tahsin')->where('id_siswa', $item['id_siswa'])->countAllResults(); ?>
            </td>
            <td>
              <?= $db->table('murojaah')->where('id_siswa', $item['id_siswa'])->countAllResults(); ?>
            </td>
            <td>
              <?= $db->table('hafalan_baru')->where('id_siswa', $item['id_siswa'])->countAllResults(); ?>
            </td>
            <td class="col-4">
              <div class="btn-group">
                <a href="/GuruPanel/HafalanSiswa/Rekap/<?= $item['id_siswa'] ?>" class="btn btn-danger"
                  target="_blank">PDF</a>
                <div class="btn-group">
                  <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Menu Tambah
                  </button>
                  <ul class="dropdown-menu text-bg-success">
                    <li><button class="dropdown-item text-white"
                        onclick="tambah_tahsin('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>')">Tambah
                        Tahsin</button></li>
                    <li><button class="dropdown-item text-white"
                        onclick="tambah_murojaah('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>')">Tambah
                        Murojaah</button></li>
                    <li><button class="dropdown-item text-white"
                        onclick="tambah_hafalan_baru('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>')">Tambah Hafalan
                        Baru</button></li>
                  </ul>
                </div>
                <button class="btn btn-primary"
                  onclick="detailHafalan('<?= $item['id_siswa'] ?>', '<?= $item['nama_siswa'] ?>')">Kelola
                  Hafalan</button>
              </div>
            </td>
          </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah_tahsin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Tambah Tahsin</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/HafalanSiswa/Tahsin" method="post" enctype="multipart/form-data" id="formTahsin">
        <input type="hidden" name="id_siswa" id="id_siswa">
        <input type="hidden" name="nisn_siswa" id="nisn_siswa">
        <div class="modal-body">
          <div class="mb-3">
            <label for="halaman" class="form-label">Halaman</label>
            <input type="text" class="form-control" id="halaman" name="halaman">
          </div>
          <div class="mb-3">
            <label for="jilid" class="form-label">Jilid</label>
            <input type="text" class="form-control" id="jilid" name="jilid">
          </div>
          <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <select name="keterangan" id="keterangan_hafalan_baru" class="form-control">
              <option value="Fasih">Fasih</option>
              <option value="Belum Fasih">Belum Fasih</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tanggal_tahsin" class="form-label">Tanggal Tahsin</label>
            <input type="date" class="form-control" id="tanggal_tahsin" name="tanggal_tahsin"
              value="<?= date('Y-m-d'); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah_murojaah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Tambah Murojaah</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/HafalanSiswa/Murojaah" method="post" enctype="multipart/form-data" id="formMurojaah">
        <input type="hidden" name="id_siswa" id="id_siswa1">
        <input type="hidden" name="nisn_siswa" id="nisn_siswa1">
        <div class="modal-body">
          <div class="mb-3" id="murojaahParent">
            <label for="surah" class="form-label">Surah</label>
            <select class="select2 form-control col-12" style="width: 100%;" id="select2-murojaah" name="surah">
              <?php
              $surahs = $db->table('al_quran_surah')->select('nama_latin, nomor, nama')->get()->getResultArray();
              foreach ($surahs as $surah) {
                echo "<option value='{$surah['nomor']}'> {$surah['nama_latin']} ({$surah['nama']})</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="ayat">Ayat</label>
            <input type="text" class="form-control" name="ayat">
          </div>
          <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <select name="keterangan" id="keterangan_murojaah" class="form-control">
              <option value="Hafal">Hafal</option>
              <option value="Belum Hafal">Belum Hafal</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tanggal_murojaah" class="form-label">Tanggal Murojaah</label>
            <input type="date" class="form-control" id="tanggal_murojaah" name="tanggal_murojaah"
              value="<?= date('Y-m-d'); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah_hafalan_baru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Tambah Hafalan Baru</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/HafalanSiswa/HafalanBaru" method="post" enctype="multipart/form-data"
        id="formHafalanBaru">
        <input type="hidden" name="id_siswa" id="id_siswa2">
        <input type="hidden" name="nisn_siswa" id="nisn_siswa2">
        <div class="modal-body">
          <div class="mb-3" id="hafalanBaruParent">
            <label for="surah" class="form-label">Surah</label>
            <select class="select2 form-control col-12 select2-surah" style="width: 100%;" id="select2-hafalan-baru"
              name="surah">
              <?php
              $surahs = $db->table('al_quran_surah')->select('nama_latin, nomor, nama')->get()->getResultArray();
              foreach ($surahs as $surah) {
                echo "<option value='{$surah['nomor']}'> {$surah['nama_latin']} ({$surah['nama']})</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="ayat">Ayat</label>
            <input type="text" class="form-control" name="ayat">
          </div>
          <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <select name="keterangan" id="keterangan_hafalan_baru" class="form-control">
              <option value="Hafal">Hafal</option>
              <option value="Belum Hafal">Belum Hafal</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tanggal_hafalan_baru" class="form-label">Tanggal Hafalan Baru</label>
            <input type="date" class="form-control" id="tanggal_hafalan_baru" name="tanggal_hafalan_baru"
              value="<?= date('Y-m-d'); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="detailLabel">Detail Hafalan </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="detail_hafalan" class="table table-responsive table-bordered table-sm">
          <thead class="table-success">
            <tr>
              <th rowspan="2">NO</th>
              <th colspan="4">Tahsin</th>
              <th colspan="4">Muroja'ah</th>
              <th colspan="4">Hafalan Baru</th>
              <th rowspan="2">Aksi</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Halaman</th>
              <th>Jilid</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Surah</th>
              <th>Ayat</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Surah</th>
              <th>Ayat</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody id="tbody-detail">
            <tr>
              <td colspan="16">DATA KOSONG</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
$(document).ready(function() {
  $('#formKu').submit(function(event) {
    let waktu = 3;
    let intervalId = setInterval(function() {
      waktu--;
      if (waktu < 0) {
        clearInterval(intervalId);
        window.location.reload(); // Refresh halaman
      }
    }, 1000);
  });
});

const detailHafalan = (id_siswa, nama_siswa) => {
  $('#detailLabel').text('Detail Hafalan ' + nama_siswa);
  $.ajax({
    type: "GET",
    url: "/GuruPanel/HafalanSiswa/Detail/" + id_siswa,
    dataType: "json",
    success: function(data) {
      $('#tbody-detail').empty();
      if (data.length > 0) {
        $.each(data, function(index, item) {
          aksi = `<div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Menu Hapus
                    </button>
                    <ul class="dropdown-menu text-bg-danger">` +
            (item.id_tahsin === "" ? "" :
              `<li><a class="dropdown-item text-white" href="/GuruPanel/HafalanSiswa/Tahsin/` + item
              .id_tahsin + `">Hapus Tahsin</a></li>`) +
            (item.id_murojaah === "" ? "" :
              `<li><a class="dropdown-item text-white" href="/GuruPanel/HafalanSiswa/Murojaah/` + item
              .id_murojaah + `">Hapus Murojaah</a></li>`) +
            (item.id_hafalan_baru === "" ? "" :
              `<li><a class="dropdown-item text-white" href="/GuruPanel/HafalanSiswa/HafalanBaru/` + item
              .id_hafalan_baru + `">Hapus Hafalan Baru</a></li>`) +
            `</ul></div>`;

          $('#tbody-detail').append('<tr>' +
            '<td>' + (index + 1) + '</td>' +
            '<td>' + item.tanggal_tahsin + '</td>' +
            '<td>' + item.halaman_tahsin + '</td>' +
            '<td>' + item.jilid_tahsin + '</td>' +
            '<td>' + item.keterangan_tahsin + '</td>' +
            '<td>' + item.tanggal_murojaah + '</td>' +
            '<td>' + item.surah_murojaah + '</td>' +
            '<td>' + item.ayat_murojaah + '</td>' +
            '<td>' + item.keterangan_murojaah + '</td>' +
            '<td>' + item.tanggal_hafalan_baru + '</td>' +
            '<td>' + item.surah_hafalan_baru + '</td>' +
            '<td>' + item.ayat_hafalan_baru + '</td>' +
            '<td>' + item.keterangan_hafalan_baru + '</td>' +
            '<td>' + aksi + '</td>' +
            '</tr>');
        });
      } else {
        $('#tbody-detail').append('<tr><td colspan="16">DATA KOSONG</td></tr>');
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Error: " + errorThrown);
    }
  });
  $('#detail').modal('show')
}

const tambah_tahsin = (id_siswa, nisn) => {
  $('#id_siswa').val(id_siswa)
  $('#nisn_siswa').val(nisn)
  $('#tambah_tahsin').modal('show')
}

const tambah_murojaah = (id_siswa, nisn) => {
  $('#id_siswa1').val(id_siswa)
  $('#nisn_siswa1').val(nisn)
  $('#tambah_murojaah').modal('show')
}

const tambah_hafalan_baru = (id_siswa, nisn) => {
  $('#id_siswa2').val(id_siswa)
  $('#nisn_siswa2').val(nisn)
  $('#tambah_hafalan_baru').modal('show')
}
</script>

<?= $this->endSection(); ?>