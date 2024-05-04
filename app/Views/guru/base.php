<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Guru Panel</title>
  <link href="/panel/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>node_modules/toastr/build/toastr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
  <?= $this->include('guru/layouts/navbar'); ?>
  <div id="layoutSidenav"
    style="background: url('<?= base_url('bg.jpg') ?>') center center/cover no-repeat fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
    <?= $this->include('guru/layouts/sidebar'); ?>
    <div id="layoutSidenav_content">
      <main>
        <?= $this->renderSection('content'); ?>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; JULTDEV 2024</div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url(); ?>node_modules/datatables.net/js/dataTables.min.js"></script>
  <script src="<?= base_url(); ?>node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= base_url(); ?>node_modules/toastr/build/toastr.min.js"></script>
  <script src="<?= base_url(); ?>node_modules/inputmask/dist/inputmask.js"></script>
  <script src="<?= base_url(); ?>jspdf/examples/libs/jspdf.umd.js"></script>
  <script src="<?= base_url(); ?>jspdf/dist/jspdf.plugin.autotable.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="<?= base_url() ?>panel/js/scripts.js"></script>

  <script type="text/javascript">
  let table = new DataTable('#datatables');
  $('.select2').select2({
    dropdownParent: $('#surahParent'),
    // theme: 'bootstrap-5',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('col-12') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
  });


  // $(document).ready(function() {
  //   
  // });
  </script>

  <?= $this->renderSection('script'); ?>

  <script>
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  </script>

  <?php
  if (session()->getFlashdata('dataMessage')) {
    foreach (session()->getFlashdata('dataMessage') as $item) {
      echo '<script>toastr["' .
        session()->getFlashdata('type-status') . '"]("' . $item . '")</script>';
    }
  }
  if (session()->getFlashdata('message')) {
    echo '<script>toastr["' .
      session()->getFlashdata('type-status') . '"]("' . session()->getFlashdata('message') . '")</script>';
  }
  ?>
</body>

</html>