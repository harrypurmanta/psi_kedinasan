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
            <h1>Soal Sikap Kerja Latihan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Soal Sikap Kerja Latihan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                      <form class="form-horizontal">
                        <div class="card-body">
                          <div class="form-group row">
                            <label for="sk_group_id" class="col-sm-2 col-form-label">SK Group</label>
                            <div class="col-sm-10">
                              <select name="sk_group_id" id="sk_group_id" class="form-control">
                                  <option value="" disabled>Pilih Materi Soal</option>
                                  <?php
                                      foreach ($sk_group as $key) {
                                  ?>
                                  <option value="<?= $key->sk_group_id ?>">
                                      <?= $key->sk_group_nm ?>
                                  </option>
                                  <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10 d-flex justify-content-end">
                              <div class="form-check">
                                <button type="button" class="btn btn-sm btn-primary" onclick="tampilkansoal()">Tampilkan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- <div class="col-md-6 d-flex flex-column justify-content-end">
                      <div class="d-flex justify-content-end mb-2">
                          <a href="<?= base_url() ?>/admin/soal/viewTambahsoal" class="btn btn-primary mr-2"><i class="fa fa-sm fa-plus"></i> Tambah Soal</a>
                      </div>
                    </div> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="tbl_soal" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="10" style="text-align: center;">No.</th>
                        <th style="text-align: center;">Kolom Soal</th>
                        <th style="text-align: center;">Petunjuk</th>
                        <th style="text-align: center;" width="100">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
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
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  });

  tampilkansoal = () => {
    var sk_group_id = $("#sk_group_id").val();
    $("#tbl_soal").DataTable({
        ajax: {
            url: "/admin/soalsikapkerjalatihan/showkolom",
            type: "POST",
            data: function(d) {
                d.sk_group_id = sk_group_id
            },
            dataSrc: function(json) {
                let nomor = 1
                json.forEach((row, idx) => {
                    if (idx > 0) {
                        nomor++
                    }
                    row.nomor = nomor
                });

                return json
            }
        },
        bDestroy: true,
        pageLength: 100,
        columns: [{
                data: "nomor",
                className: "text-center",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "center")
                }
            },
            {
                data: "kolom_nm",
                className: "text-left"
            },
            {
                data: "clue",
                className: "text-center"
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                  console.log(data);
                  
                  if (data.clue == null) {
                    return `
                        <a href="<?= base_url() ?>/admin/soalsikapkerjalatihan/tambahsoalSkLatihan/${data.kolom_id}/4/98/${sk_group_id}" type="button" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>`;
                  }

                  if (data.kolom_id != null) {
                    return `
                        <a href="<?= base_url() ?>/admin/soalsikapkerjalatihan/detailsoal/${data.kolom_id}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                        <a href="<?= base_url() ?>/admin/soalsikapkerjalatihan/viewEditsoalSkLatihan/${data.kolom_id}/4/98/${sk_group_id}" type="button" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>`;
                  }
                  
                }
            }
        ]
    })
}

  function checkboxenable(jawaban_nm,kolom_id,soal_id) {
    var checkBox = document.getElementById('customSwitch1_'+kolom_id+'_'+soal_id);
    if (checkBox.checked) {
        var status_cd = "normal";
        var old_status = "disasble";
    } else {
      var status_cd = "disable";
      var old_status = "normal";
    }

    $.ajax({
          url: "<?= base_url('soal/updatestatus') ?>",
          type: "post",
          data: {
            "jawaban_nm" : jawaban_nm,
            "kolom_id"  : kolom_id,
            "status_cd" : status_cd,
            "old_status" : old_status
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
            $("#loader-wrapper").addClass("d-none");
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

  function tambahsoallatihan() {
    $.ajax({
        url: "<?= base_url('soal/tambahsoallatihan') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          alert("error");
        }
      });
  }

  function simpansoallatihan() {
    var kolom1 = $("#kolom1").val();
    var kolom2 = $("#kolom2").val();
    var kolom3 = $("#kolom3").val();
    var kolom4 = $("#kolom4").val();
    var kolom5 = $("#kolom5").val();
    var kolom6 = $("#kolom6").val();
    var kolom7 = $("#kolom7").val();
    var kolom8 = $("#kolom8").val();
    var kolom9 = $("#kolom9").val();
    var kolom10 = $("#kolom10").val();
    var materi = document.getElementsByName("materix");
    var checkBox = ""
        for (var i = 0, length = materi.length; i < length; i++) {
            if (materi[i].checked) {
                checkBox = "checked";
                break;
            }
        }
    
    if (checkBox == "checked") {
      var materi_id = $("input[name='materix']:checked").val();
      // alert(materi_id);

      if (kolom1.length < 5 && kolom1.length > 0) {
        alert("Jumlah karakter pada KOLOM 1 kurang dari 5");
        document.getElementById("kolom1").focus();
        return;
      } 
      
      if (kolom2.length < 5 && kolom2.length > 0) {
        alert("Jumlah karakter pada KOLOM 2 kurang dari 5");
        document.getElementById("kolom2").focus();
        return;
      }

      if (kolom3.length < 5 && kolom3.length > 0) {
        alert("Jumlah karakter pada KOLOM 3 kurang dari 5");
        document.getElementById("kolom3").focus();
        return;
      }

      if (kolom4.length < 5 && kolom4.length > 0) {
        alert("Jumlah karakter pada KOLOM 4 kurang dari 5");
        document.getElementById("kolom4").focus();
        return;
      }

      if (kolom5.length < 5 && kolom5.length > 0) {
        alert("Jumlah karakter pada KOLOM 5 kurang dari 5");
        document.getElementById("kolom5").focus();
        return;
      }

      if (kolom6.length < 5 && kolom6.length > 0) {
        alert("Jumlah karakter pada KOLOM 6 kurang dari 5");
        kdocument.getElementById("kolom6").focus();
        return;
      }

      if (kolom7.length < 5 && kolom7.length > 0) {
        alert("Jumlah karakter pada KOLOM 7 kurang dari 5");
        document.getElementById("kolom7").focus();
        return;
      }

      if (kolom8.length < 5 && kolom8.length > 0) {
        alert("Jumlah karakter pada KOLOM 8 kurang dari 5");
        document.getElementById("kolom8").focus();
        return;
      }

      if (kolom9.length < 5 && kolom9.length > 0) {
        alert("Jumlah karakter pada KOLOM 9 kurang dari 5");
        document.getElementById("kolom9").focus();
        return;
      }

      if (kolom10.length < 5 && kolom10.length > 0) {
        alert("Jumlah karakter pada KOLOM 10 kurang dari 5");
        document.getElementById("kolom10").focus();
        return;
      }  

        $.ajax({
        url: "<?= base_url('soal/simpansoallatihan') ?>",
        type: "post",
        dataType: "json",
        data: {
          "kolom1" : kolom1,
          "kolom2" : kolom2,
          "kolom3" : kolom3,
          "kolom4" : kolom4,
          "kolom5" : kolom5,
          "kolom6" : kolom6,
          "kolom7" : kolom7,
          "kolom8" : kolom8,
          "kolom9" : kolom9,
          "kolom10" : kolom10,
          "materi_id" : materi_id
        },
        beforeSend: function() {
          $("#loader-wrapper").removeClass("d-none")
        },
        success: function(data) {
          $("#loader-wrapper").addClass("d-none");
          $('#modal-lg').modal("hide");
          alert("Sukses");
          
        },
        error: function() {
          $("#loader-wrapper").addClass("d-none");
          alert("error");
        }
      });
    } else {
      alert("pilih materi dahulu");
    }
}

  function tambahsoal() {
    $.ajax({
        url: "<?= base_url('soal/tambahsoal') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          alert("error");
        }
      });
  }

  function editsoal(soal_id) {
    $.ajax({
        url: "<?= base_url('soal/editsoal') ?>",
        type: "post",
        dataType: "json",
        data: {
          "soal_id": soal_id
        },
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          alert("error");
        }
      });
  }

  function simpansoal() {
      var formdata = new FormData();
      var soal_nm = $("#soal_nm").val();
      var kunci = $("#kunci").val();
      var no_soal = $("#no_soal").val();
      var group_id = $("input[name='group_nm']:checked").val();
      var materi = $("input[name='materi']:checked").val();

      jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
        formdata.append('soal_img['+i+']', file);
      });
      formdata.append('soal_nm',soal_nm);
      formdata.append('kunci',kunci);
      formdata.append('no_soal',no_soal);
      formdata.append('group_id',group_id);
      formdata.append('materi',materi);
      $.ajax({
        url: "<?= base_url('soal/simpansoal') ?>",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) {
          $('#modal-lg').modal("hide");
          alert("Sukses");
        },
        error: function() {
          alert("error");
        }
      });
  }
  

  
