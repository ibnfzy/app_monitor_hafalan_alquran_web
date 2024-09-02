<?= $this->extend('operator/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tabel Siswa</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Data</button>
  </ol>
  <div class="card mb-4">
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Guru</th>
            <th>Kelas</th>
            <th>Halaqoh</th>
            <th>Status Halaqoh
              <?php if (session()->get('totalSiswaChange') != 0) : ?>
              <span class="badge text-bg-primary mx-3"><?= session()->get('totalSiswaChange'); ?></span>
              <?php endif ?>
            </th>
            <th>NIK Orang Tua</th>
            <th>Nomor Whatsapp Orang Tua</th>
            <th>Nama Orang Tua</th>
            <th>Status Akun Orang Tua</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $i = $key + 1; ?></td>
            <td><?= $item['nisn'] ?></td>
            <td><?= $item['nama_siswa'] ?></td>
            <td><?= $item['nama_guru']; ?></td>
            <td><?= $item['kelas'] ?></td>
            <td><?= $item['halaqoh'] ?></td>
            <td><?= $item['status_halaqoh'] ?></td>
            <td><?= $item['nik'] ?></td>
            <td><a href="https://wa.me/<?= $item['no_wa'] ?>" class="btn btn-link"
                target="_blank"><?= $item['no_wa'] ?></a></td>
            <td><?= $item['nama_orang_tua'] ?></td>
            <td>
              <?php if ($item['is_valid'] == 1) : ?>
              <span class="badge text-bg-success">Aktif</span>
              <?php elseif ($item['is_valid'] == null) : ?>
              <span class="badge text-bg-warning">Belum Daftar</span>
              <?php else : ?>
              <span class="badge text-bg-danger">Belum Validasi</span>
              <?php endif ?>
            </td>
            <td>
              <div class="btn-group">
                <button
                  onclick="edit('<?= $item['id_siswa'] ?>', '<?= $item['nisn'] ?>', '<?= $item['nama_siswa'] ?>', '<?= $item['id_kelas'] ?>', '<?= $item['id_halaqoh'] ?>', '<?= $item['nama_orang_tua'] ?>', '<?= $item['nik'] ?>', '<?= $item['is_valid'] ?>', `<?= $item['status_halaqoh'] ?>`, '<?= $item['no_wa'] ?>', '<?= $item['id_orang_tua'] ?>')"
                  class="btn btn-warning">Edit</button>
                <a href="/OperatorPanel/Siswa/<?= $item['id_siswa'] ?>" class="btn btn-danger">Delete</a>
              </div>
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
            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
          </div>
          <div class="mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" class="form-control" id="nisn" name="nisn" data-inputmask="'mask': '9999999999'"
              required>
          </div>
          <div class="mb-3">
            <label for="id_kelas">KELAS</label>
            <select class="form-select" id="id_kelas" name="id_kelas" required>
              <?php foreach ($kelas as $item) : ?>
              <option value="<?= $item['id_kelas'] ?>"><?= $item['nama_kelas']; ?></option>
              <?php endforeach ?>

              <?php if (count($kelas) == 0) : ?>
              <option value="" disabled selected>Belum ada kelas</option>
              <?php endif ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="halaqoh">Halaqoh</label>
            <select class="form-select" id="halaqoh" name="id_halaqoh" required>
              <?php foreach ((array) $dataHalaqoh as $item) : ?>
              <option value="<?= $item['id_halaqoh']; ?>"><?= $item['halaqoh']; ?></option>
              <?php endforeach ?>
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
      <form action="/OperatorPanel/Siswa/Update" method="post" enctype="multipart/form-data" id="form-edit">
        <input type="hidden" name="id_siswa" id="id_siswa-edit">
        <input type="hidden" name="id_halaqoh" id="id_halaqoh-edit">
        <input type="hidden" name="id_orang_tua" id="id_orang_tua-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" id="nama_siswa-edit" name="nama_siswa">
          </div>
          <div class="mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="nisn" class="form-control" id="nisn-edit" name="nisn" data-inputmask="'mask': '9999999999'">
          </div>
          <div class="mb-3">
            <label for="id_kelas">KELAS</label>
            <select class="form-select" id="id_kelas-edit" name="id_kelas">
              <?php foreach ((array) $kelas as $item) : ?>
              <option value="<?= $item['id_kelas'] ?>"><?= $item['nama_kelas']; ?>
              </option>
              <?php endforeach ?>

              <?php if (count($kelas) == 0) : ?>
              <option value="" disabled selected>Belum ada kelas</option>
              <?php endif ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="halaqoh">Halaqoh</label>
            <span class="text-danger" id="status_halaqoh"></span>
            <select class="form-select" id="halaqoh-edit" name="id_halaqoh">
              <?php foreach ((array) $dataHalaqoh as $item) : ?>
              <option value="<?= $item['id_halaqoh']; ?>"><?= $item['halaqoh']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <hr>
          <div id="dataOrangTua">
            <div class="mb-3">
              <label for="nama_orang_tua" class="form-label">Nama Orang Tua</label>
              <input type="text" class="form-control" id="nama_orang_tua-edit" name="nama_orang_tua">
            </div>
            <div class="mb-3">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" class="form-control" id="nik-edit" name="nik"
                data-inputmask="'mask': '9999999999999999'">
            </div>
            <div class="mb-3">
              <label for="validasi" class="form-label">Status Akun</label>
              <select name="is_valid" id="is_valid-edit" class="form-control">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="no_wa" class="form-label">Nomor Whatsapp</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon3">+62</span>
                <input type="text" class="form-control" id="no_wa-edit" aria-describedby="basic-addon3" name="no_wa"
                  required>
              </div>
            </div>
            <hr>
          </div>
          <div class="mb-3">
            <label for="inputPassword" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="inputPassword-edit" name="password_baru"
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
$(":input").inputmask();

const edit = (id, nisn, nama_siswa, id_kelas, halaqoh, nama_orang_tua, nik, is_valid, status_halaqoh, no_wa,
  id_orang_tua) => {
  $('#id_siswa-edit').val(id)
  $('#id_halaqoh-edit').val(halaqoh)
  $('#nama_siswa-edit').val(nama_siswa)
  $('#nisn-edit').val(nisn)
  $('#id_kelas-edit option').each(function() {
    if ($(this).val() == id_kelas) {
      $(this).attr('selected', '');
    }
  });
  $('#halaqoh-edit option').each(function() {
    if ($(this).val() == halaqoh) {
      $(this).attr('selected', '');
    }
  });
  $('#nama_orang_tua-edit').val(nama_orang_tua)
  $('#nik-edit').val(nik)
  $('#is_valid-edit option').each(function() {
    if ($(this).val() == is_valid) {
      $(this).attr('selected', '');
    }
  });
  $('#status_halaqoh').text(status_halaqoh);

  $('#no_wa-edit').val(no_wa)
  $('#id_orang_tua-edit').val(id_orang_tua)

  if (nama_orang_tua == '') {
    $('#dataOrangTua').attr('hidden', 'hidden');
  } else {
    $('#dataOrangTua').removeAttr('hidden');
  }

  $('#edit').modal('show')
};
</script>

<?= $this->endSection(); ?>