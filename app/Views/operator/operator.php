<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tabel Operator</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Nama Operator</th>
            <th>Nomor Whatsapp</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['username'] ?></td>
            <td><?= $item['nama_operator'] ?></td>
            <td>+<?= $item['nomor_wa'] ?></td>
            <td>
              <button
                onclick="edit(<?= $item['id_operator'] ?>, '<?= $item['username'] ?>', '<?= $item['nama_operator'] ?>', '<?= $item['nomor_wa'] ?>')"
                class="btn btn-warning">Edit</button>
              <a href="/OperatorPanel/Operator/<?= $item['id_operator'] ?>" class="btn btn-danger">Delete</a>
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
      <form action="/OperatorPanel/Operator" method="post" enctype="multipart/form-data" id="form-add">
        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="nama_operator" class="form-label">Nama Operator</label>
            <input type="text" class="form-control" id="nama_operator" name="nama_operator" required>
          </div>
          <div class="mb-3">
            <label for="nomor_wa" class="form-label">Nomor Whatsapp</label>
            <input type="text" class="form-control" id="nomor_wa" name="nomor_wa"
              data-inputmask="'mask': '62999999999999'" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password"
              autocomplete="new-password">
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
      <form action="/OperatorPanel/Operator/Update" method="post" enctype="multipart/form-data" autocomplete="off"
        id="form-edit">
        <input type="hidden" name="id_operator" id="id_operator-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username-edit" name="username">
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Nama Operator</label>
            <input type="text" class="form-control" id="nama_operator-edit" name="nama_operator">
          </div>
          <div class="mb-3">
            <label for="nomor_wa-edit" class="form-label">Nomor Whatsapp</label>
            <input type="text" class="form-control" id="nomor_wa-edit" name="nomor_wa"
              data-inputmask="'mask': '62999999999999'">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="password-edit" name="password" autocomplete="new-password">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="konfirmasi_password-edit" name="konfirmasi_password"
              autocomplete="new-password">
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
const edit = (id, username, nama_operator, nomor_wa) => {
  $('#id_operator-edit').val(id)
  $('#username-edit').val(username)
  $('#nama_operator-edit').val(nama_operator)
  $('#nomor_wa-edit').val(nomor_wa)
  $('#edit').modal('show')
};

$(":input").inputmask();

$('#form-edit').submit(function(e) {
  e.preventDefault()
  var password = $('#password-edit').val()
  var konfirmasi_password = $('#konfirmasi_password-edit').val()
  if (password != konfirmasi_password) {
    $("#konfirmasi_password-edit").css("border-color", "red");
    $("#konfirmasi_password-edit").siblings("label").css("color", "red").text("Password tidak sama");
  } else {
    $("#konfirmasi_password-edit").css("border-color", "");
    $("#konfirmasi_password-edit").siblings("label").css("color", "").text("Password");
    $("#form-edit").unbind().submit();
  }
});

$('#form-add').submit(function(e) {
  e.preventDefault()
  var password = $('#password').val()
  var konfirmasi_password = $('#konfirmasi_password').val()
  if (password === '' || konfirmasi_password === '') {
    $("#konfirmasi_password").css("border-color", "red");
    $("#konfirmasi_password").siblings("label").css("color", "red").text("Password tidak boleh kosong");
    $('#password').css("border-color", "red");
    $('#password').siblings("label").css("color", "red").text("Password tidak boleh kosong");
  } else if (password != konfirmasi_password) {
    $("#konfirmasi_password").css("border-color", "red");
    $("#konfirmasi_password").siblings("label").css("color", "red").text("Password tidak sama");
  } else {
    $("#konfirmasi_password").css("border-color", "");
    $("#konfirmasi_password").siblings("label").css("color", "").text("Password");
    $("#form-add").unbind().submit();
  }
})
</script>

<?= $this->endSection(); ?>