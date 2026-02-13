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
                        <div class="col-md-12">
                            <div class="bg-gray col-md-12 text-center">
                                <h3 style="margin-bottom: 5px;"><b>Selamat</b></h3>
                                <h2 style="margin-top: 5px;"><b>SKOR ANDA</b></h2>
                                <?php
                                    if ($total_skor >= 61) {
                                        $style = "color:green;";
                                    } else {
                                        $style = "color:red;";
                                    }
                                ?>
                                <label style="font-size:72px;<?= $style ?>"><?= $total_skor ?></label><br>
                                <?php
                                    if ($total_skor >= 61) {
                                        echo "<label style='color:green'>(Memenuhi Syarat - MS)</label>";
                                    } else {
                                        echo "<label style='color:red'>(Tidak Memenuhi Syarat - TMS)</label>";
                                    }
                                ?>
                                <div class="col-md-12" style="display: flex;justify-content: center;margin-top:10px;padding-bottom:20px;">
                                    <table class="table" style="width:80%;marign:0 auto;">
                                        <body>
                                            <tr><td style="font-size:25px;text-align:left;font-weight:bold;border-top:1px solid black;">Passhand</td><td style="font-size:25px;text-align:center;font-weight:bold;border-top:1px solid black;">-</td></tr>
                                            <tr><td style="font-size:25px;text-align:left;font-weight:bold;border-top:1px solid black;">Kecerdasan</td><td style="font-size:25px;text-align:center;font-weight:bold;border-top:1px solid black;"><?= $persen_kec ?></td></tr>
                                            <tr><td style="font-size:25px;text-align:left;font-weight:bold;border-top:1px solid black;">Kepribadian</td><td style="font-size:25px;text-align:center;font-weight:bold;border-top:1px solid black;"><?= $persen_kep ?></td></tr>
                                            <tr><td style="font-size:25px;text-align:left;font-weight:bold;border-top:1px solid black;border-bottom:1px solid black;">Sikap Kerja</td><td style="font-size:25px;text-align:center;font-weight:bold;border-top:1px solid black;border-bottom:1px solid black;"><?= $persen_sk ?></td></tr>
                                        </body>
                                    </table>
                                </div>
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