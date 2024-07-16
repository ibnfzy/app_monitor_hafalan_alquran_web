<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>
<!-- CODE HERE -->
<div class="owl-carousel owl-theme container-fluid">
  <?php foreach ($data as $item) : ?>
  <div class="item">
    <img src="/uploads/<?= $item['gambar'] ?>" class="" style="width: 90%;" alt="" srcset="">
  </div>
  <?php endforeach ?>
</div>
<?= $this->endSection(); ?>