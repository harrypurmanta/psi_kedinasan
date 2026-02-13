<?php 
  $this->session = \Config\Services::session();
?>
<?= $this->include('admin/template/head') ?>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
 <!-- Navbar -->
 <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->
   
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Soal Sikap Kerja (Materi)</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit Soal Sikap Kerja (Materi)</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="text-align:center;">
                            <input type="hidden" id="jawaban_nm_lama" name="jawaban_nm_lama" value="<?= $jawaban[0]->jawaban_nm ?>">
                            <h3><b><?= $kolom[0]->kolom_nm ?></b> | <input type="text" name="jawaban_nm" id="jawaban_nm" value="<?= $jawaban[0]->jawaban_nm ?>" disabled style="width: 100px; text-align: center; font-weight: bold; text-transform: uppercase;" maxlength="5" autocomplete="off" oninput="this.value = this.value.toUpperCase();"> <button onclick="editclue()" type="button" class="btn btn-sm btn-warning" id="btn_edit"><i class="fa fa-md fa-edit"></i></button> <button onclick="simpanclue(<?= $kolom[0]->kolom_id ?>)" type="button" class="btn btn-sm btn-success d-none" id="btn_simpan"><i class="fa fa-md fa-save"></i></button></h3> 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-md-12"> -->
                                    <div class="col-md-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;" width="100">No.</th>
                                                    <th style="text-align: center;">Soal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($bagian1 as $key1) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $key1->no_soal ?></td>
                                                    <td style="text-align: center;">
                                                        <div style="display: flex; align-items: center;">
                                                            <input onblur="updatesoalsk(<?= $key1->soal_id ?>)" style="text-align: center;" type="text" value="<?= $key1->soal_nm ?>" id="soal_nm_<?= $key1->soal_id ?>" name="soal_nm_<?= $key1->soal_id ?>" maxlength="4" autocomplete="off" oninput="this.value = this.value.toUpperCase();">
                                                            <i class="fa fa-check" id="icon_<?= $key1->soal_id ?>" style="display:none; margin-left:6px; color: #54d654; font-size:18px;"></i>
                                                            <i class="fa fa-times-circle" id="icon_gagal_<?= $key1->soal_id ?>" style="display:none; margin-left:6px; color: #e33434ff; font-size:18px;"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;" width="100">No.</th>
                                                    <th style="text-align: center;">Soal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($bagian2 as $key2) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $key2->no_soal ?></td>
                                                    <td style="text-align: center;">
                                                        <div style="display: flex; align-items: center;">
                                                            <input onblur="updatesoalsk(<?= $key2->soal_id ?>)" style="text-align: center;" type="text" value="<?= $key2->soal_nm ?>" id="soal_nm_<?= $key2->soal_id ?>" name="soal_nm_<?= $key2->soal_id ?>" maxlength="4" autocomplete="off" oninput="this.value = this.value.toUpperCase();">
                                                            <i class="fa fa-check" id="icon_<?= $key2->soal_id ?>" style="display:none; margin-left:6px; color: #54d654; font-size:18px;"></i>
                                                            <i class="fa fa-times-circle" id="icon_gagal_<?= $key2->soal_id ?>" style="display:none; margin-left:6px; color: #e33434ff; font-size:18px;"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;" width="100">No.</th>
                                                    <th style="text-align: center;">Soal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($bagian3 as $key3) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $key3->no_soal ?></td>
                                                    <td style="text-align: center;">
                                                        <div style="display: flex; align-items: center;">
                                                            <input onblur="updatesoalsk(<?= $key3->soal_id ?>)" style="text-align: center;" type="text" value="<?= $key3->soal_nm ?>" id="soal_nm_<?= $key3->soal_id ?>" name="soal_nm_<?= $key3->soal_id ?>" maxlength="4" autocomplete="off" oninput="this.value = this.value.toUpperCase();">
                                                            <i class="fa fa-check" id="icon_<?= $key3->soal_id ?>" style="display:none; margin-left:6px; color: #54d654; font-size:18px;"></i>
                                                            <i class="fa fa-times-circle" id="icon_gagal_<?= $key3->soal_id ?>" style="display:none; margin-left:6px; color: #e33434ff; font-size:18px;"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;" width="100">No.</th>
                                                    <th style="text-align: center;">Soal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($bagian4 as $key4) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $key4->no_soal ?></td>
                                                    <td style="text-align: center;">
                                                        <div style="display: flex; align-items: center;">
                                                            <input onblur="updatesoalsk(<?= $key4->soal_id ?>)" style="text-align: center;" type="text" value="<?= $key4->soal_nm ?>" id="soal_nm_<?= $key4->soal_id ?>" name="soal_nm_<?= $key4->soal_id ?>" maxlength="4" autocomplete="off" oninput="this.value = this.value.toUpperCase();">
                                                            <i class="fa fa-check" id="icon_<?= $key4->soal_id ?>" style="display:none; margin-left:6px; color: #54d654; font-size:18px;"></i>
                                                            <i class="fa fa-times-circle" id="icon_gagal_<?= $key4->soal_id ?>" style="display:none; margin-left:6px; color: #e33434ff; font-size:18px;"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="d-none" id='loader-wrapper'>
        <div class="loader"></div>
      </div>
  </div>
  
 

