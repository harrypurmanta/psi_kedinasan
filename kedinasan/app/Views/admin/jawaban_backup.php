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
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">No.</th>
                    <th style="text-align:center;">Jawaban</th>
                    <th style="text-align:center;">Pilihan</th>
                    <th style="text-align:center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                        foreach ($jawaban as $key) {
                         
                    ?>
                  <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= $key->jawaban_nm ?></td>
                    <td style="text-align:center;"><?= $key->pilihan_nm ?></td>
                    <td style="text-align:center;"><button onclick="editsoal(<?= $key->soal_id ?>)" style="font-size:10px;" class="btn btn-secondary" data-toggle="modal" data-target="#modal-lg">Edit</button> <button onclick="hapussoal(<?= $key->soal_id ?>)" style="font-size:10px;" class="btn btn-danger">Hapus</button></td>
                  </tr>
                    <?php
                        }
                    ?>
                  </tbody>
                </table>
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

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

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
  });

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
</script>
</body>
</html>