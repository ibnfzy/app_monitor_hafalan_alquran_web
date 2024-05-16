<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Tabel Rekap Nilai</h1>
  <ol class="breadcrumb mb-4 col-4">
    <!-- <button class="btn btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#filter">Filter Semester & Kelas</button> -->
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Siswa</th>
            <th>Semester</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['nama_siswa']; ?></td>
            <td><?= $item['semester']; ?></td>
            <td><?= $item['tahun_ajaran']; ?></td>
            <td>
              <a href="/API/PDF/<?= $item['id_rekap_nilai'] ?>" target="_blank" class="btn btn-danger"><i
                  class="fas fa-file-pdf"></i>
                Download</a>
              <a href="/GuruPanel/RekapNilai/Delete/<?= $item['id_rekap_nilai'] ?>" class="btn btn-warning">Hapus</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterLabel">Filter Semester</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Semester</label>
          <select class="form-select" aria-label="Default select example">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Apply</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>