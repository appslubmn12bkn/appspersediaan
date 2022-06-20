<?php
	session_start();
	require_once ("config/session_out.php");
	include "config/koneksi.php";
	require_once ("helper/fungsi-validasi.php");
	date_default_timezone_set("Asia/Jakarta");

	$peraturan = [
		'UNAME' => ['required'],
		'PASSWORD' => ['required'],
		'captcha' => ['required']
	];
	

	$U_NAME  = mysqli_real_escape_string($koneksi, $_POST['uname']);
	$PASSWORD  = mysqli_real_escape_string($koneksi, md5($_POST['password']));


	if(!empty($U_NAME) && !empty($PASSWORD) && !empty($_POST['captcha']))
	{
	   if($_POST['captcha'] == $_SESSION['captcha'])
	   {
		$sql="SELECT * FROM a_useraktif WHERE UNAME ='$U_NAME' AND PASSWORD ='$PASSWORD' AND AKTIF = '2'";
		$result=mysqli_query($koneksi, $sql);
		$count=mysqli_num_rows($result);
		if($count==1)
		{
			while($r=mysqli_fetch_array($result)){
			$_SESSION['ID']=$r['ID'];
			$_SESSION['NIP']	= $r['NIP'];
			$_SESSION['UNAME']	= $r['UNAME'];
			$_SESSION['EMAIL']     = $r['EMAIL'];
			$_SESSION['PASSWORD'] = $r['PASSWORD'];
			$_SESSION['LEVEL']	= $r['LEVEL'];
			$_SESSION['STATUS']	= $r['STATUS'];
			$_SESSION['FOTO']      = $r['FOTO'];
			$_SESSION['LOGIN_TERAKHIR']      = $r['LOGIN_TERAKHIR'];
			$_SESSION['SESS_ID']	= $r['SESSION_ID'];

			$_SESSION['LOGIN'] = 1;
			$_SESSION['STATUS'] = 'ONLINE';
			$old_sid = session_id();
			session_regenerate_id();
			$new_sid = session_id();
			mysqli_query($koneksi, "UPDATE a_useraktif SET SESSION_ID='$new_sid' where UNAME='$U_NAME'");
			header('location:appsmedia.php?module=home');

			$date = date('Y-m-d H:i:s');
			mysqli_query($koneksi, "UPDATE a_useraktif SET ISLOGIN = '1', LOGIN_TERAKHIR='$date' WHERE ID='$r[ID]'")
			or die (mysqli_error($koneksi));
			mysqli_query($koneksi, "UPDATE a_useraktif SET STATUS = 'ONLINE' WHERE ID ='$r[ID]'");
			mysqli_query($koneksi, "UPDATE a_useraktif SET LOGIN_TERAKHIR  = '$date' WHERE ID = '$_SESSION[ID]'");
			mysqli_query($koneksi, "UPDATE a_useraktif SET LOGIN_TERAKHIR  = '$date' WHERE UNAME = '$_SESSION[UNAME]'");
			}
			login_validate();						//setel waktu. jika halaman lebih dari 5 menit tidak digunakan, maka akan logout otomatis
			header('location:appsmedia.php?module=home');
		//	header("Location:index.php");
		}else{header("Location:login.php?act=1");  }//jika data tidak ditemukan
	   }else{header("Location:login.php?act=3"); }		// jika captcha salah
	}else{header("Location:login.php?act=2");	}		// jika field tidak diisi
?>
