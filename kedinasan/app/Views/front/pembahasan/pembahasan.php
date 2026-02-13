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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
                        <div class="col-md-12">
                            <div class="col-md-12" style="display: flex;justify-content: center;margin-bottom:20px;">
                                <h2><b>PEMBAHASAN</b></h2>
                            </div>
                            <div class="col-md-12">
                                <?php
                                foreach ($materi as $key) {
                                    if ($key->materi_id == 1) {
                                        $group_id = 2;
                                    } else {
                                        $group_id = 2;
                                    }
                            ?>
                                <div class="col-lg-3" style="width: 20%;border-radius:10px;">
                                    <div class="small-box bg-gray" style="border-radius:10px;">
                                        <div class="inner text-center">
                                            <h3 style="font-size: 24px;"><?= str_replace("Materi", "Pembahasan", $key->materi_nm);  ?></h3>
                                        </div>
                                        <a href="<?= base_url() ?>/pembahasan/pilihanmateri/<?= $key->materi_id ?>/<?= $group_id ?>"
                                            class="small-box-footer" style="color:black;">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
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