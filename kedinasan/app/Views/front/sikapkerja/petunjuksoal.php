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
                        <div class="col-md-12" style="display: flex;justify-content: center;margin-bottom:20px;">
                            <h2><b>PETUNJUK PENGERJAAN</b></h2>
                        </div>
                        <div class="col-md-12">
                            <div class="col-lg-12" style="text-align:center;min-height: 400px;color:#000000;">
                                <h4><b>Sebelum mengerjakan tes, bacalah petunjuk pengerjaan tes ini dengan seksama.</b>
                                </h4>
                                <p style="text-align:justify;font-size:18px;margin:18px;">Pada tes sikap kerja ini, anda
                                    akan dihadapkan pada lima deret(angka/huruf/simbol) yang di pasangkan dengan huruf
                                    A, B, C, D dan E. yang terbagi dalam 10 kolom dimana masing-masing kolom
                                    memiliki pola deret yang berbeda-beda. Sebagai contoh seperti terlihat pada contoh
                                    dibawah ini :</p>
                                <div style="text-align:center;">
                                    <table align="center" border="2" style="width:50%;">
                                        <thead>
                                            <tr>
                                                <th colspan="5">Kolom 1</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>∑</td>
                                                <td>4</td>
                                                <td>7</td>
                                                <td>V</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">A</td>
                                                <td style="font-weight:bold;">B</td>
                                                <td style="font-weight:bold;">C</td>
                                                <td style="font-weight:bold;">D</td>
                                                <td style="font-weight:bold;">E</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <p style="text-align:justify;font-size:18px;margin:18px;">Pada baris bawah huruf A, B,
                                    C, D dan E adalah pilihan jawaban nya dan pada baris atas yang berisi deret
                                    (angka/huruf/simbol) adalah pasangannya sebagai berikut.</p>
                                <ul style="list-style-type: none;font-size:18px;">
                                    <li>Pilihan jawaban <b>A</b> dipasangkan dengan simbol <b>∑</b></li>
                                    <li>Pilihan jawaban <b>B</b> dipasangkan dengan angka <b>4</b></li>
                                    <li>Pilihan jawaban <b>C</b> dipasangkan dengan angka <b>7</b></li>
                                    <li>Pilihan jawaban <b>D</b> dipasangkan dengan huruf <b>V</b></li>
                                    <li>Pilihan jawaban <b>E</b> dipasangkan dengan huruf <b>X</b></li>
                                </ul>

                                <p style="text-align:justify;font-size:18px;margin:18px;">Kemudian pada persoalan, anda
                                    akan diberikan 4 deret (angka/huruf/simbol). Tugas anda adalah
                                    menemukan simbol/huruf/angka yang hilang pada setiap soal tersebut. Kemudian
                                    pilihlah <b>satu
                                        jawaban</b> diantara <b></b>lima pilihan jawaban</b> yang sesuai dengan pasangan
                                    yang hilang tersebut.</p>


                                <div style="text-align:center;">
                                    <h4><b>Contoh :</b></h4>
                                    <table align="center" border="2" style="width:50%;">
                                        <thead>
                                            <tr>
                                                <th colspan="5">Kolom 1</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>∑</td>
                                                <td>4</td>
                                                <td>7</td>
                                                <td>V</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold;">A</td>
                                                <td style="font-weight:bold;">B</td>
                                                <td style="font-weight:bold;">C</td>
                                                <td style="font-weight:bold;">D</td>
                                                <td style="font-weight:bold;">E</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div style="text-align:center;margin-top:20px;">
                                    <table align="center" border="1" style="width:40%;">
                                        <tbody>
                                            <tr>
                                                <td>4</td>
                                                <td>∑</td>
                                                <td>7</td>
                                                <td>V</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div style="text-align:center;margin-top:20px;">
                                    <table align="center" border="2" style="width:50%;">
                                        <tbody>
                                            <tr>
                                                <td style="font-weight:bold;">A</td>
                                                <td style="font-weight:bold;">B</td>
                                                <td style="font-weight:bold;">C</td>
                                                <td style="font-weight:bold;">D</td>
                                                <td style="font-weight:bold;">E</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <p style="text-align:justify;font-size:18px;margin:18px;">Dari 4 deret
                                    (angka/huruf/simbol) tersebut, huruf X tidak ada pada soal tersebut. Karena huruf X
                                    berpasangan dengan pilihan jawaban e, maka pilihlah <b>jawaban e</b> pada pilihan
                                    jawaban yang disediakan.</p>

                                <h4 style="text-align:justify;font-size:18px;margin:18px;"><b>Hal-hal yang perlu anda
                                        perhatikan dalam mengerjakan tes sikap kerja ini adalah:</b></h4>

                                <div>
                                    <ul style="list-style-type: number;text-align:justify;font-size:18px;">
                                        <li>Setiap kolom memiliki waktu pengerjaan masing-masing dan jika waktu sudah
                                            habis maka secara otomatis akan berpindah ke kolom berikutnya.</li>
                                        <li>Setelah anda menjawab, secara otomatis soal akan berpindah ke kolom
                                            berikutnya.</li>
                                        <li>Tes ini mengharapakan anda bekerja dengan cepat dan cermat.</li>
                                    </ul>
                                </div>
                                <div style="margin-top:18px;text-align:cennter;">
                                    <h2>Selamat Mengerjakan</h2>
                                </div>

                                <div style="margin-top:20px;text-align:cennter;"><a style="font-size: 30px;"
                                        class="btn btn-primary" href="<?= base_url() ?>/sikapkerja/ujian/<?= $request->uri->getSegment(3) ?>">Mulai</a></div>

                            </div>";
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