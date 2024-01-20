<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>
<?php echo $this->session->flashdata('verification'); ?>

<body class="bg-gradient-info">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-5 col-lg-7 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                <img src="<?php echo base_url('assets/images/banner/01.jpg')?>" width="380" height="100">
                <p class="text-center">REGISTER USER !</p>
                  <?php echo $this->session->flashdata('failed'); ?>
                  <form action="<?= base_url(); ?>register" method="post">
                      <div class="form-group">
                      <label for="username">Nama</label>
                          <input type="text" placeholder="Nama Lengkap"  name="name" class="form-control"  autocomplete="off" value="<?php echo set_value('name'); ?>">
                          <small class="form-text text-danger pl-1"><?php echo form_error('name'); ?></small>
                      </div>
                      <div class="form-group">
                      <label for="username">Email</label>
                          <input type="email" placeholder="Alamat Email"  name="email" class="form-control"  autocomplete="off" value="<?php echo set_value('email'); ?>">
                          <small class="form-text text-danger pl-1"><?php echo form_error('email'); ?></small>
                      </div>
                      <div class="form-group">
                      <label for="username">Password</label>
                          <input type="password" placeholder="Password"  name="password" class="form-control"  autocomplete="off">
                          <small class="form-text text-danger pl-1"><?php echo form_error('password'); ?></small>
                      </div>
                      <div class="form-group">
                      <label for="username">Password</label>
                          <input type="password" placeholder="Konfirmasi Password"  name="password1" class="form-control"  autocomplete="off">
                          <small class="form-text text-danger pl-1"><?php echo form_error('password1'); ?></small>
                      </div>
                      <button type="submit" class="btn btn-block btn-info mt-3">Daftar</button>
                      <p class="text-lead">Atau sudah punya akun? <a href="<?= base_url(); ?>login">Login</a> sekarang</p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

    <?php if($this->session->flashdata('success')){ ?>
    <div class="modal fade" id="modalRegisterSuccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Registrasi Berhasil</h5>
          </div>
          <div class="modal-body">
            <a href="<?= base_url(); ?>login" class="btn btn-block btn-danger">Ke halaman login</a>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

</body>

</html>
