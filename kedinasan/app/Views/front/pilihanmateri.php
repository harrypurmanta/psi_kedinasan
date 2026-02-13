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
                                    if ($group[0]->group_soal_id == 1) {
                                        echo " <p style='text-align:center;font-size:20px;'>Jawablah Setiap Pertanyaan dengan jujur, sesuai dengan kenyataan yang ada pada diri anda sendiri.</p>";
                                    } else if ($group[0]->group_soal_id == 2) {
                                        echo "<p style='text-align:center;font-size:20px;margin:20px;'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling  tepat!</p>";
                                    } else if ($group[0]->group_soal_id == 3) {
                                        echo "<p style='text-align:center;font-size:20px;margin:20px;'>Soal terdiri dari 10 kolom, dimana setiap kolom ada batas waktu 1 menit. Pilihlah (angka,huruf,symbol) yang hilang dari soal. Gunakan waktu sebaik mungkin dalam pengerjaannya.</p>";
                                    } else if ($group[0]->group_soal_id == 4) {
                                        echo "<p style='text-align:center;font-size:20px;margin:20px;'>Perhatikan gambar dibawah ini, kemudian pilihlah karakter jawaban yang paling tepat dari beberapa pilihan jawaban yang tersedia.</p>";
                                    }
                                ?>
                                <p>Saat anda klik tombol <b><i>Mulai</i></b>, Maka akan langsung masuk ke Pengerjaan soal Selamat Mengerjakan</p>
                                <?php
                                    if ($group[0]->group_soal_id == 4) {
                                        echo "<a href='".base_url()."/tryout/sikapkerja/".$materi_id."/".$group[0]->group_soal_id."' class='btn btn-success' style='font-size:18px;'>Mulai</a>";
                                    } else {
                                        echo "<a href='".base_url()."/tryout/ujian/".$materi_id."/".$group[0]->group_soal_id."' class='btn btn-success' style='font-size:18px;'>Mulai</a>";
                                    }
                                ?>
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