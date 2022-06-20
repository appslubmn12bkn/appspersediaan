<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
<link rel="stylesheet" type="text/css" href="bower_components/sweetalert/css/sweetalert.css" />
<script src="bower_components/sweetalert/js/sweetalert.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>
<?php
error_reporting(0);
error_reporting('E_NONE');
	 session_start(); 
	 include 'config/koneksi.php';
	 $sess_id	= $_SESSION['NIP'];
	 $sess_user	= $_SESSION['UNAME'];
	unset($_SESSION['UNAME']); 
	unset($_SESSION['PASSWORD']);
	unset($_SESSION['ID']);
	session_destroy();
	if($_GET['exp'] == 1)
	{ 
		header("Location: login.php?act=4");
		mysqli_query($koneksi, "UPDATE a_useraktif SET ISLOGIN = '0' WHERE UNAME = '$sess_id'") or die (mysqli_error($koneksi));
		mysqli_query($koneksi, "UPDATE a_useraktif SET status = 'OFFLINE' WHERE UNAME = '$sess_id'") 
		or die (mysqli_error($koneksi));
	}
	else
	{ 
	?>	
	<script type="text/javascript">
	setTimeout(function () {
	swal({
	title: 'SUKSES',
	text: 'Anda Telah berhasil Keluar dari System',
	type: 'success',
	showConfirmButton: false
	});
	},10);
	window.setTimeout(function(){
	window.location.replace('login.php');
	} ,1500);
	</script>
	<?php
		mysqli_query($koneksi, "UPDATE a_useraktif SET islogin = '0' WHERE nip = '$sess_id'") or die (mysqli_error($koneksi));
		mysqli_query($koneksi, "UPDATE a_useraktif SET status = 'Offline' WHERE nip = '$sess_id'") 
		or die (mysqli_error($koneksi));
		
	}
	
?>



