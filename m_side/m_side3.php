<?php
error_reporting(0);
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=masterAset",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=masterAset'>
  Master Aset
  </a>
</li>";
}

$cek=umenu_akses("?module=tabelDBR",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=tabelDBR'>
  Tabel Barang Ruangan
  </a>
</li>";
}

$cek=umenu_akses("?module=pendaftaranBMN",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=pendaftaranBMN'>
    Pendaftaran (Sensus)
  </a>
</li>";
}

$cek=umenu_akses("?module=dbr",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=dbr'>
   DIR (Invt. Ruangan)
  </a>
</li>";
}

$cek=umenu_akses("?module=mutasiBMN",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=mutasiBMN'>
   Perpindahan (Mutasi)
  </a>
</li>";
}


$cek=umenu_akses("?module=#",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=#'>
   Layanan Pinjam Pakai
  </a>
</li>";
}



?>
