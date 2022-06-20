<?php 
session_start();
error_reporting(0);
error_reporting('E_NONE');
include "config/koneksi.php";

$PASSWORD = $_SESSION['password'];
$UNAME	  = $_SESSION['uname'];
if(!empty($_SESSION['uname']) && !empty($_SESSION['password']))
{
		$cek="SELECT * FROM a_useraktif WHERE UNAME ='$UNAME' AND PASSWORD ='$PASSWORD'";
		$result=mysqli_query($koneksi, $cek);
		$hasil=mysqli_num_rows($result);
		if (empty($hasil))
		{ header("location:login.php", true, 301); exit; }
		else
		{ header("location:appsmedia.php?module=home", true, 301); exit; }
}
else 
{ header("location:login.php"); exit; }
?>