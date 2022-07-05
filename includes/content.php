<?php $b = getdate() ?>
<?php
error_reporting(0);
error_reporting('E_NONE');
session_start();
include "config/koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$dtPsedia = mysqli_query($koneksi," SELECT  a.kd_brg, a.ur_brg,
                                            a.kd_kbrg, a.kd_jbrg, 
                                            a.satuan, a.kd_lokasi
                                    FROM c_brgsedia a
                                    ORDER BY a.kd_brg ASC");
$Pesedia = mysqli_num_rows($dtPsedia);

$dtUser = mysqli_query($koneksi," SELECT  a.UNAME, a.NIP, a.PASSWORD, a.LEVEL
                                  FROM a_useraktif a
                                  ORDER BY a.UNAME ASC");
$user = mysqli_num_rows($dtUser);

$unit = mysqli_query($koneksi," SELECT idminta, registrasi, unut, COUNT(registrasi) AS regis 
                                FROM c_unitsediaminta ORDER BY registrasi ASC");
$reg = mysqli_fetch_array($unit);

$keluar = mysqli_query($koneksi," SELECT id, registrasi, COUNT(kd_brg) AS brg_kel 
                                  FROM c_sediakeluarunit 
                                  ORDER BY registrasi ASC");
$out = mysqli_fetch_array($keluar);

if ($_GET['module'] == 'home') {
  echo "
      <!-- Main content -->
      <section class='content'>
        <!-- Small boxes (Stat box) -->
        <div class='row'>
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-aqua'>
              <div class='inner'>
                <h3>$Pesedia</h3>
  
                <p>Persediaan (Jumlah)</p>
              </div>
              <div class='icon'>
                <i class='ion ion-bag'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-green'>
              <div class='inner'>
                <h3>$user</h3>
  
                <p>Pengguna Akun (UNIT) - ADMIN</p>
              </div>
              <div class='icon'>
                <i class='ion ion-stats-bars'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-yellow'>
              <div class='inner'>
                <h3>$reg[regis]</h3>
  
                <p>Pengajuan (UNIT)</p>
              </div>
              <div class='icon'>
                <i class='ion ion-person-add'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-red'>
              <div class='inner'>
                <h3>$out[brg_kel]</h3>
  
                <p>Transaksi Barang Keluar</p>
              </div>
              <div class='icon'>
                <i class='ion ion-pie-graph'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class='row'>

          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class='col-lg-5 connectedSortable'>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          </section>
      </section>
      <!-- /.content -->
      
";
} elseif ($_GET['module'] == 'tbl_brg') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/tabelpsedia.php';
  }
} elseif ($_GET['module'] == 'tbl_stokbrg') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/tabelpsedia_stock.php';
  }
} elseif ($_GET['module'] == 'sedia_pengajuan') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/permohonan/sedia_pengajuan.php';
  }
} elseif ($_GET['module'] == 'c_aksiProsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_aksiunit.php';
  }
}elseif ($_GET['module'] == 'c_spamPsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_spamunit.php';
  }
}elseif ($_GET['module'] == 'c_printsedia') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_cetak.php';
  }
}elseif ($_GET['module'] == 'c_cekstatus') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/aksiunit/sedia_statuscek.php';
  }
}

?>