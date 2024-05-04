<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Table Kelas</h1>
  <ol class="breadcrumb mb-4">

  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Kelas</th>
            <th>Nama Guru</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['nama_kelas'] ?></td>
            <td><?= $item['nama_guru'] ?></td>
            <td class="btn-group">
              <a href="/GuruPanel/<?= $item['id_kelas'] ?>" class="btn btn-primary">Hafalan</a>
              <a href="/GuruPanel/Absensi/<?= $item['id_kelas'] ?>" class="btn btn-info">Absensi</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>