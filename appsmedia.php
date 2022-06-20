<?php
error_reporting(0);
error_reporting('E_NONE');
session_start();
require_once("config/session_out.php");
include "config/koneksi.php";
include "config/inc.library.php";
include "config/fungsi_indotgl.php";
$PASSWORD = $_SESSION['PASSWORD'];
$U_NAME  = $_SESSION['UNAME'];
if (!empty($_SESSION["expires_by"]) && !login_check()) {
  header("Location:logout.php?exp=1");
  exit(0);
} else {
  $cek = "SELECT * FROM a_useraktif WHERE UNAME ='$U_NAME' AND PASSWORD ='$PASSWORD'";
  $result = mysqli_query($koneksi, $cek);
  $hasil = mysqli_num_rows($result);

  if (empty($hasil)) {
    header("location:login.php");
    exit;
  }
}
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
  echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<center>Anda Tidak Berhak MengAkses Modul ini<br>
      Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}

function user_akses($mod, $nip)
{
  global $koneksi;
  $link = "?module=" . $mod;
  $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM s_modul,s_usemod WHERE s_modul.id_modul=s_usemod.id_modul AND s_usemod.id_session='$nip' AND s_modul.link='$link'"));
  return $cek;
}

//fungsi cek akses menu
function umenu_akses($link, $nip)
{
  global $koneksi;
  $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.id_modul, a.nmmodul,
														a.link, a.status,
														a.aktif,
														b.id_umod, b.id_session,
														b.id_modul
												FROM s_modul a
												LEFT JOIN s_usemod b ON b.id_modul=a.id_modul
												WHERE b.id_session = '$nip'
												AND a.link = '$link'"));
  return $cek;
}
//fungsi redirect
function akses_salah()
{
  $pesan = "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
 <center>Maaf Anda tidak berhak mengakses halaman ini</center>";
  $pesan = "<meta http-equiv='refresh' content='2;url=media.php?module=home'>";
  return $pesan;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AppsLU-PERSEDIAAN</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <?php include 'includes/css.php'; ?>

<body class="hold-transition skin-red layout-top-nav">
  <div class="wrapper">
    <?php include 'includes/head.php'; ?>
    <div class="content-wrapper">
      <?php include 'includes/content.php'; ?>
    </div>
  </div>
  <?php //include 'includes/aside.php'; ?>
  <div class="control-sidebar-bg"></div>
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/script.php'; ?>
  <?php include 'includes/script_hub.php'; ?>
</body>

</html>