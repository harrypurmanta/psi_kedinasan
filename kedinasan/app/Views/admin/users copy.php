<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Users</title>

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
            <h1>Data Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
              <button onclick="tambahuser()" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">No.</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">TTL</th>
                    <th style="text-align:center;">Jenis Kelamin</th>
                    <th style="text-align:center;">Username</th>
                    <th style="text-align:center;">No. Hp</th>
                    <th style="text-align:center;">Alamat</th>
                    <th style="text-align:center;">Level</th>
                    <th style="text-align:center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                        foreach ($users as $key) {
                         
                    ?>
                  <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= $key->person_nm ?></td>
                    <td style="text-align:center;"><?= $key->satuan ?></td>
                    <td style="text-align:center;"><?= $key->birth_place ?>, <?= $key->birth_dttm ?></td>
                    <td style="text-align:center;"><?= $key->gender_cd ?></td>
                    <td style="text-align:center;"><?= $key->user_nm ?></td>
                    <td style="text-align:center;"><?= $key->cellphone ?></td>
                    <td><?= $key->addr_txt ?></td>
                    <td><?= $key->user_group ?></td>
                    <td style="text-align:center;"><button onclick="editperson(<?= $key->person_id ?>)" style="font-size:10px;" class="btn btn-secondary" data-toggle="modal" data-target="#modal-lg">Edit</button> <button onclick="hapusperson(<?= $key->person_id ?>)" style="font-size:10px;" class="btn btn-danger">Hapus</button> 
                    <a href=""><button type="button" class="btn btn-primary">Hasil</button></a>
                    <!-- <div class="btn-group" style="margin-top:10px;">
                      
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/1">Excel 1</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/2">Excel 2</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/3">Excel 3</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/4">Excel 4</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/5">Excel 5</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/6">Excel 6</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilexcel/<?= $key->user_id ?>/7">Excel 7</a>
                        
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/1">Web 1</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/2">Web 2</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/3">Web 3</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/4">Web 4</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/5">Web 5</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/6">Web 6</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasilweb/<?= $key->user_id ?>/7">Web 7</a>
                        <a target="_blank" class="dropdown-item" href="<?= base_url() ?>/admin/users/hasillatihan/<?= $key->user_id ?>/5">Sikap Kerja Latihan</a>
                      </div> -->
                    <!-- </div> -->
                  </td>
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

  function tambahuser() {
    $.ajax({
        url: "<?= base_url('admin/users/tambahuser') ?>",
        success: function(data) {
          $('#modal_body').html(data);
        },
        error: function() {
          alert("error");
        }
      });
  }

  function editperson(person_id) {
    $.ajax({
        url: "<?= base_url('admin/users/edituser') ?>",
        type: "post",
        dataType: "json",
        data: {
          "person_id": person_id
        },
        success: function(data) {
          $('#modal_body').html(data);
        },
        error: function() {
          alert("error");
        }
      });
  }

  function simpanuser() {
    
      var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
     
      $.ajax({
        url: "<?= base_url('admin/users/simpanuser') ?>",
        type: "post",
        dataType: "json",
        data: {
            "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd
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
          var cell8 = row.insertCell(7);
          var cell9 = row.insertCell(8);
          var cell10 = row.insertCell(9);
          cell1.style.textAlign = "center";
          cell2.style.textAlign = "center";
          cell3.style.textAlign = "justify";
          cell4.style.textAlign = "center";
          cell5.style.textAlign = "center";
          cell6.style.textAlign = "center";
          cell7.style.textAlign = "center";
          cell8.style.textAlign = "center";
          cell9.style.textAlign = "center";
          cell10.style.textAlign = "center";
          cell1.innerHTML = "new";
          cell2.innerHTML = person_nm;
          cell3.innerHTML = satuan;
          cell4.innerHTML = birth_place+","+birth_dttm;
          cell8.innerHTML = gender_cd;
          cell7.innerHTML = user_nm;
          cell5.innerHTML = cellphone;
          cell6.innerHTML = addr_txt;
          cell8.innerHTML = user_group;
          cell9.innerHTML = "<button data-toggle='modal' data-target='#modal-lg' onclick='editperson("+data.person_id+")' style='font-size:10px;' class='btn btn-secondary'>Edit</button> <button style='font-size:10px;' class='btn btn-danger' onclick='hapuspersom("+data.person_id+")'>Hapus</button>";
        },
        error: function() {
          alert("error");
        }
      });
  }
  

  function updateuser(person_id) {
    
    var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
   
    $.ajax({
      url: "<?= base_url('admin/users/updateuser') ?>",
      type: "post",
      dataType: "json",
      data: {
        "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd,
            "person_id" : person_id
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

function hapusperson(person_id) {
    $.ajax({
      url: "<?= base_url('admin/users/hapususer') ?>",
      type: "post",
      dataType: "json",
      data: {
        "person_id": person_id
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