function hapussoal(soal_id) {

  Swal.fire({
        title: "Apakah anda yakin hapus data ini?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yakin"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "<?= base_url('soal/hapussoal') ?>",
              type: "post",
              dataType: "json",
              data: {
                "soal_id": soal_id
              },
              success: function(data) {
                $('#modal-lg').modal("hide");
                  Swal.fire("Soal berhasil dihapus", "", "success");
                  tampilkansoal();
              },
              error: function() {
                alert("error");
              }
          });
        }
      });
}

function showjawaban(soal_id) {
  var td_form = document.querySelectorAll(".td_form");
  if (td_form.length !== 0) {
      for (let i = 0; i < td_form.length; i++) {
        td_form[i].remove();
      }
  }
      $.ajax({
        url: "<?= base_url('soal/showjawaban') ?>",
        type: "post",
        dataType: "json",
        data: {
          "soal_id": soal_id
        },
        success: function(data) {
          $('#tr_data_'+soal_id).html(data);
        },
        error: function() {
          alert("error");
        }
      });
  }


function plusbtn(soal_id,jawaban_id) {
  var tr_form = document.getElementById("tr_form_"+soal_id+"_"+jawaban_id);
  var table   = document.getElementById("tb_jawaban"+soal_id);
  var table_len = (table.rows.length);
  var row = table.insertRow(table_len).outerHTML = "<tr class='tr_form' id='tr_form_"+soal_id+"_"+table_len+"'><td style='text-align:center;width:50px;'><button onclick='timesbtn("+soal_id+","+table_len+")' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td><td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' name='pilihan_nm[]' data-id='new'/> </td><td><input style='padding-left:10px;width:100%;' type='text' name='jawaban_nm[]'/></td></tr>";

}

