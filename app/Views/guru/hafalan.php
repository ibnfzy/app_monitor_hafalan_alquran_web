<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<?php $db = db_connect(); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Halaqoh <?= $dataHalaqoh['halaqoh']; ?> | Halaman Hafalan</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" onclick="history.back()">Kembali</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Status PDF Kartu Kontrol</th>
            <th>Total Hafalan (Tahfidz)</th>
            <th>Total Muroja'ah</th>
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
                <?= $db->table('hafalan')->where('id_siswa', $item['id_siswa'])->where('keterangan', 'hafal')->countAllResults(); ?>
              </td>
              <td>
                <?= $db->table('hafalan')->where('id_siswa', $item['id_siswa'])->where('murojaah', 1)->countAllResults(); ?>
              </td>
              <td>
                <a href="/GuruPanel/HafalanPDF/<?= $item['id_siswa'] ?>" class="btn btn-danger" target="_blank">PDF</a>
                <button onclick="tambah_hafalan('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>')" class="btn btn-success">Tambah Hafalan</button>
                <button class="btn btn-primary" onclick="detailHafalan('<?= $item['id_siswa'] ?>', '<?= $item['nama_siswa'] ?>')">Kelola
                  Hafalan</button>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class=" modal fade" id="tambah_hafalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Tambah Hafalan</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel" method="post" enctype="multipart/form-data" target="_blank" id="formKu">
        <input type="hidden" name="id_siswa" id="id_siswa">
        <input type="hidden" name="nisn_siswa" id="nisn_siswa">
        <div class="modal-body">
          <div class="mb-3" id="surahParent">
            <label for="surah" class="form-label">Pilih Surah
            </label>
            <select name="surah" id="surah" class="select2 form-control col-12" style="width: 100%;">
              <?php
              $surahs = $db->table('al_quran_surah')->select('nama_latin, nomor, nama')->get()->getResultArray();
              foreach ($surahs as $surah) {
                echo "<option value='{$surah['nomor']}'> {$surah['nama_latin']} ({$surah['nama']})</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="nomor_ayat" class="form-label">Nomor Ayat</label>
            <input type="text" class="form-control" id="nomor_ayat" name="nomor_ayat">
          </div>

          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal_input" name="tanggal_input" value="<?= date('Y-m-d'); ?>">
          </div>

          <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <select name="keterangan" id="keterangan" class="form-control">
              <option value="hafal">Hafal</option>
              <option value="belum hafal">Belum Hafal</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="jilid">Jilid</label>
            <input type="text" class="form-control" id="jilid" name="jilid">
          </div>

          <div class="mb-3">
            <label for="halaman">Halaman</label>
            <input type="text" class="form-control" id="halaman" name="halaman">
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="murojaah">
            <label class="form-check-label" for="flexCheckDefault">
              Muroja'ah
            </label>
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

<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Hafalan </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="detail_hafalan" class="table table-responsive table-bordered">
          <thead>
            <tr>
              <th rowspan="2">No</th>
              <th colspan="3">Tahsin</th>
              <th colspan="3">Muroja'ah</th>
              <th colspan="3">Hafalan Baru</th>
              <th rowspan="2">Aksi</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Halaman</th>
              <th>Jilid</th>
              <th>Surah</th>
              <th>Ayat</th>
              <th>Keterangan</th>
              <th>Surah</th>
              <th>Ayat</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody id="tbody-detail">
            <tr>
              <td colspan="9">DATA KOSONG</td>
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
      // $('#tambah_hafalan').modal('hide');
      // $(this).find('input[type="text"]').val('');
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
      url: "/GuruPanel/Hafalan/" + id_siswa,
      dataType: "json",
      success: function(data) {
        $('#tbody-detail').empty();
        if (data.length > 0) {
          $.each(data, function(index, item) {
            const data = '<td>' + item.nama_surah + '</td>' +
              '<td>' + item.halaman + '</td>' +
              '<td>' + item.keterangan + '</td>';
            $('#tbody-detail').append('<tr>' +
              '<td>' + (index + 1) + '</td>' +
              '<td>' + item.tanggal_input + '</td>' +
              '<td>' + item.ayat + '</td>' +
              '<td>' + item.jilid + '</td>' +
              (item.murojaah == 1 ? data : '<td></td><td></td><td></td>') +
              (item.murojaah == 0 ? data : '<td></td><td></td><td></td>') +
              '<td>' + '<a class="btn btn-danger" href="/GuruPanel/Hafalan/Delete/' + item.id_hafalan +
              '">Hapus</a>' + '</td>' +
              '</tr>');
          });
        } else {
          $('#tbody-detail').append('<tr><td colspan="9">DATA KOSONG</td></tr>');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
      }
    });
    $('#detail').modal('show')
  }

  const tambah_hafalan = (id_siswa, nisn) => {
    $('#id_siswa').val(id_siswa)
    $('#nisn_siswa').val(nisn)
    $('#tambah_hafalan').modal('show')
  }
</script>

<?= $this->endSection(); ?>