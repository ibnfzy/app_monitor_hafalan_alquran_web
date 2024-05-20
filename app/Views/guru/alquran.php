<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Tabel Surah Al-Quran</h1>
  <ol class="breadcrumb mb-4">
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-bordered" id="datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Surah</th>
            <th>Jumlah Ayat</th>
            <th>Deskripsi</th>
            <th>Audio</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $item) : ?>
            <tr>
              <td><?= $i = $key + 1; ?></td>
              <td class="vstack"><span><?= $item['nama'] ?></span> <span><?= $item['nama_latin'] ?></span>
                <span><?= $item['arti']; ?></span>
              </td>
              <td><?= $item['jumlah_ayat'] ?></td>
              <td><?= $item['deskripsi'] ?></td>
              <td>
                <audio controls preload="none">
                  <source src="<?= $item['audio'] ?>" type="audio/mpeg">
                  browser anda tidak support pemutar audio
                </audio>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>