function checkbtn(soal_id) {
      var formdata = new FormData();
      var pilihan_nm = [];
      var jawaban_nm = [];
      var jawaban_id = [];


      jQuery.each($("input[name='jawaban_img[]'")[0].files, function(i, file) {
        formdata.append('jawaban_img['+i+']', file);
      });

      $("input[name='jawaban_img[]'").each(function() {
        jawaban_id.push($(this).data("jawaban_id"));
      });

      // var jawaban_id = $("input[name='jawaban_img[]'").map(function() {
      //     return {
      //       jawaban_id: $(this).data("jawaban_id")
      //     };
      // }).get();


      var pilihan_nm = $("input[name='pilihan_nm[]'").map(function() {
            return {
                id: $(this).data("id"),
                value: $(this).val()
            };
        }).get();

      $("input[name='jawaban_nm[]'").each(function() {
        jawaban_nm.push($(this).val());
      });

      formdata.append('pilihan_nm',pilihan_nm);
      formdata.append('jawaban_nm',jawaban_nm);
      formdata.append('soal_id',soal_id);
      formdata.append('jawaban_id',jawaban_id);

      $.ajax({
          url: "<?= base_url('soal/simpanjawaban') ?>",
          type: "post",
          data: formdata,
          contentType: false,
          processData: false,
          
          success: function(data) {
            alert("Sukses");
            showjawaban(soal_id);
          },
          error: function() {
            alert("error");
          }
      });
}

function deletebtn(soal_id,jawaban_id) {
  let text = "Apakah anda yakin menghapus data ini ?";
  if (confirm(text) == true) {
    $.ajax({
          url: "<?= base_url('soal/deletejawaban') ?>",
          type: "post",
          dataType: "json",
          data: {
            "jawaban_id": jawaban_id
          },
          success: function(data) {
            if (data == "sukses") {
              alert("Sukses");
            } else {
              alert("Gagal");
            }
            document.getElementById("tr_form_"+soal_id+"_"+jawaban_id).outerHTML="";
            showjawaban(soal_id);
          },
          error: function() {
            alert("error");
          }
      });
  } else {

  }
  
}

function timesbtn(soal_id,jawaban_id) {
  document.getElementById("tr_form_"+soal_id+"_"+jawaban_id).outerHTML="";
}

function simpangambarjawaban(soal_id,jawaban_id) {

}
</script>
</body>
</html>