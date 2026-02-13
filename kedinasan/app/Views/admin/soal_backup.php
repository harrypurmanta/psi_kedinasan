<?php 
  $this->session = \Config\Services::session();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Soal</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
  <style>
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
            <h1>Soal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Soal</li>
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
              <div class="col-lg-12">
                <div class="col-lg-1" style="display:inline-block;text-align:left;width:100%;">
                  <button style="margin-bottom:10px;" onclick="tambahsoal()" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">Tambah</button>
                  <button onclick="tambahsoallatihan()" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">Tambah SK</button>
                </div>
                <div class="col-lg-4" style="display:inline-block;text-align:center;width:100%;">
                  <?php
                    foreach ($materi as $mtr) {
                  ?>
                  <label> <input <?= ($mtr->materi_id == $this->session->materi_filter?"checked":"") ?> onclick="showsoal('filter')" type="radio" value="<?= $mtr->materi_id ?>" id="materi_id" name="materi_filter" style="margin-left:10px;"/> <?= $mtr->materi_nm ?> </label>
                  <?php
                    }
                  ?>
                </div>
                <div class="col-lg-5" style="display:inline-block;text-align:center;width:100%;">
                  <?php
                    foreach ($group as $grp) {
                    
                  ?>
                  <label> <input <?= ($grp->group_soal_id == $this->session->group_filter?"checked":"") ?> onclick="showsoal('filter')" type="radio" value="<?= $grp->group_soal_id ?>" id="group_id" name="group_filter" style="margin-left:10px;"/> <?= $grp->group_nm ?> </label>
                  <?php
                    }
                  ?>
                </div>
                <div class="col-lg-1" style="display:inline-block;text-align:right;width:100%;">
                  <button onclick="showsoal('all')" class="btn btn-secondary">Soal SK</button>
                </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="dv_cardbody">
                    <?= $soal; ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="padding: 0px 10px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="modal_body" class="modal-body">

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
     
    </div>
    <div class="d-none" id='loader-wrapper'>
        <div class="loader"></div>
      </div>
  </div>
  
 

</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
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

  function showsoal(filter) {
      var group_id = $("input[name='group_filter']:checked").val();
      var materi = $("input[name='materi_filter']:checked").val();
      
      if (materi == undefined && filter == "filter") {
          
      } else {
        $.ajax({
          url: "<?= base_url('soal/showsoal') ?>",
          type: "post",
          data: {
            "filter" : filter,
            "group_id": group_id,
            "materi": materi,
          },
          beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
              },
          success: function(data) {
            $("#loader-wrapper").addClass("d-none");
            $('#dv_cardbody').html(data);
          },
          error: function() {
            alert("error");
          }
        });
      }
      
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

  function simpansoallatihan(materi_id) {
    
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

    var checkBox = document.getElementById('materi_'+materi_id);
    if (checkBox.checked) {
      var materi_id = $("#materi_"+materi_id).val();
    } else {
      alert("pilih materi dahulu");
    }

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
    
      var soal_nm = $("#soal_nm").val();
      var kunci = $("#kunci").val();
      var no_soal = $("#no_soal").val();
      var group_id = $("input[name='group_nm']:checked").val();
      var materi = $("input[name='materi']:checked").val();
     
      $.ajax({
        url: "<?= base_url('soal/simpansoal') ?>",
        type: "post",
        dataType: "json",
        data: {
          "soal_nm": soal_nm,
          "materi": materi,
          "kunci": kunci,
          "group_id": group_id,
          "no_soal": no_soal,
        },
        success: function(data) {
          $('#modal-lg').modal("hide");
          alert("Sukses");
          var table = document.getElementById("example2");
          var row   = table.insertRow(1);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          var cell6 = row.insertCell(5);
          var cell7 = row.insertCell(6);
          cell1.style.textAlign = "center";
          cell2.style.textAlign = "center";
          cell3.style.textAlign = "justify";
          cell4.style.textAlign = "center";
          cell5.style.textAlign = "center";
          cell6.style.textAlign = "center";
          cell7.style.textAlign = "center";
          cell1.innerHTML = "new";
          cell2.innerHTML = no_soal;
          cell3.innerHTML = soal_nm;
          cell4.innerHTML = kunci;
          cell5.innerHTML = materi;
          cell6.innerHTML = data.group_nm;
          cell7.innerHTML = "<button data-toggle='modal' data-target='#modal-lg' onclick='editsoal("+data.soal_id+")' style='font-size:10px;' class='btn btn-secondary'>Edit</button> <button style='font-size:10px;' class='btn btn-danger'  onclick='hapussoal("+data.soal_id+")'>Hapus</button>";
        },
        error: function() {
          alert("error");
        }
      });
  }
  

  function updatesoal(soal_id) {
    
    var soal_nm = $("#soal_nm").val();
    var kunci = $("#kunci").val();
    var no_soal = $("#no_soal").val();
    var group_id = $("input[name='group_nm']:checked").val();
    var materi = $("input[name='materi']:checked").val();
   
    $.ajax({
      url: "<?= base_url('soal/updatesoal') ?>",
      type: "post",
      dataType: "json",
      data: {
        "soal_id": soal_id,
        "soal_nm": soal_nm,
        "materi": materi,
        "kunci": kunci,
        "group_id": group_id,
        "no_soal": no_soal,
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
        alert("Sukses");
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        alert("error");
      }
    });
}

function hapussoal(soal_id) {

    $.ajax({
      url: "<?= base_url('soal/hapussoal') ?>",
      type: "post",
      dataType: "json",
      data: {
        "soal_id": soal_id
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
          alert("Sukses");
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        alert("error");
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