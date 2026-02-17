<?php
$request = \Config\Services::request();
?>
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
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-gray col-md-12 text-center" style="padding-bottom:20px;margin-top:50px;">
                                <h2 style="margin-top: 35px;"><b>Nilai Anda</b></h2>
                                
                                <div class="col-md-12">
                                    <table class="table" style="width:50%; margin:0 auto;">
                                        <th>
                                            <tr>
                                                <th class="text-center">Paket</th>
                                                <th class="text-center">Benar</th>
                                                <th class="text-center">Salah</th>
                                            </tr>
                                        </th>
                                        <body>
                                            <?php
                                                foreach ($hasil as $h) {
                                                    $paket = $h->group_nm;
                                                    $benar = $h->total_benar;
                                                    $salah = $h->total_salah;
                                            ?>
                                            <tr>
                                                <td><?= $paket ?></td>
                                                <td><?= $benar ?></td>
                                                <td><?= $salah ?></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </body>
                                    </table>
                                </div>
                                <div class="row">
                        <div class="col-md-12 text-center">
                            <button onclick="kirimemail()" class="btn btn-success">Kirim Email</button>
                        </div>
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
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>
    <script>
        function kirimemail() {
            let materi = <?= $request->uri->getSegment(3) ?>;
            let group_id = <?= $request->uri->getSegment(4) ?>;
            $.ajax({
                url: "<?= base_url('tryout/kirimemail') ?>",
                type: "post",
                dataType: "json",
                data: {
                    "group_id": group_id,
                    "materi": materi
                },
                beforeSend: function() {
                    $("#loader-wrapper").removeClass("d-none")
                },
                success: function(data) {
                    if (data) {
                        Swal.fire("Berhasil", "Email berhasil dikirim", "success");
                    } else {
                        Swal.fire("Gagal", "Email gagal dikirim", "error");
                    }
                    $("#loader-wrapper").addClass("d-none")
                },
                error: function() {
                    alert("Error system");
                }
            });
        }
    </script>
</body>
</html>