<?php
error_reporting(0);
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
  Buku Transaksi BMN
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    Historical BMN
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    Laporan Persediaan
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    BA Pinjam Pakai
  </a>
</li>";
}

?>
