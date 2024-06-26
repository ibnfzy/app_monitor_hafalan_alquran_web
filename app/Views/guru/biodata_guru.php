<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<?php
$db = db_connect();
$jenisKelamin = ($dataGuru['jenis_kelamin'] == 'Perempuan') ? 'Ibu ' : 'Bapak ';
?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Panel Guru</h1>
  <ol class="breadcrumb mb-4 btn-group col-4">
    <button class="btn btn-primary shadow-lg" onclick="">Edit Biodata</button>
    <button class="btn btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#photo">Ubah Foto</button>
    <button class="btn btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#password">Ubah Pasword</button>
  </ol>
  <div class="row">
    <div class="col-3 col-md-3 my-2">
      <div class="card my-1">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img width="100" class="profile-user-img img-fluid img-circle" src="/uploads/users.png"
                alt="User profile picture">
            </div>

            <h3 class="profile-username text-center"><?= $jenisKelamin . session()->get('nama_guru'); ?></h3>

            <p class="text-muted text-center">Guru</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Kelas</b> <span class="float-end"><?= $dataKelasGuru; ?></span>
              </li>
              <li class="list-group-item">
                <b>Murid</b> <span class="float-end"><?= $dataSiswa; ?></span>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Biodata</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i> NIP</strong>

          <p class="text-muted">
            <?= $dataGuru['nip']; ?>
          </p>

          <hr>

          <strong><i class="fas fa-map-marker-alt mr-1"></i> Kontak</strong>

          <p class="text-muted"><?= $dataGuru['kontak']; ?></p>

        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-9 col-md-9 my-2">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered" id="datatables">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Kelas</th>
                <th>Nama Guru</th>
                <th>Jumlah Murid</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $item) : ?>
              <?php $getJumlahMurid = $db->table('siswa')->where('id_kelas', $item['id_kelas'])->countAllResults(); ?>
              <tr>
                <td><?= $key + 1; ?></td>
                <td><?= $item['nama_kelas'] ?></td>
                <td><?= $item['nama_guru'] ?></td>
                <td><?= $getJumlahMurid ?></td>
                <td>
                  <div class="btn-group">
                    <a href="/GuruPanel/<?= $item['id_kelas'] ?>" class="btn btn-primary">Hafalan</a>
                    <a href="/GuruPanel/Absensi/<?= $item['id_kelas'] ?>" class="btn btn-primary">Absensi</a>
                  </div>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="photo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Foto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/Foto" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru" class="form-label">Foto Baru</label>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpg, image/jpeg, image/png">
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

<div class="modal fade" id="password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/Password" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
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

<div class="modal fade" id="edit_biodata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/Guru" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="nama_guru-edit" name="nama_guru">
          </div>
          <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip-edit" name="nip">
          </div>
          <div class="mb-3">
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" id="kontak-edit" name="kontak">
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
const editBiodata = (nama_guru, nip, kontak) => {
  $('#nama_guru-edit').val(nama_guru)
  $('#nip-edit').val(nip)
  $('#kontak-edit').val(kontak)
  $('#edit_biodata').modal('show')
};
</script>

<?= $this->endSection(); ?>