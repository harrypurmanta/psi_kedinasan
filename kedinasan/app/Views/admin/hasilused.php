<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Pages</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
<?= $this->include('admin/navbar') ?>
<!-- Content Wrapper. Contains page content -->
<div id="contentwrapper" class="content-wrapper" style="background-color: rgb(88, 129, 87);">

<!-- Main content -->
<div class="content" style="padding-top: 30px;">
  <div class="container" style="padding:0px;min-width: 90%;">
    <div class="row">
      <div class="col-lg-12">
        <div id="card" class="card" style="background-color: rgb(218, 215, 205);">
          <div class="card-body">
            <div id="cardbody"><!-- END ID CARDBODY -->
    
<div>
  <?= $ret; ?>
</div>

            </div><!-- END ID CARDBODY -->
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/plugins/chart.js/Chart.min.js"></script>
<script src="<?= base_url() ?>/dist/dist/js/adminlte.min.js"></script>
<script>
var barChartCanvas = $("#barChart").get(0).getContext("2d")
            var areaChartData = {
            labels  : <?= json_encode($kolom_nm) ?>,
            datasets: [
                {
                  label               : "Jawaban Benar",
                  backgroundColor     : "rgba(60,141,188,0.9)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius          : false,
                  pointColor          : "#3b8bba",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($jawaban_benar_chart)?>,
                  bezierCurve : false
                },
                {
                  label               : "Soal Terjawab",
                  backgroundColor     : "rgba(210, 214, 222, 1)",
                  borderColor         : "rgba(210, 214, 222, 1)",
                  pointRadius         : false,
                  pointColor          : "rgba(210, 214, 222, 1)",
                  pointStrokeColor    : "#c1c7d1",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data                : <?= json_encode($soal_terjawab_chart)?>
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
            });
  
</script>
</body>
</html>

