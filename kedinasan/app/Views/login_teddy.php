<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
  <style>
    </style>
</head>
<body class="hold-transition login-page">
    
<div style="background-image: url(images/bg/bglogin1.jpg);background-size: cover;height: 100%;position: relative;top: 0;background-position: center center !important;z-index: 1;width: 100%;background-repeat: no-repeat;">

<div class="login-box" style="position: absolute;top: 35%;left: 40%;margin: -50px 0 0 -50px;">
<!-- /.login-logo -->
<div class="card card-outline card-primary" style="background-color: #00000052;">
  <div class="card-header text-center" style="color:#ffffff;font-size:20px;">
    <b>Login</b>
  </div>
  <div class="card-body">
    <p class="login-box-msg" style="color:#ffffff;font-size:20px;">Sign in to start your session</p>

    <form action="<?= base_url() ?>/login/checklogin" method="post">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Username" name="username">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          <a href="login/register"><button style="margin-top:10px;" type="button" class="btn btn-secondary btn-block">Register</button></a>
        </div>
        <!-- /.col -->
      </div>
    </form>


    <!-- /.social-auth-links -->

  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
</body>
</html>