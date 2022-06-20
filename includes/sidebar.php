<?php
$info = mysqli_query(
  $koneksi,
  "SELECT a.NIP, b.pns_nip, b.pns_nama 
          FROM a_useraktif a
          LEFT JOIN m_pegawai b ON b.pns_nip = a.NIP
          ORDER BY id ASC"
);
$rs    = mysqli_fetch_array($info);
?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="dist/img/user2-160x160.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <small><?php echo "$rs[pns_nama]"; ?></small><br>
        <small><?php echo "$_SESSION[NIP]"; ?></small>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>Layanan Umum</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Blanko
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Permohonan Baru</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Proses Permohonan</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Cetak Blanko</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Pencarian</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Kendaraan
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Kendaraan</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Permohonan Baru</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Proses Permohonan</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Cetak Blanko</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Pencarian</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Pinjaman BMN
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Permohonan Baru</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Proses Permohonan</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Cetak Blanko</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Pencarian</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Lapor Kerusakan
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Lapor Baru</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Laporan diProses</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Monitoring Laporan</a></li>
              </ul>
            </li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>