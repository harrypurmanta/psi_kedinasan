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
            <h1>Tambah Soal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tambah Soal</li>
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
                        <div class="card-body">
                            <div class="row col-sm-12">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Pilih Materi</label>
                                        <select onchange="getNoSoal()" name="materi" id="materi" class="form-control">
                                            <option value="" disabled <?= ($this->session->materi_id == null ? "" : "selected") ?>>Pilih Materi Soal</option>
                                            <?php
                                                foreach ($materi as $key) {
                                            ?>
                                            <option value="<?= $key->materi_id ?>"
                                                <?= ($this->session->materi_id_sess == $key->materi_id ? "selected" : "") ?>>
                                                <?= $key->materi_nm ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Pilih Group</label>
                                        <select name="group_id" id="group_id" class="form-control" onchange="getNoSoal()">
                                            <option value="" disabled <?= ($this->session->group_soal_id == null ? "" : "selected") ?>>Pilih Group Soal</option>
                                            <?php
                                                foreach ($group as $key) {
                                            ?>
                                            <option value="<?= $key->group_soal_id  ?>"
                                                <?= ($this->session->group_id_sess  == $key->group_soal_id ?"selected":"") ?>>
                                                <?= $key->group_nm ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label>No. Soal</label>
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="no_soal" id="no_soal" value="<?= $no_soal[0]->no_soal+1 ?>">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label>Kunci</label>
                                    <div class="form-group">
                                        <select name="kunci" id="kunci" class="form-control">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Soal Image</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="soal_img" id="soal_img"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Pembahasan Image</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="pembahasan_img"
                                            id="pembahasan_img" value="">
                                    </div>
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
                                                    name="soal" row="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12"><label>Pembahasan</label></div>
                                        <div class="card card-outline card-info">
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <textarea id="summernote_pembahasan" name="pembahasan" row="5"
                                                    class="form-control summernote"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <div class="card card-outline card-success">
                                    <div class="card-body">
                                        <!-- <div class=""> -->
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban A</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <textarea class="form-control summernote" id="jawaban_nm_A" name="jawaban_nm_A"></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Image</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_A" id="jawaban_img_A">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban B</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <textarea class="form-control summernote" id="jawaban_nm_B" name="jawaban_nm_B"></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Image</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_B" id="jawaban_img_B">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban C</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <textarea class="form-control summernote" id="jawaban_nm_C" name="jawaban_nm_C"></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Image</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_C" id="jawaban_img_C">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban D</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <textarea class="form-control summernote" id="jawaban_nm_D" name="jawaban_nm_D"></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Image</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_D" id="jawaban_img_D">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="col-sm-6"><label>Jawaban E</label></div>
                                                        <div class="card card-outline card-info">
                                                            <div class="card-body">
                                                                <textarea class="form-control summernote" id="jawaban_nm_E" name="jawaban_nm_E"></textarea>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="col-sm-12">
                                                        <label>Image</label>
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="jawaban_img_E" id="jawaban_img_E">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </div> -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary" onclick="simpansoal(event)">Simpan</button>
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
    $('.summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
    
    function getNoSoal() {
        var materi_id = $("#materi").val();
        var group_id = $("#group_id").val();
        $.ajax({
            url: "<?= base_url('admin/soal/getNoSoal') ?>",
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

    function simpansoal(e) {
        let formData = new FormData();
        let materi_id = $("#materi").val();
        let group_id = $("#group_id").val();
        let no_soal = $("#no_soal").val();
        let kunci = $("#kunci").val();
        let soal_nm = $("#summernote_soal").val();
        let pembahasan_nm = $("#summernote_pembahasan").val();

        let jawaban_nm_A = $("#jawaban_nm_A").val();
        let jawaban_nm_B = $("#jawaban_nm_B").val();
        let jawaban_nm_C = $("#jawaban_nm_C").val();
        let jawaban_nm_D = $("#jawaban_nm_D").val();
        let jawaban_nm_E = $("#jawaban_nm_E").val();

        jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
            formData.append('soal_img[' + i + ']', file);
        });

        jQuery.each($("input[name='pembahasan_img'")[0].files, function(i, file) {
            formData.append('pembahasan_img[' + i + ']', file);
        });

        jQuery.each($("input[name='jawaban_img_A'")[0].files, function(i, file) {
            formData.append('jawaban_img_A[' + i + ']', file);
        });

        jQuery.each($("input[name='jawaban_img_B'")[0].files, function(i, file) {
            formData.append('jawaban_img_B[' + i + ']', file);
        });

        jQuery.each($("input[name='jawaban_img_C'")[0].files, function(i, file) {
            formData.append('jawaban_img_C[' + i + ']', file);
        });

        jQuery.each($("input[name='jawaban_img_D'")[0].files, function(i, file) {
            formData.append('jawaban_img_D[' + i + ']', file);
        });

        jQuery.each($("input[name='jawaban_img_E'")[0].files, function(i, file) {
            formData.append('jawaban_img_E[' + i + ']', file);
        });

        formData.append('no_soal', no_soal);
        formData.append('kunci', kunci);
        formData.append('soal_nm', soal_nm);
        formData.append('pembahasan_nm', pembahasan_nm);
        formData.append('materi_id', materi_id);
        formData.append('group_id', group_id);

        formData.append('jawaban_nm_A', jawaban_nm_A);
        formData.append('jawaban_nm_B', jawaban_nm_B);
        formData.append('jawaban_nm_C', jawaban_nm_C);
        formData.append('jawaban_nm_D', jawaban_nm_D);
        formData.append('jawaban_nm_E', jawaban_nm_E);

        $.ajax({
                url: "<?= base_url('admin/soal/simpansoal') ?>",
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
                                setTimeout(location.reload(), 2000);
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