<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bintang Timur Prestasi</title>
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
                                <h3 style="padding-top:10px;"><b>Petunjuk Pengerjaan</b></h3>
                                <h3><b><?= $jenis->jenis_nm ?></b></h3>
                                <p>
                                 Tes ini terdiri dari 140 soal berupa pernyataan diri. Anda diminta untuk membaca setiap Pernyataan yang ada, lalu 
Pilihlah jawaban yang Anda anggap paling sesuai dengan keadaan/ kondisi diri Anda yang sebenarnya.<br><br>
Tidak ada jawaban yang benar atau salah dalam tes ini, selama jawaban Anda sesuai dengan kondisi Anda yang sesungguhnya. 
Kerjakan seluruhnya, jangan ada yang terlewati.

                                </p>
                                <a href="<?= base_url()."/latihan/tryout/".$group_id."/".$jenis_id ?>" class="btn btn-success" style="font-size:18px;">Mulai</a>
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
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>
</body>
</html>