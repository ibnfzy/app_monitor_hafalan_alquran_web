<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Table Kelas</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
            <tr>
              <td><?= $i = $key + 1; ?></td>
              <td class="col-4"><?= $item['judul'] ?> <img src="/uploads/<?= $item['gambar'] ?>" alt="" class="image-fluid w-50 d-block">
              </td>
              <td class="col-4"><?= $item['deskripsi'] ?></td>
              <td>
                <button onclick="edit(<?= $item['id_kegiatan'] ?>, '<?= $item['judul'] ?>', '<?= $item['deskripsi'] ?>', '<?= $item['gambar'] ?>')" class="btn btn-warning">Edit</button>
                <a href="/OperatorPanel/Kegiatan/<?= $item['id_kegiatan'] ?>" class="btn btn-danger">Delete</a>
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
      <form action="/OperatorPanel/Kegiatan" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nip" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul">
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label">Pilih Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control"></textarea>
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
      <form action="/OperatorPanel/Kegiatan/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_kegiatan" id="id_kegiatan-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nip" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul-edit" name="judul">
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label">Pilih Gambar</label>
            <img src="#" alt="" class="image-fluid d-block w-25 my-2" id="image-edit">
            <input type="file" name="gambar" class="form-control">
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi-edit" cols="30" rows="10" class="form-control"></textarea>
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
  const edit = (id, judul, deskripsi, gambar) => {
    $('#id_kegiatan-edit').val(id)
    $('#judul-edit').val(judul)
    $('#deskripsi-edit').val(deskripsi)
    $('#image-edit').attr('src', '/uploads/' +
      gambar)
    $('#edit').modal('show')
  }
</script>

<?= $this->endSection(); ?>