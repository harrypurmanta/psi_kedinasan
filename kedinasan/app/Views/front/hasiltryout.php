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
<style>
    .chart-wrapper {
        max-width: 800px;   /* atur sesuai kebutuhan */
        height: 350px;
        margin: 40px auto;  /* INI YANG MEMUSATKAN */
    }

    .chart-wrapper canvas {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .switch input { display:none; }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #2563eb;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
  </style>
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
                            <div class="bg-gray col-md-12" style="padding-bottom:20px; position:relative;">
                                <div class="text-right" style="margin-top:10px;">
                                    <button onclick="kirimemail()" class="btn btn-success">
                                        Kirim Email
                                    </button>
                                </div>
                                <h2 class="text-center"><b>Nilai Anda</b></h2>
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <table class="table table-bordered table-striped" style="width:50%; margin:0 auto;">
                                        <thead>
                                                <tr>
                                                    <th class="text-center">Paket</th>
                                                    <th class="text-center">Benar</th>
                                                    <th class="text-center">Salah</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($getRespon as $h) {
                                                    $paket = $h->group_nm;
                                                    $benar = $h->total_benar;
                                                    $salah = $h->total_salah;
                                            ?>
                                            <tr>
                                                <td class="text-left"><?= $paket ?></td>
                                                <td class="text-center"><?= $benar ?></td>
                                                <td class="text-center"><?= $salah ?></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h2 class="text-center"><b>Pauli</b></h2>
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row"><!-- ROW WAJIB -->
                                                <!-- LEMBAR 1 -->
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 1</h3>
                                                    </div>

                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; foreach ($hasil[1] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- LEMBAR 2 -->
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 2</h3>
                                                    </div>

                                                    <table class="table table-bordered table-stripe table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; foreach ($hasil[2] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div><!-- END ROW -->

                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row"><!-- ROW WAJIB -->
                                                <!-- LEMBAR 1 -->
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 3</h3>
                                                    </div>

                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; foreach ($hasil[3] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- LEMBAR 2 -->
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 4</h3>
                                                    </div>

                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; foreach ($hasil[4] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div><!-- END ROW -->

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px;">
                                    <div class="box text-center">
                                        <div class="box-body">
                                            <div class="col-md-12 d-flex justify-content-center align-items-center mb-3 gap-3" style="margin-bottom: 3px;">
                                                <label style="font-weight:bold; margin-right:10px;">Mode Grafik:</label>

                                                <label class="switch mb-0">
                                                    <input type="checkbox" id="toggleMode" checked>
                                                    <span class="slider"></span>
                                                </label>

                                                <span id="modeLabel" style="margin-left: 10px;">
                                                    Per 3 Kolom
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 1</h3></div>
                                                            <canvas id="chart_sk_1"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 2</h3></div>
                                                            <canvas id="chart_sk_2"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 3</h3></div>
                                                            <canvas id="chart_sk_3"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 4</h3></div>
                                                            <canvas id="chart_sk_4"></canvas>
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
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const chartInstances = {};

    const hasil = <?= json_encode($hasil) ?>;

    function buildLabelPer3Kolom(dataSk) {
        const labels = [];

        for (let i = 0; i < dataSk.length; i += 3) {
            const start = dataSk[i].kolom_nm;
            const end   = dataSk[Math.min(i + 2, dataSk.length - 1)].kolom_nm;
            labels.push(`${start}-${end} ●`);
        }

        return labels;
    }

    function buildDataPer3Kolom(dataSk) {
        const values = [];

        for (let i = 0; i < dataSk.length; i += 3) {
            const chunk = dataSk.slice(i, i + 3);
            values.push(
                chunk.reduce((s, x) => s + parseInt(x.terjawab), 0)
            );
        }

        return values;
    }

    function renderChart(sk_group_id, mode = 'group') {

        const dataSk = hasil[sk_group_id];
        if (!dataSk) return;

        const ctx = document
            .getElementById('chart_sk_' + sk_group_id)
            .getContext('2d');

        // destroy jika sudah ada
        if (chartInstances[sk_group_id]) {
            chartInstances[sk_group_id].destroy();
        }

        let labels, datasets;

        if (mode === 'group') {
            labels = buildLabelPer3Kolom(dataSk);
            datasets = [{
                label: 'Terjawab per 3 Kolom',
                data: buildDataPer3Kolom(dataSk),
                borderWidth: 3,
                tension: 0.3
            }];
        } else {
            labels = dataSk.map(i => i.kolom_nm);
            datasets = [{
                label: 'Terjawab per Kolom',
                data: dataSk.map(i => parseInt(i.terjawab)),
                borderWidth: 2,
                tension: 0.3
            }];
        }

        chartInstances[sk_group_id] = new Chart(ctx, {
            type: 'line',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 60
                    }
                },
                plugins: {
                    legend: {
                        onClick: (e, legendItem) => {
                            const nextMode =
                                legendItem.text.includes('3')
                                    ? 'group'
                                    : 'detail';

                            renderChart(sk_group_id, nextMode);
                        }
                    }
                }
            }
        });
    }

    for (let i = 1; i <= 4; i++) {
        renderChart(i, 'group'); // default per 3 kolom
    }


    document.getElementById('toggleMode').addEventListener('change', function () {

        const mode = this.checked ? 'group' : 'detail';

        document.getElementById('modeLabel').innerText =
            mode === 'group'
                ? 'Per 3 Kolom'
                : 'Detail Per Kolom';

        for (let i = 1; i <= 4; i++) {
            renderChart(i, mode);
        }
    });


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