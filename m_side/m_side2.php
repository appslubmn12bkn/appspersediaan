<?php
error_reporting(0);
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=layananBarang",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=layananBarang'>
  Kebutuhan ATK dan ARTK
  </a>
</li>";
}

$cek=umenu_akses("?module=blankoKepeg",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=blankoKepeg'>
    Blanko Kepegawaian
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
  Penggunaan Kend. Dinas
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    Pinjam Pakai BMN
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    Pinjam Pakai Ruangan
  </a>
</li>";
}

$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
    Lapor Kerusakan BMN
  </a>
</li>";
}

?>
