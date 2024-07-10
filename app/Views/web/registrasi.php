<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Operator Login</title>
  <link href="/panel/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>node_modules/toastr/build/toastr.min.css">
</head>

<body
  style="background: url('<?= base_url('bg.jpg') ?>') center center/cover no-repeat fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container mt-5 mt-md-5 mt-lg-3">
          <?php if (session()->getFlashdata('message')) : ?>
          <div class="row justify-content-center">
            <div class="alert alert-success alert-dismissible fade show col-5" role="alert">
              <?= session()->getFlashdata('message') ?> <br>
              <?php foreach ($dataOperator as $item) : ?>
              <a class="btn text-bg-success" href="https://wa.me/<?= $item['nomor_wa'] ?>" target="_blank">
                <i class="fa-brands fa-whatsapp mx-1"></i>
                Hubungi Operator
                (<?= $item['nama_operator'] ?>)</a> <br>
              <?php endforeach ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <?php endif ?>
          <?php if (session()->getFlashdata('dataMessage')) : ?>
          <div class="row justify-content-center">
            <div class="alert alert-danger alert-dismissible fade show col-5" role="alert">
              Jika anda belum pernah mendaftar, silahkan hubungi operator <br>
              <?php foreach ($dataOperator as $item) : ?>
              <a class="btn text-bg-success" href="https://wa.me/<?= $item['nomor_wa'] ?>" target="_blank">
                <i class="fa-brands fa-whatsapp mx-1"></i>
                Hubungi Operator
                (<?= $item['nama_operator'] ?>)</a> <br>
              <?php endforeach ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <?php endif ?>
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Registrasi Orang Tua Siswa</h3>
                </div>
                <div class="card-body">
                  <form action="/Registrasi" method="post" id="registrasi">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nik" type="text" name="nik"
                        data-inputmask="'mask': '9999999999999999'" required />
                      <label for="nik">NIK</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nama" type="text" name="nama" required />
                      <label for="nama">Nama Orang Tua/Wali</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nisn" type="text" name="nisn"
                        data-inputmask="'mask': '9999999999'" required />
                      <label for="nisn">NISN Siswa</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputPassword" type="password" placeholder="Password"
                        name="password" required />
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputPassword2" type="password" placeholder="Password"
                        name="konfirmasi_password" required />
                      <label for="inputPassword2">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button class="btn btn-primary float-end">Daftar Akun</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="/">Kembali kehalaman Landing</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script src="<?= base_url(); ?>node_modules/toastr/build/toastr.min.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js'
      integrity='sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=='
      crossorigin='anonymous'></script>

    <script src="/panel/js/scripts.js"></script>

    <script>
    // Ketika form registrasi dikirim, cek apakah password dan konfirmasi password sama atau tidak.
    // Jika tidak sama, ubah warna border border input konfirmasi password menjadi merah dan tulis "Password tidak sama" di labelnya.
    // Jika sama, hapus warna border border input konfirmasi password dan tulis "Password" di labelnya.
    // Jika sama, kirim form registrasi tanpa menggunakan fungsi preventDefault().
    $("#registrasi").submit(function(event) {
      event.preventDefault();
      var password = $("#inputPassword").val();
      var konfirmasi_password = $("#inputPassword2").val();
      if (password != konfirmasi_password) {
        $("#inputPassword2").css("border-color", "red");
        $("#inputPassword2").siblings("label").css("color", "red").text("Password tidak sama");
      } else {
        $("#inputPassword2").css("border-color", "");
        $("#inputPassword2").siblings("label").css("color", "").text("Password");
        $("#registrasi").unbind().submit();
      }
    });

    $(":input").inputmask();

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