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
            <h1>Edit Soal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit Soal</li>
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
                        <div class="card-header">

                        </div>
                        <?php
                            foreach ($soal as $keySoal) {
                        ?>
                        <div class="card-body">
                            <div class="row col-sm-12">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Pilih Group</label>
                                        <select name="group_id" id="group_id" class="form-control" onchange="getNoSoal()">
                                            <option value="" disabled <?= ($this->session->group_soal_id == null ? "" : "selected") ?>>Pilih Group Soal</option>
                                            <?php
                                                foreach ($group as $key) {
                                            ?>
                                            <option value="<?= $key->group_soal_id  ?>"
                                                <?= ($keySoal->group_soal_id  == $key->group_soal_id ?"selected":"") ?>>
                                                <?= $key->group_nm ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Pilih Jenis</label>
                                        <select onchange="getNoSoal()" name="jenis_id" id="jenis_id" class="form-control">
                                            <option value="" disabled <?= ($this->session->materi_id == null ? "" : "selected") ?>>Pilih Jenis Soal</option>
                                            <?php
                                                foreach ($jenis_soal as $key) {
                                            ?>
                                            <option value="<?= $key->jenis_id ?>"
                                                <?= ($keySoal->jenis_id == $key->jenis_id ? "selected" : "") ?>>
                                                <?= $key->jenis_nm ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label>No. Soal</label>
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="no_soal" id="no_soal" value="<?= $keySoal->no_soal ?>">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label>Kunci</label>
                                    <div class="form-group">
                                        <select name="kunci" id="kunci" class="form-control">
                                            <option <?= $keySoal->kunci == "A" ? "selected" : "" ?> value="A">A</option>
                                            <option <?= $keySoal->kunci == "B" ? "selected" : "" ?> value="B">B</option>
                                            <option <?= $keySoal->kunci == "C" ? "selected" : "" ?> value="C">C</option>
                                            <option <?= $keySoal->kunci == "D" ? "selected" : "" ?> value="D">D</option>
                                            <option <?= $keySoal->kunci == "E" ? "selected" : "" ?> value="E">E</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Soal Image</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="soal_img" id="soal_img"
                                            value="">
                                    </div>
                                    <?php
                                        if ($keySoal->soal_img != "") {
                                    ?>
                                    <div id="dv_soalimg_<?= $keySoal->soal_id ?>">
                                            <img src="<?= base_url() ?>/images/soal_latihan/jenis/<?= $keySoal->jenis_id ?>/<?= $keySoal->soal_img ?>" alt="" width="200" height="200">
                                            <button onclick="hapusgambarsoal(<?= $keySoal->soal_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Pembahasan Image</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="pembahasan_img"
                                            id="pembahasan_img" value="">
                                    </div>
                                    <?php
                                        if ($keySoal->pembahasan_img != "") {
                                    ?>
                                    <div id="dv_soalimg_<?= $keySoal->soal_id ?>">
                                        <img src="<?= base_url() ?>/images/pembahasan_latihan/<?= $keySoal->group_id ?>/<?= $keySoal->jenis_id ?>/<?= $keySoal->pembahasan_img ?>" alt="" width="200" height="200">
                                        <button onclick="hapusgambarpembsoal(<?= $keySoal->soal_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="col-sm-6"><label>Soal</label></div>
                                        <div class="card card-outline card-info">
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <textarea class="form-control summernote" id="summernote_soal"
                                                    name="soal" row="5"><?= $keySoal->soal_nm ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12"><label>Pembahasan</label></div>
                                        <div class="card card-outline card-info">
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <textarea id="summernote_pembahasan" name="pembahasan" row="5"
                                                    class="form-control summernote"><?= $keySoal->pembahasan ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-sm-12">
                                <div class="card card-outline card-success">
                                    <div class="card-body">
                                        <!-- <div class=""> -->

                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban A</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <input type="hidden" value="<?= isset($jawaban[0]->pilihan_nm) && $jawaban[0]->pilihan_nm == "A" && !empty($jawaban[0]) ? $jawaban[0]->jawaban_id : "" ?>" id="jawaban_id_A"/>
                                                                <textarea class="form-control summernote" id="jawaban_nm_A" name="jawaban_nm_A"><?= isset($jawaban[0]->pilihan_nm) && $jawaban[0]->pilihan_nm == "A" && $jawaban[0]->jawaban_nm != NULL ? $jawaban[0]->jawaban_nm : "" ?></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Gambar Jawaban A</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_A" id="jawaban_img_A">
                                                        </div>
                                                        <?php
                                                            if (isset($jawaban[0]->pilihan_nm) && $jawaban[0]->jawaban_img != "") {
                                                        ?>
                                                            <div id="dv_jwbimg_<?= $jawaban[0]->jawaban_id ?>">
                                                                <img src="<?= base_url() ?>/images/jawaban_latihan/jenis/<?= $jawaban[0]->jenis_id ?>/<?= $jawaban[0]->jawaban_img ?>" alt="" width="200" height="200">
                                                                <button onclick="hapusgambar(<?= $jawaban[0]->jawaban_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban B</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <input type="hidden" value="<?= isset($jawaban[1]->pilihan_nm) && $jawaban[1]->pilihan_nm == "B" && !empty($jawaban[1]) ? $jawaban[1]->jawaban_id : "" ?>" id="jawaban_id_B"/>
                                                                <textarea class="form-control summernote" id="jawaban_nm_B" name="jawaban_nm_B"><?=  isset($jawaban[1]->pilihan_nm) && $jawaban[1]->pilihan_nm == "B" && $jawaban[1]->jawaban_nm != NULL ? $jawaban[1]->jawaban_nm : "" ?></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Gambar Jawaban B</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_B" id="jawaban_img_B">
                                                        </div>
                                                        <?php
                                                            if (isset($jawaban[1]->pilihan_nm) && $jawaban[1]->jawaban_img != "") {
                                                        ?>
                                                            <div id="dv_jwbimg_<?= $jawaban[1]->jawaban_id ?>">
                                                                <img src="<?= base_url() ?>/images/jawaban_latihan/jenis/<?= $jawaban[1]->jenis_id ?>/<?= $jawaban[1]->jawaban_img ?>" alt="" width="200" height="200">
                                                                <button onclick="hapusgambar(<?= $jawaban[1]->jawaban_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban C</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <input type="hidden" value="<?= isset($jawaban[2]->pilihan_nm) && $jawaban[2]->pilihan_nm == "C" && !empty($jawaban[2]) ? $jawaban[2]->jawaban_id : "" ?>" id="jawaban_id_C"/>
                                                                <textarea class="form-control summernote" id="jawaban_nm_C" name="jawaban_nm_C"><?= isset($jawaban[2]->pilihan_nm) && $jawaban[2]->pilihan_nm == "C" && $jawaban[2]->jawaban_nm != NULL ? $jawaban[2]->jawaban_nm : "" ?></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Gambar Jawaban C</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_C" id="jawaban_img_C">
                                                        </div>
                                                        <?php
                                                            if (isset($jawaban[2]->pilihan_nm) && $jawaban[2]->jawaban_img != "") {
                                                        ?>
                                                            <div id="dv_jwbimg_<?= $jawaban[2]->jawaban_id ?>">
                                                                <img src="<?= base_url() ?>/images/jawaban_latihan/jenis/<?= $jawaban[2]->jenis_id ?>/<?= $jawaban[2]->jawaban_img ?>" alt="" width="200" height="200">
                                                                <button onclick="hapusgambar(<?= $jawaban[2]->jawaban_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban D</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <input type="hidden" value="<?= isset($jawaban[3]->pilihan_nm) && $jawaban[3]->pilihan_nm == "D" && !empty($jawaban[3]) ? $jawaban[3]->jawaban_id : "" ?>" id="jawaban_id_D"/>
                                                                <textarea class="form-control summernote" id="jawaban_nm_D" name="jawaban_nm_D"><?= isset($jawaban[3]->pilihan_nm) && $jawaban[3]->pilihan_nm == "D" && $jawaban[3]->jawaban_nm != NULL ? $jawaban[3]->jawaban_nm : "" ?></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Gambar Jawaban D</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_D" id="jawaban_img_D">
                                                        </div>
                                                        <?php
                                                            if (isset($jawaban[3]->pilihan_nm) && $jawaban[3]->jawaban_img != "") {
                                                        ?>
                                                            <div id="dv_jwbimg_<?= $jawaban[3]->jawaban_id ?>">
                                                                <img src="<?= base_url() ?>/images/jawaban_latihan/jenis/<?= $jawaban[3]->jenis_id ?>/<?= $jawaban[3]->jawaban_img ?>" alt="" width="200" height="200">
                                                                <button onclick="hapusgambar(<?= $jawaban[3]->jawaban_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban E</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <input type="hidden" value="<?= isset($jawaban[4]->pilihan_nm) &&  $jawaban[4]->pilihan_nm == "E" && !empty($jawaban[4]) ? $jawaban[4]->jawaban_id : "" ?>" id="jawaban_id_E"/>
                                                                <textarea class="form-control summernote" id="jawaban_nm_E" name="jawaban_nm_E"><?= isset($jawaban[4]->pilihan_nm) && $jawaban[4]->pilihan_nm == "E" && $jawaban[4]->jawaban_nm != NULL ? $jawaban[4]->jawaban_nm : "" ?></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Gambar Jawaban E</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_E" id="jawaban_img_E">
                                                        </div>
                                                        <?php
                                                            if (isset($jawaban[4]->pilihan_nm) && $jawaban[4]->jawaban_img != "") {
                                                        ?>
                                                            <div id="dv_jwbimg_<?= $jawaban[4]->jawaban_id ?>">
                                                                <img src="<?= base_url() ?>/images/jawaban_latihan/jenis/<?= $jawaban[4]->jenis_id ?>/<?= $jawaban[4]->jawaban_img ?>" alt="" width="200" height="200">
                                                                <button onclick="hapusgambar(<?= $jawaban[4]->jawaban_id ?>)" style="position: absolute;" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </div> -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary" onclick="updatesoal(<?= $soal_id ?>)">Simpan</button>
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

    <div class="d-none" id='loader-wrapper'>
        <div class="loader"></div>
      </div>
  </div>
  
 

</div>
<!-- ./wrapper -->
<?= $this->include('admin/template/scriptjs') ?>
<!-- Page specific script -->
<script>
    function hapusgambar(jawaban_id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "data yang tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yakin"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('admin/soallatihan/hapusgambar') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        "jawaban_id": jawaban_id
                    },
                    success: function(data) {
                        $("#dv_jwbimg_"+jawaban_id).html("");
                    },
                    error: function() {
                        alert("error");
                    }
                });
            }
        });
    }

    function hapusgambarsoal(soal_id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "data yang tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yakin"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('admin/soallatihan/hapusgambarsoal') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        "soal_id": soal_id
                    },
                    success: function(data) {
                        $("#dv_soalimg_"+soal_id).html("");
                    },
                    error: function() {
                        alert("error");
                    }
                });
            }
        });
    }

    function hapusgambarpembsoal(soal_id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "data yang tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yakin"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('admin/soallatihan/hapusgambarpembsoal') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        "soal_id": soal_id
                    },
                    success: function(data) {
                        $("#dv_soalimg_"+soal_id).html("");
                    },
                    error: function() {
                        alert("error");
                    }
                });
            }
        });
    }

    function getNoSoal() {
        var materi_id = $("#materi").val();
        var group_id = $("#group_id").val();
        $.ajax({
            url: "<?= base_url('admin/soallatihan/getNoSoal') ?>",
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
                $("#no_soal").val(data);
                $("#loader-wrapper").addClass("d-none")
            },
            error: function() {
                $("#loader-wrapper").addClass("d-none")
                alert("error");
            }
        });
    }

    function updatesoal(soal_id) {
        let formData = new FormData();
        let jenis_id = $("#jenis_id").val();
        let group_id = $("#group_id").val();
        let no_soal = $("#no_soal").val();
        let kunci = $("#kunci").val();
        let soal_nm = $("#summernote_soal").val();
        let pembahasan_nm = $("#summernote_pembahasan").val();
        jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
            formData.append('soal_img['+i+']', file);
        });

        jQuery.each($("input[name='pembahasan_img'")[0].files, function(i, file) {
            formData.append('pembahasan_img['+i+']', file);
        });
        formData.append('soal_id', soal_id);
        formData.append('no_soal', no_soal);
        formData.append('kunci', kunci);
        formData.append('soal_nm', soal_nm);
        formData.append('pembahasan_nm', pembahasan_nm);
        formData.append('jenis_id', jenis_id);
        formData.append('group_id', group_id);
       
        let jawaban_id_A = $("#jawaban_id_A").val();
        let jawaban_id_B = $("#jawaban_id_B").val();
        let jawaban_id_C = $("#jawaban_id_C").val();
        let jawaban_id_D = $("#jawaban_id_D").val();
        let jawaban_id_E = $("#jawaban_id_E").val();

        let jawaban_nm_A = $("#jawaban_nm_A").val();
        let jawaban_nm_B = $("#jawaban_nm_B").val();
        let jawaban_nm_C = $("#jawaban_nm_C").val();
        let jawaban_nm_D = $("#jawaban_nm_D").val();
        let jawaban_nm_E = $("#jawaban_nm_E").val();

        formData.append('jawaban_id_A', jawaban_id_A);
        formData.append('jawaban_id_B', jawaban_id_B);
        formData.append('jawaban_id_C', jawaban_id_C);
        formData.append('jawaban_id_D', jawaban_id_D);
        formData.append('jawaban_id_E', jawaban_id_E);

        formData.append('jawaban_nm_A', jawaban_nm_A);
        formData.append('jawaban_nm_B', jawaban_nm_B);
        formData.append('jawaban_nm_C', jawaban_nm_C);
        formData.append('jawaban_nm_D', jawaban_nm_D);
        formData.append('jawaban_nm_E', jawaban_nm_E);

        if (document.getElementById('jawaban_img_A') != null) {
            jQuery.each($("input[name='jawaban_img_A'")[0].files, function(i, file) {
                formData.append('jawaban_img_A[' + i + ']', file);
            });
        }

        if (document.getElementById('jawaban_img_B') != null) {
            jQuery.each($("input[name='jawaban_img_B'")[0].files, function(i, file) {
                formData.append('jawaban_img_B[' + i + ']', file);
            });
        }

        if (document.getElementById('jawaban_img_C') != null) {
            jQuery.each($("input[name='jawaban_img_C'")[0].files, function(i, file) {
                formData.append('jawaban_img_C[' + i + ']', file);
            });
        }

        if (document.getElementById('jawaban_img_D') != null) {
            jQuery.each($("input[name='jawaban_img_D'")[0].files, function(i, file) {
                formData.append('jawaban_img_D[' + i + ']', file);
            });
        }

        if (document.getElementById('jawaban_img_E') != null) {
            jQuery.each($("input[name='jawaban_img_E'")[0].files, function(i, file) {
                formData.append('jawaban_img_E[' + i + ']', file);
            });
        } 
        
        $.ajax({
                url: "<?= base_url('soallatihan/updatesoal') ?>",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "berhasil") {
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
                    } else {
                        Swal.fire("Soal gagal di disimpan", "", "info");
                    }
                },
                error: function() {
                    alert("error");
                }
            });
        
    }

</script>
</body>
</html>