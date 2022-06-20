<?php
	include "../config/koneksi.php";

if (mysqli_connect_errno()) {
 printf("Connect failed: %s\n", mysqli_connect_error());
 exit();
}

$NIP = $_POST['NIP2']; // Menerima NPM dari JQuery Ajax dari form
$s = mysqli_query($koneksi, "select PNS_NIPBARU, PNS_PNSNAM from m_pupns where PNS_NIPBARU='$NIP'"); // Ambil nama mahasiswa berdasarkan npm yang dikirim dari jquery ajax
while ($data = mysqli_fetch_array($s)) { 
 echo $data[1]; // Print nama hasil perolehan dari query database
}


?>
