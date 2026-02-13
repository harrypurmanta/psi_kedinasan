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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-gray text-center">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div><h2>HASIL PENILAIAN</h2></div><hr>
                                        <p style='margin:10px;font-size:18px;'>Nilai yang tampil merupakan hasil dari jumlah soal yang terjawab, dan bukan merupakan bobot penilaian seperti saat tes sesungguhnya.</p>
                                    </div>
                                    </div>
                                    <?php
                                    $kolom_nm = [];
                                    $soal_terjawab_chart = [];
                                    $jawaban_benar_chart = [];
                                    
                                    ?>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body" style="display: flex;justify-content: center;margin-top:10px;">
                                            <div class="col-md-6" style="display: flex;justify-content: center;margin-top:10px;padding-bottom:20px;padding-top:20px;background-color:white;">
                                            <table border="1" style="width:80%;margin:0 auto;line-height: 2;border: black;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Kolom</th>
                                                        <th class="text-center">Soal Terjawab</th>
                                                        <th class="text-center text-info">Benar</th>
                                                        <th class="text-center text-danger">Salah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $db = db_connect();
                                                        $request = \Config\Services::request();
                                                        $this->session = \Config\Services::session();
                                                        foreach ($kolom as $kkolom) {
                                                            $kolom_nm[] = $kkolom->kolom_nm;
                                                            $benar = 0;
                                                            $salah = 0;
                                                            $soal_terjawab = 0;
                                                            $query = $db->query("SELECT *,a.pilihan_nm AS pilihan_respon FROM respon_latihan a LEFT JOIN soal b ON b.soal_id = a.soal_id LEFT JOIN jawaban c ON c.jawaban_id = a.jawaban_id WHERE a.materi = 98 AND b.sk_group_id = ".$request->uri->getSegment(3)." AND a.created_user_id = ".$this->session->user_id." AND a.used = ".$this->session->used." AND a.kolom_id = $kkolom->kolom_id AND a.group_id = 4")->getResult();

                                                            if (count($query)>0) {
                                                                $soal_terjawab = count($query);
                                                                foreach ($query as $rSK) {
                                                                    // $soal_terjawab = $soal_terjawab + 1;
                                                                    if ($rSK->pilihan_respon == $rSK->kunci) {
                                                                        $benar = $benar + 1;
                                                                    } else {
                                                                        $salah = $salah + 1;
                                                                    }
                                                                }
                                                            } else {
                                                                $soal_terjawab = $soal_terjawab;
                                                            }

                                                            $soal_terjawab_chart[] =  $soal_terjawab;
                                                            $jawaban_benar_chart[] = $benar;
                                                            
                                                    ?>
                                                    <tr>
                                                        <td><?= $kkolom->kolom_nm ?></td>
                                                        <td><?= $soal_terjawab ?></td>
                                                        <td><?= $benar ?></td>
                                                        <td><?= $salah ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class='card'>
                                            <div class='card-body'>
                                            <div class='chart'>
                                                <canvas id='barChart' style='min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;'></canvas>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
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
    <script src="<?= base_url() ?>/plugins/chart.js/Chart.min.js"></script>

    <script>
        $(document).ready(function(){
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var areaChartData = {
            labels  : <?= json_encode($kolom_nm) ?>,
            datasets: [
                {
                  label               : "Jawaban Benar",
                  backgroundColor     : "rgba(40,167,69,1)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius         : false,
                  pointColor          : "#00a65a",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($jawaban_benar_chart) ?>,
                  bezierCurve : false
                },
                {
                  label               : "Soal Terjawab",
                  backgroundColor     : "rgba(60,141,188,0.9)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius         : false,
                  pointColor          : "#3b8bba",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($soal_terjawab_chart) ?>
                },
              ]
          }
          
            
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
            }

            new Chart(barChartCanvas, {
              type: "bar",
              data: barChartData,
              options: barChartOptions
            })
        });
    </script>
</body>

</html>