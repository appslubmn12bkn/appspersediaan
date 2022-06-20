<?php
error_reporting(0);
include "config/koneksi.php";
session_start();

$q = mysqli_query($koneksi, 
"SELECT count(a.registrasi) as jml,
a.unut,
b.id_unut, b.ur_unut
FROM m_barangunit a
LEFT JOIN m_unut b ON b.id_unut=a.unut
WHERE a.flagmohon='3'");
if(mysqli_num_rows($q) > 0) {
  $row = mysqli_fetch_assoc($q);
}

$cek=umenu_akses("?module=pesanSetuju",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin' OR $_SESSION[level]=='user'){
echo "
<li>
  <a href='?module=persetujuanBarang'>
    <i class='icon fa fa-angle-double-right'></i>
    NOTIF BARANG <span class='badge badge-primary badge-pill float-right'>$row[jml]</span>
  </a>
</li>";
}

$blanko = mysqli_query($koneksi, 
"SELECT count(a.mh_kode) as jml,
a.proc_mohon
FROM m_blankomohon a
WHERE a.proc_mohon='3'");
if(mysqli_num_rows($q) > 0) {
  $rs = mysqli_fetch_assoc($blanko);
}
$cek=umenu_akses("?module=persetujuanBlanko",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin' OR $_SESSION[level]=='user'){
echo "
<li>
  <a href='?module=persetujuanBlanko'>
    <i class='icon fa fa-angle-double-right'></i>
    NOTIF BLANKO <span class='badge badge-danger badge-pill float-right''>$rs[jml]</span>
  </a>
</li>";
}

$notifbmn = mysqli_query($koneksi, 
"SELECT count(a.kdregister) as jml,
a.flag
FROM m_bmnpinjamunit a
WHERE a.flag='81'");
if(mysqli_num_rows($q) > 0) {
  $notif = mysqli_fetch_assoc($notifbmn);
}
$cek=umenu_akses("?module=setujuPinjambmn",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin' OR $_SESSION[level]=='user'){
echo "
<li>
  <a href='?module=setujuPinjambmn'>
    <i class='icon fa fa-angle-double-right'></i>
    NOTIF PINJAM BMN <span class='badge badge-success badge-pill float-right'>$notif[jml]</span>
  </a>
</li>";
}
?>
