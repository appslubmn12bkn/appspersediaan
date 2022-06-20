<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<link rel="stylesheet" type="text/css" href="../../bower_components/sweetalert/css/sweetalert.css" />
	<script src="../../bower_components/sweetalert/js/sweetalert.min.js"></script>
	<script src="../../bower_components/sweetalert/js/jquery.1.12.0-min.js"></script>
</head>

</html>
<?php
session_start();
include "../../config/koneksi.php";
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
	echo "<link href='../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
			<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {


	$module = $_GET['module'];
	$act = $_GET['act'];

	if ($module == 't_mohon' and $act == 'simpanlayanan') {
		mysqli_query($koneksi, "INSERT INTO t_layananumum
								SET	t_notickets		= '$_POST[tiket]',
									t_unut			= '$_POST[unut]',
									t_unit			= '$_POST[unik]',
									t_jnslayanan	= '$_POST[jnslayanan]',
									t_pictransaksi	= '$_SESSION[NIP]',
									t_prosedur = '1'");
?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'PERMOHONAN LAYANAN BERHASIL',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=t_mohon');
			}, 1500);
		</script>
	<?php
		//header('location:../../media.php?module='.$module);
	} elseif ($module == 't_mohon' and $act == 'alamatBaru') {
		mysqli_query($koneksi, "INSERT INTO t_dbalamat
								SET	t_kode		= '$_POST[kdalamat]', 
									t_alamat	= '$_POST[alamat]',
									t_kdpos		= '$_POST[kdpos]',
									t_naminst	= '$_POST[inst]'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'Alamat Baru Berhasil ditambahkan',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=t_mohon&act=layananbaru&jnslayanan=<?php echo"$_GET[jnslayanan]"; ?>&tiket=<?php echo"$_GET[tiket]"; ?>&unut=<?php echo"$_GET[unut]"; ?>');
			}, 1500);
		</script>
	<?php

		//header('location:../../media.php?module='.$module);
	}

	if ($module == 't_mohon' and $act == 'layananBaru') {
		$tglupdate = date('Y-m-d');
		mysqli_query($koneksi, "INSERT INTO t_layananmobil
				SET	t_notickets 	= '$_POST[tiket]',
					t_unut			= '$_POST[unut]',
					t_tglpesan		= '$_POST[tglpesan]',
					t_jnslayanan	= '$_POST[jnslayanan]',
					t_tglberangkat 	= '$_POST[tglberangkat]',
					t_wawal 		= '$_POST[jampesan]',
					t_tujuan 		= '$_POST[dbalamat]',
					t_pic 			= '$_POST[pic]',
					p_prosedur		= '2',
					t_wapic 		= '$_POST[wapic]'");

		mysqli_query($koneksi, "UPDATE t_layananumum
				SET	t_prosedur 	= '2'
				WHERE t_notickets = '$_POST[tiket]' AND t_unut = '$_POST[unut]'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'PERMOHONAN SUDAH DIKIRIM, SEGERA DI PROSES',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=t_mohon');
			}, 1500);
		</script>
<?php
		//header('location:../../media.php?module='.$module);
	}
}
?>