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

$dtSensus = mysqli_query($koneksi," SELECT  a.b_kdbrg, a.b_noaset,
                                            b.b_kdbrgkond, b.b_noasetkond, 
                                            b.b_kondisi, b.b_tglperubahan
                                    FROM b_sensus a
                                    LEFT JOIN b_sensuskondisi b ON b.b_kdbrgkond = a.b_kdbrg AND b.b_noasetkond = a.b_noaset
                                    WHERE b_kondisi = '3'
                                    ORDER BY a.b_kdbrg and a.b_noaset ASC");
$kondRB = mysqli_num_rows($dtSensus);

$bmnsatker = mysqli_query($koneksi," SELECT  * FROM b_bmnsatker ORDER BY kd_brg and no_aset ASC");
$bmni = mysqli_num_rows($bmnsatker);

$penghentian = mysqli_query($koneksi," SELECT  * FROM b_masteraset WHERE jns_trn ='401' ORDER BY kd_brg and no_aset ASC");
$henti = mysqli_num_rows($penghentian);

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
                <h3>$kondRB</h3>
  
                <p>Rusak Berat</p>
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
                <h3>$Sensus</h3>
  
                <p>Sensus BMN</p>
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
                <h3>$henti</h3>
  
                <p>BMN yang sudah dihentikan (Hapus)</p>
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
}

?>