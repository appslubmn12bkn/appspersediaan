<?php
error_reporting(0);
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=r_barang",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_barang'>
    Tabel Barang (PSedia)
  </a>
</li>";
}

$cek=umenu_akses("?module=r_katbarang",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_katbarang'>
    Kategori Barang (PSedia)
  </a>
</li>";
}

$cek=umenu_akses("?module=r_tstokbrg",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_tstokbrg'>
    Stok Barang (PSedia)
  </a>
</li>";
}

$cek=umenu_akses("?module=r_tabelruang",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_tabelruang'>
    Tabel Ruangan
  </a>
</li>";
}

$cek=umenu_akses("?module=r_tabelpegawai",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_tabelpegawai'>
    Tabel Pegawai
  </a>
</li>";
}

$cek=umenu_akses("?module=r_tabelkenddinas",$_SESSION[nip]);
if($cek==1 OR $_SESSION[level]=='admin'){
echo "
<li>
  <a href='?module=r_tabelkenddinas'>
    Tabel Kendaraan Dinas
  </a>
</li>";
}

?>
