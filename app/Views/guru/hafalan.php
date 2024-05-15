<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<?php $db = db_connect(); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white text-bg-success"><?= $dataKelas['nama_kelas']; ?> | HAFALAN</h1>
  <ol class="breadcrumb mb-4">

  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Hafalan Lulus</th>
            <th>Hafalan Belum Lulus</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($data as $key => $item) : ?>
            <tr>
              <td><?= $key + 1; ?></td>
              <td><?= $item['nisn'] ?></td>
              <td><?= $item['nama_siswa'] ?></td>
              <td>
                <?= $db->table('hafalan')->where('id_siswa', $item['id_siswa'])->where('keterangan', 'lulus')->countAllResults(); ?>
              </td>
              <td>
                <?= $db->table('hafalan')->where('id_siswa', $item['id_siswa'])->where('keterangan', 'belum_lulus')->countAllResults(); ?>
              </td>
              <td>
                <a href="/GuruPanel/Detail/<?= $item['id_siswa'] ?>" class="btn btn-primary" target="_blank">Detail</a>
                <button onclick="tambah_hafalan('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>')" class="btn btn-success">Tambah Hafalan</button>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah_hafalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Tambah Hafalan</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel" method="post" enctype="multipart/form-data">
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
              <option value="lulus">Lulus</option>
              <option value="belum_lulus">Belum Lulus</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  const tambah_hafalan = (id_siswa, nisn) => {
    $('#id_siswa').val(id_siswa)
    $('#nisn_siswa').val(nisn)
    $('#tambah_hafalan').modal('show')
  }
</script>

<?= $this->endSection(); ?>