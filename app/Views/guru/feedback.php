<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Tabel Feedback</h1>
  <ol class="breadcrumb mb-4">

  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>NISN</th>
            <th>Nama Orang Tua Murid</th>
            <th>Nama Murid</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['nisn'] ?></td>
            <td><?= $item['nama_orang_tua'] ?></td>
            <td><?= $item['nama_siswa'] ?></td>
            <td>
              <button
                onclick="lihat(<?= $item['nisn'] ?>, '<?= $item['nama_orang_tua'] ?>', '<?= $item['nama_siswa'] ?>', '<?= $item['deskripsi'] ?>', '<?= $item['created_at'] ?>')"
                class="btn btn-info">Lihat</button>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="lihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Feedback</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nisn" class="form-label">NISN</label>
          <input type="text" class="form-control" id="nisn" readonly>
        </div>
        <div class="mb-3">
          <label for="nama_orang_tua" class="form-label">Nama Orang Tua</label>
          <input type="text" class="form-control" id="nama_orang_tua" readonly>
        </div>

        <div class="mb-3">
          <label for="nama_siswa" class="form-label">Nama Siswa</label>
          <input type="text" class="form-control" id="nama_siswa" readonly>
        </div>

        <div class="mb-3">
          <label for="created_at" class="form-label">Tanggal dibuat</label>
          <input type="text" class="form-control" id="created_at" readonly>
        </div>

        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskrispi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" readonly></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
function lihat(nisn, nama_orang_tua, nama_siswa, deskripsi, created_at) {
  $('#nisn').val(nisn);
  $('#nama_orang_tua').val(nama_orang_tua);
  $('#nama_siswa').val(nama_siswa);
  $('#deskripsi').val(deskripsi);
  $('#created_at').val(created_at);
  $('#lihat').modal('show');
};
</script>

<?= $this->endSection(); ?>