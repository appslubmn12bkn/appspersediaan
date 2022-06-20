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

	if ($module == 'sedia_pengajuan' and $act == 'savePengajuan') {
		$create = date('Y-m-d');
		mysqli_query($koneksi, "INSERT INTO c_unitsediaminta
								SET	registrasi	= '$_POST[register]',
									unit		= '$_POST[unitk]',
									unut		= '$_POST[unut]',
									pemohon		= '$_POST[pic]',
									tglmohon	= '$_POST[tglmohon]',
									user		= '$_SESSION[NIP]',
									prosedur 	= '1'");
?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'PERMINTAAN BERHASIL',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=sedia_pengajuan');
			}, 1500);
		</script>
	<?php
		//header('location:../../media.php?module='.$module);
	} elseif ($module == 'sedia_pengajuan' and $act == 'upload') {
	  mysqli_query($koneksi, "	INSERT INTO c_sediakeluarunit
								SET	registrasi	= '$_POST[noreg]', 
									pemohon		= '$_POST[pic]',
									unut		= '$_POST[unut]',
									kd_brg		= '$_POST[kd_brg]', 
									qtyMohon	= '$_POST[qtyButuh]',
									qtyACC		= '0',
									merek_type	= '$_POST[merek_type]', 
									satuan		= '$_POST[satuan]',
									catatan		= '$_POST[catatan]',
									prosedur	= '1'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'Barang Berhasil ditambahkan',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=sedia_pengajuan&act=upload&registrasi=<?php echo"$_GET[registrasi]"; ?>');
			}, 1500);
		</script>
	<?php

		//header('location:../../media.php?module='.$module);
	}

	elseif ($module=='sedia_pengajuan' AND $act=='kirimPermohonan'){ 
	$n=$_POST['n'];
	for ($i=0;$i<=$n-1;$i++)
	{if(isset($_POST['registrasi'.$i]))
		{$registrasi=$_POST['registrasi'.$i];
		mysqli_query($koneksi,
		"UPDATE c_sediakeluarunit
		SET		prosedur	= '3',
				flag_kirim	= 'Y'
		WHERE registrasi		= '$registrasi'");

		mysqli_query($koneksi,
		"UPDATE c_unitsediaminta
		SET		prosedur	= '3',
				qtypesanan  = '$n'
		WHERE 	registrasi	= '$registrasi'");

	//header('location:../../appsmedia.php?module='.$module);
	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'Berhasil di Kirim! Pengajuan Unit akan segera di Proses',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=sedia_pengajuan');
			}, 1500);
		</script>
	<?php
	}}}

	elseif ($module=='sedia_pengajuan' AND $act=='hapus'){
	mysqli_query($koneksi, "DELETE FROM c_sediakeluarunit 
							WHERE kd_brg = '$_GET[kd_brg]' 
							AND registrasi = '$_GET[registrasi]' ");

	header('location:../../appsmedia.php?module='.$module.'&act='.upload.'&registrasi='.$_GET[registrasi].'');
	}

	elseif ($module=='c_aksiProsedia' AND $act=='cekBarang'){
	mysqli_query($koneksi," UPDATE c_sediakeluarunit 
						   	SET prosedur = '61' 
						   	WHERE registrasi = '$_GET[registrasi]' 
						   	AND kd_brg = '$_GET[kd_brg]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='6','61', prosedur) 
							WHERE registrasi = '$_GET[registrasi]'");

	header('location:../../appsmedia.php?module='.$module);
	}

	elseif ($module=='c_aksiProsedia' AND $act=='uncekBarang'){
	mysqli_query($koneksi,"	UPDATE c_sediakeluarunit 
						   	SET prosedur = '63', 
						   	   	alasantidaksesuai ='$_POST[alasantidaksesuai]', 
						   	   	qtytidaksesuai = '$_POST[qtytidaksesuai]' 
						   	
						   	WHERE registrasi = '$_POST[registrasi]' 
						   	AND kd_brg = '$_POST[kd_brg]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='6','71', IF(prosedur='61','71', IF(prosedur='63','71', IF(prosedur='71','71','prosedur')))) 
							WHERE registrasi = '$_POST[registrasi]'");

	header('location:../../appsmedia.php?module='.$module.'&act='.terimaBarang.'&registrasi='.$_POST[registrasi].'');
}

	elseif ($module=='c_aksiProsedia' AND $act=='terimaUnit'){
	mysqli_query($koneksi, "UPDATE c_sediakeluarunit 
							SET prosedur = IF(prosedur='61','7', IF(prosedur='63','63', IF(prosedur='7','7','41'))) 
							WHERE registrasi = '$_POST[registrasi]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='61','7', IF(prosedur='63','71', IF(prosedur='71','71','prosedur'))) 
							WHERE registrasi = '$_POST[registrasi]'");
	header('location:../../appsmedia.php?module='.$module);
}

	

}
?>