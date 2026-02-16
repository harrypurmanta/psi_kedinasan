<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bagian Psikologi Polda Sumsel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12" style="height: 400px;">
                            <div class="bg-gray col-md-8 text-center" style="top: 50%;left: 50%;transform: translate(-50%, -50%);height: 300px;">
                                <h3 style="padding-top:10px;"><b>Petunjuk Pengerjaan Soal</b></h3>
                                <p>Pada Materi ini, Anda harus menjumlahkan angka yang tampil pada layar, Untuk Menjawab soal tersebut, klik pada pilihan 0 sampai 9. 
                                jika hasil penjumlahan hasil nya 2 angka, maka pilihlah angka di belakang nya. 
                                contoh : 
                                6 + 4 = 10 ,anda cukup memilih angka 0, jika 7 + 7 = 14 , anda cukup memilih angka 4 nya saja.
                                Selamat Mengerjakan</p>
                                <p>Anda bisa menekan tombol angka pada <b>KEYBOARD</b> atau menekan angka pada layar</p>
                                <a href='<?= base_url() ?>/pauli/ujian/<?= $request->uri->getSegment(3) ?>/<?= $request->uri->getSegment(4) ?>' class='btn btn-success' style='font-size:18px;'>Mulai</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?= $this->include('front/footer') ?>
    </div>
    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
</body>

</html>