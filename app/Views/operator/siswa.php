<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Table Siswa</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
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
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['nisn'] ?></td>
            <td><?= $item['nama_siswa'] ?></td>
            <td><?= $item['kelas'] ?></td>
            <td>
              <button
                onclick="edit(<?= $item['id_siswa'] ?>, '<?= $item['nisn'] ?>', '<?= $item['nama_siswa'] ?>', '<?= $item['id_kelas'] ?>')"
                class="btn btn-warning">Edit</button>
              <a href="/OperatorPanel/Siswa/Delete/<?= $item['id_siswa'] ?>" class="btn btn-danger">Delete</a>
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
      <form action="/OperatorPanel/Siswa" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa">
          </div>
          <div class="mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" class="form-control" id="nisn" name="nisn">
          </div>
          <div class="mb-3">
            <label for="id_kelas">KELAS</label>
            <select class="form-select" id="id_kelas" name="id_kelas">
              <?php foreach ($kelas as $item) : ?>
              <option value="<?= $item['id_kelas'] ?>"><?= $item['nama_kelas']; ?></option>
              <?php endforeach ?>

              <?php if (count($kelas) == 0) : ?>
              <option value="" disabled selected>Belum ada kelas</option>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/OperatorPanel/Siswa/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_siswa" id="id_siswa-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" id="nama_siswa-edit" name="nama_siswa">
          </div>
          <div class="mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="nisn" class="form-control" id="nisn-edit" name="nisn">
          </div>
          <div class="mb-3">
            <label for="id_kelas">KELAS</label>
            <select class="form-select" id="id_kelas-edit" name="id_kelas">
              <?php foreach ($kelas as $item) : ?>
              <option value="<?= $item['id_kelas'] ?>"><?= $item['nama_kelas']; ?>
              </option>
              <?php endforeach ?>

              <?php if (count($kelas) == 0) : ?>
              <option value="" disabled selected>Belum ada kelas</option>
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
const edit = (id, nisn, nama_siswa, id_kelas) => {
  $('#id_siswa-edit').val(id)
  $('#nama_siswa-edit').val(nama_siswa)
  $('#nisn-edit').val(nisn)
  $('#id_kelas-edit option').each(function() {
    if ($(this).val() == id_kelas) {
      $(this).attr('selected', '');
    }
  });
  $('#edit').modal('show')
}
</script>

<?= $this->endSection(); ?>