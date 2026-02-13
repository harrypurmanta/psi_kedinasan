<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bintang Timur Prestasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/iCheck/square/blue.css"> -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte2.min.css">
</head>
<body class="hold-transition register-page">
  
<div class="mt-5">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="login/register" class="h1"><b>Daftar member baru</b></a>
    </div>
    <div class="card-body">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama lengkap" id="person_nm" name="person_nm"/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Satuan" id="satuan" name="satuan"/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-location"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <div class="col-5">
            <input type="text" class="form-control" placeholder="Tempat Lahir" id="birth_place" name="birth_place"/>
          </div>
          <div col="col-12">
            <input type="date" class="form-control" name="birth_dttm" id="birth_dttm" />
          </div>
        </div>

        <div class="input-group mb-3">
          <select class="form-control" name="gender_cd" id="gender_cd">
            <option value="m">Laki-laki</option>
            <option value="f">Perempuan</option>
          </select>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="user_nm" id="user_nm">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="No Handphone" name="cellphone" id="cellphone">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <textarea class="form-control" placeholder="Alamat" name="addr_txt" id="addr_txt"></textarea>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button onclick="simpanregister()" type="buttton" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>

      <a href="/login" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>

    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="<?= base_url() ?>/plugins/iCheck/icheck.min.js"></script>
<script>
 
    function simpanregister() {
      var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
     
      $.ajax({
        url: "<?= base_url('login/simpanregister') ?>",
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
            "gender_cd" : gender_cd
        },
        success: function(data) {
          if (data == "userada") {
            alert("No Handphone sudah ada");
          } else {
            alert("berhasil");
            location.href = "<?= base_url() ?>/login";
          }
        },
        error: function() {
          alert("error");
        }
      });
    }
    </script>

<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    </script>
</body>
</html>
