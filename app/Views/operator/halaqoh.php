<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tabel Halaqoh</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Halaqoh</th>
            <th>Nama Guru</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['halaqoh'] ?></td>
            <td><?= $item['nama_guru'] ?></td>
            <td>
              <button onclick="edit(<?= $item['id_halaqoh'] ?>, `<?= $item['halaqoh'] ?>`, '<?= $item['id_guru'] ?>')"
                class="btn btn-warning">Edit</button>
              <a href="/OperatorPanel/Halaqoh/<?= $item['id_halaqoh'] ?>" class="btn btn-danger">Delete</a>
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
      <form action="/OperatorPanel/Halaqoh" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="halaqoh" class="form-label">Halaqoh</label>
            <input type="text" class="form-control" id="halaqoh" name="halaqoh">
          </div>

          <div class="mb-3">
            <label for="id_guru" class="form-label">Pilih Guru</label>
            <select name="id_guru" class="form-control">
              <?php foreach ($dataGuru as $item) : ?>
              <option value="<?= $item['id_guru'] ?>"><?= $item['nama_guru'] ?></option>
              <?php endforeach ?>

              <?php if (count($dataGuru) == 0) : ?>
              <option value="" disabled selected>Belum ada guru</option>
              <?php endif ?>
            </select>
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
      <form action="/OperatorPanel/Halaqoh/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_halaqoh" id="id_halaqoh-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="halaqoh-edit" class="form-label">Halaqoh</label>
            <input type="text" class="form-control" id="halaqoh-edit" name="halaqoh">
          </div>

          <div class="mb-3">
            <label for="id_guru-edit" class="form-label">Pilih Guru</label>
            <select name="id_guru" id="id_guru-edit" class="form-control">
              <?php foreach ($dataGuru as $item) : ?>
              <option value="<?= $item['id_guru'] ?>"><?= $item['nama_guru'] ?></option>
              <?php endforeach ?>

              <?php if (count($dataGuru) == 0) : ?>
              <option value="" disabled selected>Belum ada guru</option>
              <?php endif ?>
            </select>
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
const edit = (id, halaqoh, id_guru) => {
  $('#id_halaqoh-edit').val(id)
  $('#halaqoh-edit').val(halaqoh)
  $('#id_guru-edit option').each(function() {
    if ($(this).val() == id_guru) {
      $(this).prop('selected', true)
    }
  })
  $('#edit').modal('show')
}
</script>

<?= $this->endSection(); ?>