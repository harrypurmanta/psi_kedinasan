<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bintang Timus Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.css">
    <link rel="icon" href="images/bg/favicon.ico" type="image/gif">
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
                    <div class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="bg-gray col-md-3 text-center"
                                style="border-radius:5px;margin-left:10px;height:85px;">
                                <span style="margin-top:15px;">Waktu</span><br>
                                <label style="font-size:30px;" id="countdown">00:00</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12" style="display:flex;">
                            <div class="bg-gray col-md-12" style="border-radius: 5px; margin: 0 auto; min-width: 100%;">
                                <div style="margin-top: 10px; text-align: center;">
                                    <label style="font-size:20px;margin-top:15px;" for="kolom" id="lb_kolom">Kolom</label>
                                </div>
                                <div id="dv_soal" class="col-md-12" style="min-height:500px; border-radius:5px;">
                                    
                                </div>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
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
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>
    <script>
    var timers;
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start","","","",<?= $request->uri->getSegment(4) ?>,0,1,<?= $request->uri->getSegment(3) ?>,1);
        }, 1000);

        $(document).on('keydown', function (e) {
            if (e.keyCode >= 48 && e.keyCode <= 57) {

                let angka = e.key;
                let btn = $(".tombol_pauli").filter(function () {
                    return $(this).text().trim() === angka;
                });

                if (btn.length > 0) {
                    btn.click(); // trigger klik tombol
                }

                e.preventDefault();
            }

        });
    });

    function renderSoal(data) {
        let html = `
        <div class='col-md-12' style='width:100%;margin-top:30px;'>
            <label style='font-size:20px;'>Pertanyaan ${data.no_soal}</label>
            <div class='row col-md-12 text-center'>
        `;

        let soal = data.data_soal.soal_nm
                    .replace(/\s+/g,'')
                    .replace(/\+/g,'')
                    .split('');

        html += `<div style="display:flex;flex-direction:column;align-items:center;">`;

        soal.forEach(function(item){
            html += `
            <div style="
                background-color:grey;
                width:70px;
                height:80px;
                font-size:60px;
                font-weight:bold;
                display:flex;
                align-items:center;
                justify-content:center;
                margin:5px;
            ">
                ${item}
            </div>`;
        });

        html += `</div></div><div class='row col-md-12'><div style='text-align:center;'>`;

        data.data_soal.jawaban.forEach(function(j){
            html += `
            <button onclick='startujian(
                "next",
                "${j.pilihan_nm}",
                ${j.jawaban_id},
                ${data.data_soal.soal_id},
                ${data.group_id},
                ${data.no_soal},
                ${data.kolom_id},
                <?= $request->uri->getSegment(3) ?>,
                ${data.sk_group_id}
            )'
            style='width:27%;margin:5px;font-weight:bold;font-size:30px;'
            class='btn btn-primary tombol_pauli'>
                ${j.pilihan_nm}
            </button>`;
        });

        html += `</div></div></div>`;

        $("#dv_soal").html(html);
        $("#lb_kolom").text("Kolom " + data.kolom_id);
    }


    function startujian(proc,pilihan_nm,jawaban_id,soal_id,group_id,no_soal,kolom_id,materi,sk_group_id) {
        $.ajax({
            url: "<?= base_url('tryout/pauliujian') ?>",
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
                "sk_group_id": sk_group_id
            },
            beforeSend: function() {
                // $(".tombol_kreplin").prop("disabled", true);
            },
            success: function(data) {
                if (data.ret === "persiapan") {
                    window.clearInterval(timers);
                    timers = null;
                    $("#lb_kolom").text("Persiapan . . .");
                    $("#dv_soal").html("");
                    countdown(2, data.kolom_id, data.sk_group_id, "persiapan");
                    return;
                }

                if (data.ret === "selesai") {
                    updateFinishRespon(
                        <?= $request->uri->getSegment(3) ?>,
                        <?= $request->uri->getSegment(4) ?>
                    );
                    Swal.fire("Tes selesai", "Terima kasih", "success")
                    .then(() => {
                        window.location.href =
                        "<?= base_url() ?>/tryout/hasiltryout/<?= $request->uri->getSegment(3) ?>/<?= $request->uri->getSegment(4) ?>";
                    });
                    return;
                }

                if (data.ret === "ok") {
                    // window.clearInterval(timers);
                    renderSoal(data);

                    // Durasi waktu
                    let durasi = 60;
                    if (data.no_soal === 1) {
                        countdown(durasi, data.kolom_id, data.sk_group_id);
                    }
                    return;
                }

                if (data.ret === "soal_tidak_ada") {
                    alert("Soal tidak ada");
                }

                
                // $(".tombol_kreplin").prop("disabled", false);
            },
            error: function(e) {
                alert(e.responseText);
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


    function countdown(detik,kolom_id,sk_group_id,proc) {
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
                    if (kolom_id == 21) {
                        sk_group_id = sk_group_id + 1;
                        kolom_id = 1;
                        if (sk_group_id == 5) {
                            startujian("selesai");
                        } else {
                            startujian("nextkolom","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                        }
                        
                    } else {
                        startujian("nextkolom","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                    }
                } else {
                    startujian("persiapan","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                }
            } else {
                //Do nothing
            }

        }
    }

    function updateFinishRespon(materi_id,group_id) {
        $.ajax({
            url: "<?= base_url('tryout/updateFinishRespon') ?>",
            type: "post",
            dataType: "json",
            data: {
                "materi_id": materi_id,
                "group_id": group_id
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                Swal.fire("Ada terjadi sesuatu, mohon hubungi administrator", "", "warning");
            }
        });
    }
    </script>
</body>
</html>