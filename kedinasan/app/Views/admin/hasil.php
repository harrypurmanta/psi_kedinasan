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
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">
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
            <h1>Data Hasil Users</h1>
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
                <table>
                    
                    <?php
                    foreach ($user as $key) {
                        $dttm = explode(" ",$key->birth_dttm);
                        echo "<tr><td>Nama</td><td>:</td><td>".$key->person_nm."</td></tr>";
                        echo "<tr><td>TTL</td><td>:</td><td>".$key->birth_place.",".$dttm[0]."</td></tr>";
                    }
                    ?>
                </table>
                </div>
              <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">Materi</th>
                    <th style="text-align:center;">latihan</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td style="text-align:center;">
                   
                        <?php
                            foreach ($materi as $km) {
                                echo " <div><a target='_blank' href='".base_url()."/admin/users/hasilexcel/$user_id/".$km->materi_id."'>Excel ".$km->materi_nm."</a> | <a target='_blank' href='".base_url() ."/admin/users/hasilweb/$user_id/".$km->materi_id."'>Web ".$km->materi_nm."</a> | <a target='_blank' href='".base_url() ."/admin/users/hasilpdf/$user_id/".$km->materi_id."'>PDF ".$km->materi_nm."</a></div>";

                            }
                        ?>
                        
                    </td>
                    
                    <td style="text-align:center;"><a target="_blank" href="<?= base_url() ?>/admin/users/hasillatihan/<?= $user_id ?>/5">Sikap Kerja</a> | <span onclick="listmaterilatihan()" style="cursor:pointer;">Materi</span> | <span style="cursor:pointer;" onclick="listsubmaterilatihan()">Sub Materi</span>
                    <div class="col-md-12" id="listlatihan"></div>
                    </td>
                    
                  </tr>
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
<script src="<?= base_url() ?>/dist/dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
 function listmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          alert("error");
        }
    });
 }

 function listsubmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listsubmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          alert("error");
        }
    });
}
</script>
</body>
</html>