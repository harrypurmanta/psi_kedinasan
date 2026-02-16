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
                                <h3 style="padding-top:10px;"><b>Petunjuk Pengerjaan Soal</b></h3>
                                <h3 style="text-decoration: underline;"><b><?= $group[0]->group_nm ?></b></h3>
                                
                                <?php
                                    if ($group[0]->group_soal_id == 10) {
                                        echo "<p style='text-align:center;font-size:20px;margin:20px;'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling  tepat!</p>";
                                    } else  {
                                        echo "<p style='text-align:center;font-size:20px;margin:20px;'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling  tepat!</p>";
                                    }
                                ?>
                                <p>Saat anda klik tombol <b><i>Mulai</i></b>, Maka akan langsung masuk ke Pengerjaan soal Selamat Mengerjakan</p>
                                <?php
                                    if ($group[0]->group_soal_id == 10) {
                                        echo "<a onclick='showtoken(".$group[0]->group_soal_id.", ".$materi_id.")' href='#' class='btn btn-success' style='font-size:18px;'>Mulai</a>";
                                    } else {
                                        echo "<a onclick='showtoken(".$group[0]->group_soal_id.", ".$materi_id.")' href='#' class='btn btn-success' style='font-size:18px;'>Mulai</a>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal fade" id="modal-token">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <!-- <h4>Masukkan Token</h4> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal_body" class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input class="form-control" type="text" name="token" id="token" placeholder="Masukkan Token" maxlength="6" minlength="6" autocomplete="off">
                                        <input class="form-control" type="hidden" name="group_idx" id="group_idx">
                                        <input class="form-control" type="hidden" name="materi_id" id="materi_id">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button style="margin-top: 25px;" class="btn btn-primary" type="button" onclick="checktoken()">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        function showtoken(group_id, materi_id) {
            $("#token").val("");
            $("#group_idx").val(group_id);
            $("#materi_id").val(materi_id);
            $("#modal-token").modal("show");
        }

        function checktoken() {
            var token = $("#token").val();
            var group_id = $("#group_idx").val();
            var materi_id = $("#materi_id").val();
            $.ajax({
                url: "<?= base_url('token/checktoken') ?>",
                type: "post",
                dataType: "json",
                data: {
                    "token": token,
                    "group_id": group_id,
                    "materi_id": materi_id
                },
                beforeSend: function() {
                    $("#loader-wrapper").removeClass("d-none");
                },
                success: function(data) {
                    if (data == "sukses") {
                        if (group_id == 10) {
                            window.location.href = "<?= base_url() ?>/tryout/ujianPauli/"+materi_id+"/"+group_id;
                        } else {
                            window.location.href = "<?= base_url() ?>/tryout/ujian/"+materi_id+"/"+group_id;
                        } 
                    } else {
                        alert("Token salah/tidak ada, hubungi administrator");
                    }
                    $("#loader-wrapper").addClass("d-none");
                },
                error: function() {
                    alert("Error");
                    $("#loader-wrapper").addClass("d-none");
                }
            });
        }
    </script>
</body>

</html>