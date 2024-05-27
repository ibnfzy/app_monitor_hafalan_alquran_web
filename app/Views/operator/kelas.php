<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tabel Kelas</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Semester</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['nama_kelas'] ?></td>
            <td><?= $item['tahun_ajaran'] ?></td>
            <td><?= $item['semester'] ?></td>
            <td>
              <button
                onclick="edit(<?= $item['id_kelas'] ?>, '<?= $item['nama_kelas'] ?>', '<?= $item['tahun_ajaran'] ?>', '<?= $item['semester'] ?>')"
                class="btn btn-warning">Edit</button>
              <a href="/OperatorPanel/Kelas/<?= $item['id_kelas'] ?>" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Kelas" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas">
          </div>
          <div class="mb-3">
            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran">
          </div>
          <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester">
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



<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Kelas/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_kelas" id="id_kelas-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_kelas-edit" class="form-label">Nama Kelas</label>
            <input type="text" class="form-control" id="nama_kelas-edit" name="nama_kelas">
          </div>
          <div class="mb-3">
            <label for="tahun_ajaran-edit" class="form-label">Tahun Ajaran</label>
            <input type="text" class="form-control" id="tahun_ajaran-edit" name="tahun_ajaran">
          </div>
          <div class="mb-3">
            <label for="semester-edit" class="form-label">Semester</label>
            <input type="text" class="form-control" id="semester-edit" name="semester">
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
const edit = (id, nama_kelas, tahun_ajaran, semester) => {
  $('#id_kelas-edit').val(id)
  $('#nama_kelas-edit').val(nama_kelas)
  $('#tahun_ajaran-edit').val(tahun_ajaran)
  $('#semester-edit').val(semester)
  $('#edit').modal('show')
}
</script>

<?= $this->endSection(); ?>