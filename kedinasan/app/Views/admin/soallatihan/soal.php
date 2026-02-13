<?php 
  $this->session = \Config\Services::session();
?>
<?= $this->include('admin/template/head') ?>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
 <!-- Navbar -->
 <?= $this->include('admin/navbar') ?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Soal Latihan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Soal Latihan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="col-md-6">
                  <form class="form-horizontal">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="group_id" class="col-sm-2 col-form-label">Group Soal</label>
                        <div class="col-sm-10">
                          <select name="group_id" id="group_id" class="form-control" onchange="getJenis()">
                              <option value="" disabled <?= ($this->session->group_id == null ? "" : "selected") ?>>Pilih Materi Soal</option>
                              <?php
                                  foreach ($group as $key) {
                              ?>
                              <option value="<?= $key->group_soal_id ?>">
                                  <?= $key->group_nm ?>
                              </option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_id" class="col-sm-2 col-form-label">Jenis Soal</label>
                        <div class="col-sm-10">
                          <select name="jenis_id" id="jenis_id" class="form-control" onchange="setSessionJenis()">
                             
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
              <div class="col-lg-12">
                <a href="<?= base_url() ?>/admin/soallatihan/viewTambahsoal" class="btn btn-primary">Tambah Soal</a>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="tbl_soal" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="text-center" width="25">No.</th>
                        <th class="text-center" width="55">No. Soal</th>
                        <th class="text-center">Soal</th>
                        <th class="text-center">Kunci</th>
                        <th class="text-center" width="100">Aksi</th>
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
    getJenis();
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

  function setSessionJenis() {
      var group_id = $('#group_id').val();
      var jenis_id = $('#jenis_id').val();
      $.ajax({
          url: "<?= base_url('admin/soallatihan/setSessionJenis') ?>",
          type: "post",
          dataType: 'json',
          data: {
            "group_id" : group_id,
            "jenis_id" : jenis_id
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
           $("#loader-wrapper").addClass("d-none");
          },
          error: function(xhr, status, error) {
            console.error('Gagal mengambil data:', error);
          }
      });
  }

  function getJenis() {
    var group_id = $('#group_id').val();
      $.ajax({
          url: "<?= base_url('admin/soallatihan/getJenis') ?>",
          type: "post",
          dataType: 'json',
          data: {
            "group_id" : group_id
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
            $('#jenis_id').empty();
            $.each(data, function(index, item) {
              $('#jenis_id').append(
                `<option value="${item.jenis_id}">${item.jenis_nm}</option>`
              );
            });
            $("#loader-wrapper").addClass("d-none");
          },
          error: function(xhr, status, error) {
            console.error('Gagal mengambil data:', error);
          }
        });
  }

  tampilkansoal = () => {
    var group_id = $("#group_id").val();
    var jenis_id = $("#jenis_id").val();
    $("#tbl_soal").DataTable({
        ajax: {
            url: "<?= base_url('admin/soallatihan/showsoal') ?>",
            type: "POST",
            data: function(d) {
                d.jenis_id = jenis_id,
                d.group_id = group_id
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
                data: "no_soal",
                className: "text-center"
            },
            {
                data: "soal_nm",
                className: "text-left"
            },
            {
                data: "kunci",
                className: "text-center"
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                  return `
                  <a href="<?= base_url() ?>/admin/soallatihan/viewEditsoal/${data.soal_id}" type="button" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                  <button type="button" class="btn btn-sm btn-danger" onclick="hapussoal(${data.soal_id})"><i class="fas fa-trash"></i></button>`
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
              url: "<?= base_url('soallatihan/hapussoal') ?>",
              type: "post",
              dataType: "json",
              data: {
                "soal_id": soal_id
              },
              success: function(data) {
                if (data = "sukses") {
                  Swal.fire({
                      title: "Soal berhasil di hapus",
                      icon: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "OK"
                      }).then((result) => {
                      if (result.isConfirmed) {
                          tampilkansoal();
                      }
                  }); 
                }
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