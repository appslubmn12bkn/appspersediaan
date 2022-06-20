<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
include('../../config/fungsi_indotgl.php');
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
      			<center>
      			Modul Tidak Bisa Di Akses,
      			Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
    $cek = user_akses($_GET['module'], $_SESSION['NIP']);
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
        $aksi = "media/aksi/layananumum.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>
                        Tabel Persediaan - Gudang Kanreg 12
                        <small>Barang Persediaan masuk dan keluar</small>
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                          <form method='post' class='form-horizontal' action='' enctype='multipart/form-data'>
                                              <div class="form-group">
                                                  <div class="col-sm-5">
                                                    <label class="control-label">CARI KODE BARANG</label>
                                                      <select class="s2 form-control"  name='kd_brg' onchange="this.form.submit();">
                                                          <option value='BLANK'>PILIH</option>
                                                          <?php
                                                          $dataSql = "SELECT a.kd_brg, a.ur_brg, a.satuan, a.kd_kbrg, a.kd_jbrg,
                                                                             b.kd_brg, b.flag
                                                                      FROM c_brgsedia a
                                                                      LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                                      WHERE b.flag = '2'
                                                                      ORDER BY a.kd_brg ASC";
                                                          $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                          while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                              if ($dataRow['kd_brg'] == $_POST['kd_brg']) {
                                                                  $cek = " selected";
                                                              } else {
                                                                  $cek = "";
                                                              }
                                                              echo "
                                                              <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_brg]</option>";
                                                          }
                                                          $sqlData = "";
                                                          ?>
                                                      </select>
                                                      <small>Nama Barang</small>
                                                  </div>
                                              </div>
                                          </form>
                                          <?php

                                            $a = mysqli_query($koneksi,
                                                " SELECT a.kd_brg, a.ur_brg, a.satuan, 
                                                         a.kd_kbrg, a.kd_jbrg,
                                                         b.kd_brg, b.img, b.merek_type
                                                  FROM   c_brgsedia a
                                                  LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                  WHERE  a.kd_brg='$_POST[kd_brg]'");
                                                  $data = mysqli_fetch_array($a);
                                                  $cekdata = mysqli_num_rows($a);
                                                  if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                                  echo "
                                                  <font color='red'>
                                                  <h2>Kode Barang $a[kd_brg] $a[ur_brg] Tidak Ditemukan</h2>
                                                  </font>
                                                  ";
                                                        }else{
                                              ?>
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> KELOMPOK BARANG</th>
                                                    <th bgcolor='#dcdcdc'> JENIS BARANG</th>
                                                    <th bgcolor='#dcdcdc'> KODE BARANG</th>
                                                    <th bgcolor='#dcdcdc'> URAIAN BARANG</th>
                                                    <th bgcolor='#dcdcdc'> SATUAN</th>
                                                    <th bgcolor='#dcdcdc'> STOK GUDANG</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            $querymasuk = mysqli_query($koneksi,
                                                      " SELECT a.kd_brg, a.ur_brg, a.satuan,
                                                              b.kd_brg, SUM(b.kuantitas) AS masuk
                                                        FROM   c_brgsedia a
                                                        LEFT JOIN c_sediamasuk b ON b.kd_brg=a.kd_brg
                                                        WHERE  b.kd_brg='$_POST[kd_brg]'");
                                            
                                            $querykeluar = mysqli_query($koneksi,
                                                      " SELECT a.kd_brg, a.ur_brg, a.satuan,
                                                               c.kd_brg, SUM(c.kuantitas) AS keluar
                                                        FROM   c_brgsedia a
                                                        LEFT JOIN c_sediakeluar c ON c.kd_brg=a.kd_brg
                                                        WHERE  c.kd_brg='$_POST[kd_brg]'");
                                            $dm = mysqli_fetch_array($querymasuk);
                                            $dk = mysqli_fetch_array($querykeluar);
                                            $masuk=$dm['masuk'];
                                            $keluar=$dk['keluar'];
                                            $SAkr=$masuk-$keluar  ;
                                                ?>
                                                <tr>
                                                    <td><?php echo "$data[kd_kbrg]"; ?></td>
                                                    <td><?php echo "$data[kd_jbrg]"; ?></td>
                                                    <td><?php echo "$data[kd_brg]"; ?></td>
                                                    <td><?php echo "$data[ur_brg]"; ?></td>
                                                    <td><?php echo "$data[satuan]"; ?></td>
                                                    <td align="center"><strong><?php echo "$SAkr"; ?></strong></td>
                                                </tr>
                                                </tfoot>
                                                <?php } ?>
                                        </table>    
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </section>

               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "uploadImg":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $tampil = mysqli_query(
                            $koneksi,
                            "SELECT a.kd_brg, a.ur_brg,
                                    a.kd_kbrg, a.kd_jbrg, 
                                    a.satuan, a.kd_lokasi,
                                    b.kd_brg, b.img, b.flag
                            FROM c_brgsedia a 
                            LEFT JOIN c_imgbrgsedia b ON b.kd_brg=a.kd_brg
                            WHERE a.kd_brg = '$_GET[kd_brg]'
                            ORDER BY a.kd_brg ASC");
                        $r  = mysqli_fetch_array($tampil);
                    ?>
    
                        <section class="content">
                            <div class="box">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=tbl_brg&act=uploadImage"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">KELOMPOK BARANG</label>
                                                        <input type="text" class="form-control" name='kd_kbrg' value='<?php echo "$r[kd_kbrg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">JENIS BARANG</label>
                                                        <input type="text" class="form-control" name='kd_jbrg' value='<?php echo "$r[kd_jbrg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">KODE BARANG</label>
                                                        <input type="text" class="form-control" name='kd_brg' value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">URAIAN BARANG</label>
                                                        <input type="text" class="form-control" name='ur_brg' value='<?php echo "$r[ur_brg]"; ?>' readonly>
                                                    </div>
                                                </div>
    
                                        </div>
    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>UPLOAD IMAGE</label>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input type="file" name='img' class="form-control-file" id="uploadImage" onchange="PreviewImage();">
                                                        <small> Upload Image max : 1 Mb </small>
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label>Preview Image</label><br>
                                                        <img id="uploadPreview" style="width: 350px; height: 350px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button name="upload" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp; UPLOAD GAMBAR</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </section>
    
                    <?php
                    } else {
                        echo "Anda tidak berhak mengakses halaman ini.";
                    }
                    break;

                case "tambah":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                $tanggalharini	= date("Ydm");
                $data			= mysqli_fetch_array(mysqli_query($koneksi, "SELECT MAX(t_notickets) AS akhir FROM t_layananumum WHERE t_notickets LIKE
                                  '$tanggalharini%'"));
                $lastkdaju		= $data['akhir'];
                $lastNoUrut		= substr($lastkdaju,9,5);
                $nextNoUrut		= $lastNoUrut+1;
                $nextNoTransaksi= $tanggalharini.sprintf('%03s', $nextNoUrut);
                ?>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary"> 
                                    <div class="box-header with-border">
                                        <h6 class="box-title">Ticket Permohonan</h6>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">  
                                            <div>
                                                <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=t_mohon&act=simpanlayanan";?>' enctype='multipart/form-data'>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">No Ticket</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name='tiket' id="tiket" value='<?php echo "$nextNoTransaksi"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    <label for="Unit Utama" class="col-sm-2 control-label">Unit Utama</label>

                                                    <div class="col-sm-6">
                                                        <select class="s2 form-control" style="width: 100%; height:36px;" name='unut'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT r_idutama, r_ruangutama, r_namaruang
                                                                        FROM r_ruangutama 
                                                                        WHERE (r_idutama IN (2,3,4,5,6))
                                                                        ORDER BY r_idutama ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['r_idutama'] == $_POST['unut']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[r_idutama]' $cek>$dataRow[r_ruangutama]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Unit Kerja</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name='unik' value='<?php echo "$_POST[unik]"; ?>'>
                                                            <small>Apabila tidak ada unit kerja, <b><font color='red'> tulis - / tulis unit utamanya</font></b></small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="Unit Utama" class="col-sm-2 control-label">Jenis Layanan</label>

                                                    <div class="col-sm-3">
                                                        <select class="s2 form-control" id='jnslayanan' name='jnslayanan'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM t_jnslayanan ORDER BY idjnslayanan ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['idjnslayanan'] == $_POST['jnslayanan']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[idjnslayanan]' $cek>[$dataRow[t_jnslayanan]] - $dataRow[t_layanannama]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>
                                                    </div>
                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                    <a href='?module=t_mohon&act=tambah'>
                                                        <button class="btn btn-default btn-sm" type="button">
                                                        <i class="fa fa-refresh"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Cancel</button>
                                                    </a>
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan Permohonan Layanan</button>
                                                </div>
                                                <!-- /.box-footer -->
                                                </div>
                                                </form>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        </div>
                    </section>
                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "layananbaru":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tampil = mysqli_query($koneksi,
                        "SELECT a.t_notickets, a.t_unut, a.t_prosedur,
                                a.t_jnslayanan, a.t_pictransaksi, a.t_unit,
                                b.r_idutama, b.r_ruangutama,
                                d.p_prosedur, d.p_pronama,
                                e.idjnslayanan, e.t_jnslayanan, e.t_layanannama
                        FROM t_layananumum a 
                        LEFT JOIN r_ruangutama b ON b.r_idutama = a.t_unut
                        LEFT JOIN p_prosedur d ON d.p_prosedur = a.t_prosedur
                        LEFT JOIN t_jnslayanan e ON e.idjnslayanan = a.t_jnslayanan
                        WHERE a.t_unut = $_GET[unut] 
                        AND a.t_notickets = $_GET[tiket]
                        ORDER BY a.t_notickets ASC ");
                    $r  = mysqli_fetch_array($tampil);
                ?>

                    <section class="content">
                        <div class="row">
                            <?php if($_GET['jnslayanan']=='1'){?>
                            <!-- KENDARAAN DINAS <br> --> 
                            <div class="col-md-4">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Info Permohonan</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=t_mohon&act=layananBaru"; ?>' enctype='multipart/form-data'>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <h3><span class="label label-primary"><?php echo"$r[t_notickets]"; ?></span></h3>
                                                        <input type="hidden" class="form-control" name='tiket' value='<?php echo "$r[t_notickets]"; ?>' readonly>
                                                        <small>Nomor Tiket</small>    
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <h3><span class="label label-success"><?php echo"$r[p_pronama]"; ?></span></h3>
                                                        <small>Jenis Prosedure</small>    
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                           <input type="text" class="form-control" name='jnslayanan' value='<?php echo "$r[idjnslayanan]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name='nmlayanan' value='<?php echo "$r[t_layanannama]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" name='unut' value='<?php echo "$r[r_idutama]"; ?>' readonly>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name='nmunut' value='<?php echo "$r[r_ruangutama]"; ?>' readonly>
                                                            </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name='unit_kerja' value='<?php echo "$r[t_unit]"; ?>' readonly>
                                                            <small>Unit Kerja</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name='pic' value='<?php echo "$r[t_pictransaksi]"; ?>' readonly>
                                                            <small>PIC Unit</small>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Form Permohonan</h6>
                                    </div><div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Lokasi (Loc)</label>
                                                        <div class="col-sm-8">
                                                        <select class="s2 form-control" name='dbalamat'>
                                                            <option value='BLANK'>PILIH LOC</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM t_dbalamat ORDER BY t_kode ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['t_kode'] == $_POST['dbalamat']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[t_kode]' $cek>[$dataRow[t_kode]] - $dataRow[t_naminst]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                            <small>Tentukan Locasi Tujuan, <font color='blue'>Klik  
                                                            <button type="button" class="btn bg-blue btn-default btn-xs" data-toggle="modal" data-target="#modal-default">
                                                                <i class="fa fa-plus"></i>&nbsp;&nbsp;baru
                                                            </button></font> Apabila Belum ada</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Tanggal Pemesanan</label>

                                                        <div class="col-sm-2">
                                                            <div class="input-group">
                                                            <input type="text" class="form-control datepicker" name='tglpesan' value='<?php echo "$_POST[tglpesan]"; ?>'>
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                                </div> 
                                                            </div>                                                          
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Tanggal Berangkat</label>

                                                        <div class="col-sm-2">
                                                            <div class="input-group">
                                                            <input type="text" class="form-control datepicker" name='tglberangkat' value='<?php echo "$_POST[tglberangkat]"; ?>'>
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                                </div> 
                                                            </div>                                                      
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Waktu Berangkat</label>

                                                        <div class="col-sm-2">
                                                            <div class="input-group">
                                                            <input type="text" class="form-control timepicker" name='jampesan' value='<?php echo "$_POST[jampesan]"; ?>'>
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-clock-o"></i>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <b>WIB</b>
                                                    </div>

                                                    <div class="form-group row">
                                                    <label class="col-sm-2 control-label">No HP / WA PIC</label>

                                                        <div class="col-sm-3">
                                                            <input type="text" maxlength="12" class="form-control" name='wapic' value='<?php echo "$_POST[wapic]"; ?>'>                                                      
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn bg-navy btn-sm pull-left"><i class="fa fa-check"> </i>&nbsp;&nbsp;Pesan Kendaraan</button>
                                                        <a class='btn bg-maroon btn-sm pull-left' href=<?php echo "?module=t_mohon"; ?>><i class='fa fa-arrow-left'></i> &nbsp;&nbsp;Kembali</a>
                                                    </div> 
                                                    </div> 
                                                </form> 
                                                <div class="modal fade" id="modal-default">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content modal-lg">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Tambah Alamat Baru</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=t_mohon&act=alamatBaru&tiket=$r[t_notickets]&jnslayanan=$r[idjnslayanan]&unut=$r[t_unut]"; ?>' enctype='multipart/form-data'>
                                                                <?php
                                                                $query = mysqli_query($koneksi, "SELECT max(t_kode) as kodeTerbesar FROM t_dbalamat");
                                                                $data = mysqli_fetch_array($query);
                                                                $kode = $data['kodeTerbesar'];
                                                                
                                                                // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
                                                                // dan diubah ke integer dengan (int)
                                                                $urutan = (int) substr($kode, 3, 3);
                                                                
                                                                // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                                                                $urutan++;
                                                                
                                                                // membentuk kode barang baru
                                                                // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
                                                                // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
                                                                // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
                                                                $huruf = "LOC";
                                                                $loc = $huruf . sprintf("%03s", $urutan);
                                                                ?>    
                                                                    <div class="form-group row">
                                                                    <label class="col-sm-2 control-label"></label>

                                                                        <div class="col-sm-2">
                                                                            <h1><label class="label label-primary label-lg"><?php echo "$loc"; ?></label></h1>
                                                                            <input type="hidden" class="form-control" name='kdalamat' value='<?php echo "$loc"; ?>'>
                                                                        </div>
                                                                    </div>                                                                     
                                                                    
                                                                    <div class="form-group row">
                                                                    <label class="col-sm-2 control-label">Instansi</label>

                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control" name='inst' value='<?php echo "$_POST[inst]"; ?>'>
                                                                            <small>Tulis Nama Istansi (Pemerintah) atau Perusahaan, Exp : BKD ...., BRI dll</small>
                                                                        </div>
                                                                    </div>  

                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 control-label">Alamat</label>
                                                                        <div class="col-sm-9">
                                                                            <textarea type="text" rows="3" class="form-control" name='alamat'><?php echo "$_POST[alamat]"; ?></textarea>
                                                                            <small>Tulis alamat lengkap 255 Char</small>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 control-label">Kode Pos</label>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" maxlength="5" class="form-control" name='kdpos' value='<?php echo "$_POST[kdpos]"; ?>'>
                                                                            <small>Kode Pos</small>
                                                                        </div>
                                                                    </div> 
                                                                            </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal"><i class='fa fa-times'></i>&nbsp;&nbsp;Tutup</button>
                                                                                    <button type="submit" class="btn bg-blue btn-sm pull-left"><i class='fa fa-check'></i>&nbsp;&nbsp;Simpan Alamat Baru</button>
                                                                                </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END KENDARAAN DINAS <br> --> 
                            <!-- PINJAMAN  RUANGAN <br> --> 
                            <?php }elseif($_GET['jnslayanan']=='2'){?>
                                PINJAMAN RUANGAN
                                <?php echo"$r[t_pictransaksi] <br> $r[r_ruangutama] <br> $r[t_notickets]"; ?>
                            <!-- END PINJAMAN  RUANGAN <br> -->    
                            <!-- LAPORAN KERUSAKAN <br> --> 
                            <?php }elseif($_GET['jnslayanan']=='3'){?>
                                <div class="col-md-4">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Info Permohonan</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method='post' class='form-horizontal' action='' enctype='multipart/form-data'>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <h3><span class="label label-primary"><?php echo"$r[t_notickets]"; ?></span></h3>
                                                        <input type="hidden" class="form-control" name='tiket' value='<?php echo "$r[t_notickets]"; ?>' readonly>
                                                        <small>Nomor Tiket</small>    
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <h3><span class="label label-success"><?php echo"$r[p_pronama]"; ?></span></h3>
                                                        <small>Jenis Prosedure</small>    
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                           <input type="text" class="form-control" name='jnslayanan' value='<?php echo "$r[idjnslayanan]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name='nmlayanan' value='<?php echo "$r[t_layanannama]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" name='unut' value='<?php echo "$r[r_idutama]"; ?>' readonly>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name='nmunut' value='<?php echo "$r[r_ruangutama]"; ?>' readonly>
                                                            </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name='unit_kerja' value='<?php echo "$r[t_unit]"; ?>' readonly>
                                                            <small>Unit Kerja</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name='pic' value='<?php echo "$r[t_pictransaksi]"; ?>' readonly>
                                                            <small>PIC Unit</small>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Form Permohonan</h6>
                                    </div><div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                            <form method='post' class='form-horizontal' action='' enctype='multipart/form-data'>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select class="select2 form-control" style="width: 100%" name='cari' onchange="this.form.submit();">
                                                        <option value='BLANK'>PILIH</option>
                                                        <?php
                                                        $dataSql = "SELECT * FROM b_nmbmn ORDER BY nourut ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kd_brg'] == $_POST['cari']) {
                                                                $cek = " selected";
                                                            } else {
                                                                $cek = "";
                                                            }
                                                            echo "
                                                            <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_sskel]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                    <small> Pilih Kode Barang : 31001xxx </small>
                                                </div>
                                            </div>
                                            </form>
                                            
                                            <?php
                                            $brg = mysqli_query(
                                                $koneksi,
                                                " SELECT 	a.kd_brg, a.ur_sskel, a.satuan
                                                FROM b_nmbmn a
                                                WHERE kd_brg = '$_POST[cari]'
                                                ORDER BY nourut ASC"
                                            );
                                            $a = mysqli_fetch_array($brg);
                                            $ceka = mysqli_num_rows($brg);
                                            if (isset($_POST['cari']) && $ceka == 0) {
                                                echo "
                                                    <div class='alert bg-danger alert-danger text-white' role='alert'>
                                                    <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                                    Coba Lagi
                                                    </div>";
                                            } else {
                                            ?>

                                            <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=t_mohon&act=simpanRusak"; ?> enctype='multipart/form-data'>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$a[kd_brg]"; ?>' readonly>
                                                        <small> Kode Barang </small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$a[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$a[satuan]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name='tglSensus' id="tglSensus" value='<?php echo date("Y-m-d"); ?>' readonly>
                                                        <small> Tanggal Lapor </small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-1">
                                                        <label>Qty BMN</label>
                                                        <input type="text" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' maxlength="3" onkeyup=sum2();>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <label class="control-label">No Aset</label>
                                                        <input type="text" name='nupAW' id="nupAW" class="form-control form-control-danger" placeholder="Awal" value='<?php echo "$_POST[nupAW]"; ?>' maxlength="4" onkeyup=sum2();>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <label class="control-label">No Aset</label>
                                                        <input type="text" name='nupAK' id="nupAK" class="form-control form-control-danger" placeholder="Akhir" value='<?php echo "$_POST[nupAK]"; ?>' maxlength="4" readonly>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <label class="control-label">Unit</label>
                                                        <select class="select2 form-control" style="width: 100%; height:36px;" name='unut'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM r_ruangutama ORDER BY r_idutama ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                if ($dataRow['r_idutama'] == $_POST['unut']) {
                                                                    $cek = " selected";
                                                                } else {
                                                                    $cek = "";
                                                                }
                                                                echo "
                                                            <option value='$dataRow[r_idutama]' $cek>$dataRow[r_ruangutama]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                        <small> Pilih Nama Unit </small>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="control-label">P I C</label>
                                                        <select class="select2 form-control" style="width: 100%; height:36px;" name='pic'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM m_pegawai ORDER BY idpegawai ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                if ($dataRow['pns_nip'] == $_POST['pic']) {
                                                                    $cek = " selected";
                                                                } else {
                                                                    $cek = "";
                                                                }
                                                                echo "
                                                            <option value='$dataRow[pns_nip]' $cek>$dataRow[pns_nip]|$dataRow[pns_nama]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                        <small> Pilih NIP : 1900xxxx </small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success waves-effect text-left"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Simpan</button>
                                                </div>

                                            </form>
                                        <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }elseif($_GET['jnslayanan']=='4'){?>
                                PEMINJAMAN BMN
                                <?php echo"$r[t_pictransaksi] <br> $r[r_ruangutama] <br> $r[t_notickets]"; ?>
                            <?php }elseif($_GET['jnslayanan']=='5'){?>
                                PERMINTAAN BLANKO
                                <?php echo"$r[t_pictransaksi] <br> $r[r_ruangutama] <br> $r[t_notickets]"; ?>
                            <?php }else { ?>

                                TIDAK ADA LAYANAN YANG DIPILIH

                            <?php } ?>

                            
                        </div>
                    </section>
                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                ?>
<?php
        }
    }
}
?>

<script type="text/javascript">
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
</script>