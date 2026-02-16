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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-gray col-md-12 text-center">
                                <h2 style="margin-bottom: 5px;"><b>TERIMA KASIH</b></h2>
                                <h2 style="margin-top: 5px;"><b>Anda telah selesai mengerjakan materi</b></h2>
                                
                                <div class="col-md-12" style="display: flex;justify-content: center;margin-top:10px;padding-bottom:20px;">
                                    <a href="<?= base_url() ?>" class="btn btn-primary">Kembali</a>
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

    <script>
        $(document).ready(function(){
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var areaChartData = {
            labels  : <?= json_encode($kolom) ?>,
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
                  data                : [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60],
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
                  data                : [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60]
                },
              ]
          }
          
            
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                }
                }
            }

            new Chart(barChartCanvas, {
              type: "line",
              data: barChartData,
              options: barChartOptions
            })

        });
        
    </script>
</body>

</html>