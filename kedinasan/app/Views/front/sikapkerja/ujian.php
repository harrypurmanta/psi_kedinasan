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
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
    .d-none {
        display: none !important;
    }

    #loader-wrapper {
        display: flex;
        position: fixed;
        z-index: 1060;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        padding: 0.625em;
        overflow-x: hidden;
        transition: background-color 0.1s;
        background-color: rgb(253 253 253 / 58%);
        -webkit-overflow-scrolling: touch;
    }

    .loader {
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #3af3f5;
        border-bottom: 10px solid #3abcec;
        width: 50px;
        height: 50px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        margin: 1.75rem auto;
    }



    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-o-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-ms-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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
                            <div class="bg-gray col-md-8" style="border-radius:5px;">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <label for="">Tahapan Ujian</label>
                                </div>
                                <input type="hidden" id="inp_group_id">
                                <div class='col-lg-3' style='border-radius:10px;'>
                                                <div class='small-box bg-green' style='border-radius:10px;border:1px solid green;'>
                                                    <div class='inner text-center'>
                                                    Sikap Kerja
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                            <div class="bg-gray col-md-3 text-center"
                                style="border-radius:5px;margin-left:10px;height:85px;">
                                <span style="margin-top:15px;">Waktu</span><br>
                                <label style="font-size:30px;" id="countdown">00:00</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12">
                            <div class="bg-gray col-md-8" style="border-radius:5px;">
                                <div style="margin-top:10px;text-align:center;">
                                    <label style="font-size:20px;" for="kolom" id="lb_kolom">Kolom</label>
                                </div>
                                <div id="dv_soal" class="col-md-12" style="min-height:500px;border-radius:5px;">
                                    
                                </div>
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-md-12" id="dv_button">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
    </div>
    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script>
    var timers;
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start","","","",4,0,1,98);
        }, 1000);
    });

    function startujian(proc,pilihan_nm,jawaban_id,soal_id,group_id,no_soal,kolom_id,materi) {
        $.ajax({
            url: "<?= base_url('sikapkerja/sikapkerjaujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "proc": proc,
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "group_id": group_id,
                "materi": materi,
                "kolom_id": kolom_id,
                "sk_group_id": <?= $request->uri->getSegment(3) ?>
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.no_soal == 1) {
                    window.clearInterval(timers);
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom "+data.kolom);
                    countdown(60,kolom_id);
                } else if (data.ret == "persiapan") {
                    window.clearInterval(timers);
                    $("#lb_kolom").text("Persiapan . . .");
                    $("#dv_soal").html("");
                    countdown(6,kolom_id,data.ret);
                } else if (data.ret == "selesai") {
                    window.location.href = "<?= base_url() ?>/sikapkerja/hasiltryout/" + <?= $request->uri->getSegment(3) ?> ;
                } else if (data == "soal_tidak_ada") {
                    alert("Soal tidak ada");
                } else {
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom "+data.kolom);
                }
                
                // $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                alert("Error system");
            }
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) {
            sec = "0"+sec;
        }

        if (min < 10) {
            min = "0"+min;
        }
        return min + ":" + sec;
    }


    function countdown(detik,kolom_id,proc) {
        var seconds = detik;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000); // every second

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                window.clearInterval(timers);
                if (proc == "persiapan") {
                    kolom_id = kolom_id + 1;
                    startujian("nextkolom","","","",4,0,kolom_id,98);
                } else {
                    startujian("persiapan","","","",4,0,kolom_id,98);
                }
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>
</html>