</div>
<!-- ./wrapper -->
<?= $this->include('admin/template/scriptjs') ?>
<!-- Page specific script -->
<script>

    function editclue() {
        $("#jawaban_nm").prop("disabled", false);   
        $("#btn_simpan").removeClass("d-none"); 
        $("#btn_edit").addClass("d-none"); 
    }

    function simpanclue(kolom_id) {
        var jawaban_nm = $("#jawaban_nm").val();
        var jawaban_nm_lama = $("#jawaban_nm_lama").val();
        var jawaban_nm_lama = $("#jawaban_nm_lama").val();
        var materi_id = <?= $materi_id ?>;

        if (jawaban_nm.length < 5) {
            alert("Jumlah karakter pada clue kurang dari 5");
            document.getElementById("jawaban_nm").focus();
            return;
        } 

        for (i = 0; i < jawaban_nm.length; i++) {
            for (j = i + 1; j < jawaban_nm.length; j++) {
                if (jawaban_nm[i] == jawaban_nm[j]) {
                    Swal.fire("Karakter tidak boleh sama", "", "warning");
                    var val = jawaban_nm.substr(0, jawaban_nm.length - 1);
                    $("#jawaban_nm").val(val);
                    return;
                }
            }
        }

        $.ajax({
            url: "<?= base_url('admin/soal/updateclue') ?>",
            type: "post",
            dataType: "json",
            data: {
                "kolom_id" : kolom_id,
                "jawaban_nm" : jawaban_nm,
                "jawaban_nm_lama" : jawaban_nm_lama,
                "materi_id" : materi_id
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data == "finish") {
                    Swal.fire({
                        title: "Soal berhasil di disimpan",
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "OK"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                $("#loader-wrapper").addClass("d-none");
                Swal.fire("Soal gagal di disimpan", "", "error");
            }
        });
    }
    
    function updatesoalsk(soal_id) {
        let soal_nm = $("#soal_nm_"+soal_id).val();
        let icon   = $("#icon_" + soal_id);
        let icongagal   = $("#icon_gagal_" + soal_id);
        var jawaban_nm = <?= json_encode($jawaban[0]->jawaban_nm) ?>;
        let invalidChars = [];

        for (i = 0; i < soal_nm.length; i++) {
            for (j = i + 1; j < soal_nm.length; j++) {
                if (soal_nm[i] == soal_nm[j]) {
                    Swal.fire("Karakter tidak boleh sama", "", "warning");
                    var val = soal_nm.substr(0, soal_nm.length - 1);
                    $("#soal_nm_"+soal_id).val(val);
                    icongagal.fadeIn(100);

                    setTimeout(function() {
                        icongagal.fadeOut(400);
                    }, 2000);
                    return;
                }
            }
        }

        for (let char of soal_nm) {
            if (!jawaban_nm.includes(char)) {
                invalidChars.push(char);
            }
        }

        if (invalidChars.length > 0) {
            Swal.fire("Karakter " + invalidChars.join(", ") + " tidak ada di clue: " + jawaban_nm, "", "warning");
            icongagal.fadeIn(100);

            setTimeout(function() {
                icongagal.fadeOut(400);
            }, 2000);
            return;
        }

        $.ajax({
                url: "<?= base_url('admin/soal/updatesoalskmateri') ?>",
                type: "post",
                dataType: "json",
                data: {"soal_id" : soal_id, "soal_nm" : soal_nm},
                success: function(data) {
                    if (data == "berhasil") {
                        icon.fadeIn(100);

                        setTimeout(function() {
                            icon.fadeOut(300);
                        }, 2000);
                    } else {
                        Swal.fire("Soal gagal di disimpan", "", "info");
                    }
                },
                error: function() {
                    alert("error");
                }
            });
    }

    function checkdupe(kolom) {
        var char = document.getElementById(kolom).value;
        for (i = 0; i < char.length; i++) {
        for (j = i + 1; j < char.length; j++) {
            if (char[i] == char[j]) {
                alert("Karakter tidak boleh sama !");
                var val = char.substr(0, char.length - 1);
                document.getElementById(kolom).value = val;
            }
        }
        }
    }

</script>
</body>
</html>