<?php
$this->session = \Config\Services::session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">


</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>
        <!-- Content Wrapper. Contains page content -->
        <div id="contentwrapper" class="content-wrapper" style="background-color: #00000052;">
            <div class="content" style="padding-top: 30px;">
                <div class="container" style="padding:0px;min-width: 90%;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="card" class="card" style="background-color: #00000052;">
                                <div class="card-body">
                                    <span id="countdown" style='float:right;font-size:40px;color:#000000;'></span>
                                    <div id="cardbody">
                                        <!-- END ID CARDBODY -->
                                        <div class="row" style="min-height:400px;">
                                            <div class="col-lg-12">
                                                <div style="text-align:center;">
                                                    <h1 style="color:white;">SELAMAT DATANG</h1>


                                                </div>
                                            </div><!-- END ID 12 -->
                                        </div><!-- END ID row -->
                                    </div><!-- END ID CARDBODY -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
    </div>
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/plugins/chart.js/Chart.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
</body>
</html>