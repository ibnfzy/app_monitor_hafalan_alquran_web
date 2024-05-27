<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<?php $db = db_connect(); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Halaqoh <?= $dataHalaqoh['halaqoh']; ?> | Halaman Hafalan</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" onclick="history.back()">Kembali</button>
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
            <th>Kehadiran Hari ini</th>
            <th>Total Kehadiran</th>
            <th>Total Izin</th>
            <th>Total Sakit</th>
            <th>Total Alpa</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php $status = [
            'Hadir',
            'Izin',
            'Sakit',
            'Alpa'
          ]; ?>

          <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['nisn'] ?></td>
            <td><?= $item['nama_siswa'] ?></td>
            <td><?= $item['kelas'] ?></td>
            <td>
              <?php
                $absensi = $db->table('absensi')
                  ->where('id_siswa', $item['id_siswa'])
                  ->where('tanggal', date('Y-m-d'))
                  ->get()
                  ->getRow();
                $id_absensi = $db->table('absensi')
                  ->select('id_absensi')
                  ->where('id_siswa', $item['id_siswa'])
                  ->where('tanggal', date('Y-m-d'))
                  ->get()
                  ->getRow()->id_absensi ?? null;
                if ($absensi === null) : ?>
              <button class="btn btn-warning col-12" onclick="absensi('<?= $item['id_siswa'] ?>')">Belum Absen Hari
                ini</button>
              <?php else :
                  switch ($absensi->keterangan) {
                    case 'Hadir':
                      $class = 'success';
                      break;
                    case 'Izin':
                    case 'Sakit':
                      $class = 'warning';
                      break;
                    case 'Alpa':
                      $class = 'danger';
                      break;
                  } ?>
              <button class="btn btn-<?= $class ?> col-12"
                onclick="absensi_edit('<?= $item['id_siswa'] ?>', '<?= $id_absensi ?>', '<?= $absensi->keterangan ?>')"><?= ucwords($absensi->keterangan) ?></button>
              <?php endif ?>
            </td>

            <?php
              $hafalan = $db->table('absensi')
                ->where('id_siswa', $item['id_siswa'])
                ->where('id_kelas', $item['id_kelas'])
                ->get()
                ->getResultArray();
              foreach ($status as $s) {
                $count = count(array_filter($hafalan, function ($h) use ($s) {
                  return $h['keterangan'] == $s;
                }));
                echo "<td>$count</td>";
              }
              ?>

            <td>
              <a href="/GuruPanel/Absensi/PDF/<?= $item['id_siswa'] ?>" class="btn btn-danger">PDF</a>
              <button class="btn btn-primary"
                onclick="absensi_kelola('<?= $item['id_siswa'] ?>', '<?= $item['nama_siswa'] ?>')">Kelola
                Absensi</button>
            </td>
          </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="absensi-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Absensi</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/Absensi/Update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_siswa" id="id_siswa-edit">
        <input type="hidden" name="id_absensi" id="id_absensi-edit">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru" class="form-label">Absensi</label>
            <select name="absensi" id="absensis-edit" class="form-control">
              <option value="Hadir" class="text-bg-success">1. Hadir</option>
              <option value="Izin" class="text-bg-warning">2. Izin</option>
              <option value="Sakit" class="text-bg-warning">3. Sakit</option>
              <option value="Alpa" class="text-bg-danger">4. Alpa</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control text-bg-secondary" id="tanggal-edit" name="tanggal"
              value="<?= date('Y-m-d'); ?>" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="absensi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Absensi</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/GuruPanel/Absensi" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_siswa" id="id_siswa">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_guru" class="form-label">Absensi</label>
            <select name="absensi" id="absensi" class="form-control">
              <option value="Hadir" class="text-bg-success">1. Hadir</option>
              <option value="Izin" class="text-bg-warning">2. Izin</option>
              <option value="Sakit" class="text-bg-warning">3. Sakit</option>
              <option value="Alpa" class="text-bg-danger">4. Alpa</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control text-bg-secondary" id="tanggal" name="tanggal"
              value="<?= date('Y-m-d'); ?>" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="kelolaAbsensi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h1 class="modal-title fs-5 text-white" id="titleAbsensiSiswa">Kelola Absensi</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-responsive table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="dataAbsensi">

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
const absensi_kelola = (id_siswa, nama_siswa) => {
  $('#titleAbsensiSiswa').text('Absensi ' + nama_siswa)
  $.ajax({
    type: "GET",
    url: "/GuruPanel/Absensi/Detail/" + id_siswa,
    dataType: "json",
    success: function(data) {
      $('#dataAbsensi').empty();
      if (data.length > 0) {
        $.each(data, function(index, item) {
          $('#dataAbsensi').append('<tr>' +
            '<td>' + (index + 1) + '</td>' +
            '<td>' + item.tanggal + '</td>' +
            '<td>' + item.keterangan + '</td>' +
            '<td>' + '<a class="btn btn-danger" href="/GuruPanel/Absensi/Delete/' + item.id_absensi +
            '">Hapus</a>' + '</td>' +
            '</tr>');
        });
      } else {
        $('#dataAbsensi').append('<tr><td colspan="3">DATA KOSONG</td></tr>');
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Error: " + errorThrown);
    }
  });

  $('#kelolaAbsensi').modal('show');
}

const absensi = (id_siswa) => {
  $('#id_siswa').val(id_siswa)
  $('#absensi').modal('show')
};

const absensi_edit = (id_siswa, id_absensi, keterangan) => {
  $('#id_siswa-edit').val(id_siswa)
  $('#id_absensi-edit').val(id_absensi)
  $('#absensis-edit option').each(function() {
    if ($(this).val() == keterangan) {
      $(this).attr('selected', 'selected');
    }
  });
  $('#absensi-edit').modal('show')
};
</script>

<?= $this->endSection(); ?>