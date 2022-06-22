<?php 
include "config/koneksi.php";
$tgl = mysqli_query($koneksi, "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC" );
$rs  = mysqli_fetch_array($tgl);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/sweetalert/css/sweetalert.css" />
    <script src="bower_components/sweetalert/js/sweetalert.min.js"></script>

    <title>appspersediaan</title>
  </head>
  <body>
  <br><br><br>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <img src="assets/images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
          <h6 align='center'>created : siluman</h6>
        </div>
        <div class="col-md-7 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In to <strong>apps.persediaan</strong></h3>
              <p class="mb-4">Layanan permintaan ATK, Bakom dan Rumah Tangga.</p>
            </div>
            <form action="ceklog.php" method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="uname">
              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" >
              </div>  
              <div class="form-group last mb-4">
                <input type="text" class="form-control" value='<?php echo "$rs[s_thnang]";?>' readonly>
                <small>Tahun Anggaran</small>
              </div> 
              
              <img class="captchaImg" src="config/captcha.php" align="left">
              <div class="col-xs-8">
                <div class="form-group has-feedback">
                  <input type="text" id="captcha" name="captcha" class="form-control">
                  <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
                  <small>Masukkan Pengaman (jumlahkan)</small>
                </div> 
              </div>

              <div class="col-xs-12">
              <button type="submit" class="btn text-white btn-primary btn-block"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;&nbsp;Masuk</button>
            </div>
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
<?php
		error_reporting(0);
		error_reporting('E_NONE');
		if ($_GET['act'] == 1)
		{?> 
		<script>
		swal("ERROR", "User dan Password Salah atau belum aktifasi", "error");
		</script>	
		<?php
		}
		if ($_GET['act'] == 2)
		{?>
		<script>
		swal("PERINGATAN", "Username, Password Atau Kode Pengaman belum diisi !", "warning");
		</script>
		<?php
		}
		if ($_GET['act'] == 3)
		{?>
		<script>
		swal("ERROR", "Captcha Salah", "error");
		</script>
		<?php
		}
		if ($_GET['act'] == 4)
		{?>
		<script>
		swal("INFORMASI", "Anda telah meninggalkan aplikasi selama lebih dari 10 menit Untuk keamanan, silahkan login kembali", "info");
		</script>
		<?php
		}
		?>