<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tabel Guru</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>ID Guru</th>
            <th>Nama Guru</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['id_unique_guru'] ?></td>
            <td><?= $item['nama_guru'] ?></td>
            <td>
              <button
                onclick="edit(<?= $item['id_guru'] ?>, '<?= $item['id_unique_guru'] ?>', '<?= $item['nama_guru'] ?>')"
                class="btn btn-warning">Edit</button>
              <a href="/OperatorPanel/Delete/<?= $item['id_guru'] ?>" class="btn btn-danger">Delete</a>
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
      <form action="/OperatorPanel" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="nama_guru" name="nama_guru">
          </div>
          <div class="mb-3">
            <label for="id_unique_guru">ID Guru</label>
            <input type="text" class="form-control" id="id_unique_guru" name="id_unique_guru">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
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
      <form action="/OperatorPanel/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_guru" id="id_guru-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru-edit" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="nama_guru-edit" name="nama_guru">
          </div>
          <div class="mb-3">
            <label for="id_unique_guru-edit">ID Guru</label>
            <input type="text" class="form-control" id="id_unique_guru-edit" name="id_unique_guru">
          </div>
          <div class="mb-3">
            <label for="password-edit" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="password-edit" name="password">
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
const edit = (id, id_unique_guru, nama_guru) => {
  $('#id_guru-edit').val(id)
  $('#id_unique_guru-edit').val(id_unique_guru)
  $('#nama_guru-edit').val(nama_guru)
  $('#edit').modal('show')
}
</script>

<?= $this->endSection(); ?>