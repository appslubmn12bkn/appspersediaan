<?php
error_reporting(0);
include "config/koneksi.php";
session_start();

$cek=umenu_akses("?module=prosesLayananBarang",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=prosesLayananBarang'>
    Proses Layanan Barang
  </a>
</li>";
}

$cek=umenu_akses("?module=prosesBlanko",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=prosesBlanko'>
    Proses Layanan Blanko
  </a>
</li>";
}
?>