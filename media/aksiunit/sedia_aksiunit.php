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
        $aksi = "media/aksi/pengajuan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query($koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC");
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

                    $qry = mysqli_query($koneksi,
                    "SELECT a.registrasi, a.unut, a.prosedur,
                            b.registrasi, b.flag_kirim, b.kd_brg,
                            c.r_idutama, c.r_ruangutama,
                            d.flag, d.ur_flag
                    FROM c_unitsediaminta a
                    LEFT JOIN c_sediakeluarunit b ON b.registrasi = a.registrasi
                    LEFT JOIN r_ruangutama c ON c.r_idutama = a.unut
                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                    WHERE  b.flag_kirim = 'Y'
                    GROUP BY a.registrasi");
                    $head = mysqli_fetch_array($qry);

                    $tabel = mysqli_query($koneksi,
                    "SELECT a.registrasi, a.tglproses, a.satuan,
                            a.flag_kirim, a.kd_brg, a.qtyACC,
                            a.qtyMohon, a.merek_type, a.prosedur,
                            b.registrasi, a.catatanpersetujuan,
                            b.tglmohon, b.prosedur,
                            c.kd_brg, c.ur_brg, c.kd_kbrg, c.kd_jbrg,
                            d.flag, d.ur_flag,
                            e.kd_brg, e.jns_trn
                    FROM c_sediakeluarunit  a
                    LEFT JOIN c_unitsediaminta b ON b.registrasi = a.registrasi
                    LEFT JOIN c_brgsedia c ON c.kd_brg = a.kd_brg
                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                    LEFT JOIN c_sediakeluar e ON e.kd_brg = a.kd_brg
                    WHERE (a.prosedur IN ('6','61')) 
                    AND a.flag_kirim = 'Y'
                    ORDER BY a.registrasi");
?>
                    <section class="content-header">
                      <h1>
                        Cek Penerimaan ATK / ARTK / Bakom (Unit)
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
                                              <div>
                                              NOMOR REGISTRASI : <font color="blue"><strong><?php echo "$head[registrasi]"; ?> - <?php echo "$head[r_ruangutama]"; ?></strong></font>
                                              </div>
                                              <div>
                                              <i class="fa fa-info"></i> INFORMASI : <br><font color="blue"><p>Unit untuk mengecek kesesuaian Barang yang di ajukan dengan keseuaian barang yang diterima oleh unit Umum, dengan tidak membedakan fungsi barangnya,</font><br>
                                              <font color="red"><strong>Exp : Barang sama beda merek, beda warna dianggap Barang yang sesuai.</strong></font>
                                              </div>
                                              <div>
                                              <p><font color="blue">Barang tidak sesuai adalah, ATK/ARTK/BAKOM memiliki bentuk dan kegunaan yang tidak bisa di gunakan,</font>
                                              <font color="red"><strong>Exp : Barang sama tetapi tidak bisa digunakan (Patah, Tinta Macet, dsb).</p></strong></font>
                                              </div>
                                              <div>
                                              <p><font color="blue">Barang cancel/dibatalkan adalah, ATK/ARTK/BAKOM yang dibatalkan pengeluarannya oleh admin karena bisa diperuntukkan yang lebih penting, tidak tampil pada cek Barang Unit</font><br>
                                              <font color="red"><strong>Exp : KARPEG/KARIS/KARSU stok ada, tapi dibatalkan dikarena pejabat ttdnya sudah tidak berlaku sampai pejabat defenitif.</p></strong></font>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <form name='myform' method='post' action='<?php echo"$aksi?module=c_aksiProsedia&act=terimaUnit";?>'>
                                    <input type='hidden' name='registrasi' value='<?php echo"$head[kd_brg]";?>' readonly>
                                        <table class="table table-bordered table-striped mb-none" id="table_4">
                                                  <thead>
                                                  <tr>
                                                      <th bgcolor="#d2d6de">#</th>
                                                      <th bgcolor="#d2d6de">URAIAN BARANG (KODE - NAMA)</th>
                                                      <th bgcolor="#d2d6de">PENGAJUAN</th>
                                                      <th bgcolor="#d2d6de">KELUAR</th>
                                                      <th bgcolor="#d2d6de">MEREK_TYPE</th>
                                                      <th bgcolor="#d2d6de">TRANSAKSI</th>
                                                      <th bgcolor="#d2d6de">PROSEDUR</th>
                                                      <th bgcolor="#d2d6de">DESKRIPSI</th>
                                                      <th bgcolor="#d2d6de">S</th>
                                                      <th bgcolor="#d2d6de">TS</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    <?php
                                                      $no=0;
                                                      while ($x = mysqli_fetch_array($tabel)){
                                                      $no++;
                                                    ?>
                                                    <tr>
                                                      <td><?php echo"$no";?></td>
                                                      <td><?php echo"$x[kd_kbrg] $x[kd_jbrg] - $x[ur_brg]";?></td>
                                                      <td><?php echo"$x[qtyMohon] $x[satuan]";?></td>
                                                      <td><?php echo"$x[qtyACC] $x[satuan]";?></td>
                                                      <td><?php echo"$x[merek_type]";?></td>
                                                      <td><?php echo"$x[jns_trn]";?></td>

                                                      <?php if($x[flag]=='6'){  ?>
                                                      <td align='center'><span class="label bg-green">
                                                      <?php echo"$x[ur_flag]";?></span>
                                                      </td>
                                                      <?php }elseif($x[flag]=='61'){  ?>
                                                      <td align='center'><span class="label bg-blue">
                                                      <?php echo"$x[ur_flag]";?></span></td>
                                                      <?php }elseif($x[flag]=='62'){  ?>
                                                      <td align='center'>
                                                      <span class="label bg-maroon">
                                                      <?php echo"$x[ur_flag]";?></span></td>
                                                      <?php }else{ ?>
                                                      <td align='center'>
                                                      <span class="label bg-red"><?php echo"$x[ur_flag]";?></span>
                                                      </td>
                                                      <?php } ?>

                                                      <td width="240"><?php echo"$x[catatanpersetujuan]";?></td>

                                                      <td align='center' width="50">
                                                      <?php if($x[flag]=='6'){?>  
                                                      <a class='btn bg-green btn-xs' 
                                                      href='<?php echo "$aksi?module=c_aksiProsedia&act=cekBarang&kd_brg=$x[kd_brg]&registrasi=$x[registrasi]"?>'>
                                                      <i class='fa fa-check'></i></a> 
                                                      <?php }elseif($x[flag]=='41'){ ?>
                                                      <b><i class='fa fa-times'></i></b>
                                                      <?php }elseif($x[flag]=='62'){ ?>
                                                      <b>ditukar, harap menunggu!</b>
                                                      <?php }else{ ?>
                                                      <b><i class='fa fa-check'></i></b>  
                                                      <?php } ?>
                                                      </td>

                                                      <td align='center' width="50">
                                                      <?php if($x[flag]=='6'){?>  
                                                      <a class='btn bg-red btn-xs' 
                                                      href='<?php echo "?module=c_aksiProsedia&act=cektdkSesuai&kd_brg=$x[kd_brg]&registrasi=$x[registrasi]"?>'>
                                                      <i class='fa fa-times'></i></a> 
                                                      <?php }elseif($x[flag]=='41'){ ?>
                                                      <b><i class='fa fa-times'></i></b>
                                                      <?php }elseif($x[flag]=='62'){ ?>
                                                      <b><?php echo"$x[alasantidaksesuai]";?></b>
                                                      <?php }else{ ?>
                                                      <b><i class='fa fa-times'></i></b>   
                                                      <?php } ?>
                                                      </td>
                                                    </tr>
                                                    </tfoot>
                            <input type='hidden' name='registrasi' value='<?php echo"$x[registrasi]";?>' readonly>
                            <input type='hidden' name='flag' value='<?php echo"$x[flag]";?>' readonly>
                                                    <?php } ?>
                                                    </table>  
                                  </div>
                                </div>
                                <font color="blue">Keterangan :
                                    <li>S  = SESUAI</li>
                                    <li>TS = TIDAK SESUAI</li>
                                </font>
                            </div>
                            </div>
                                  <?php if($head[flag]=='61'){?>
                                  <button type='submit' class='btn btn btn-sm btn-primary flat'>
                                  <i class='fa fa-check-square'></i> &nbsp;&nbsp; Barang telah Diterima <b><?php echo"$head[ur_unut]";?></b></button>
                                  <?php }elseif($head[flag]=='71'){ ?>
                                  <button type='submit' class='btn btn btn-sm btn-danger flat'>
                                  <i class='fa fa-check-square'></i> &nbsp;&nbsp; Barang <b><?php echo"$head[ur_unut]";?> Belum Lengkap</b></button>

                                  <?php }else{?>
                                  <button type='submit' class='btn btn btn-sm btn-primary flat'>
                                  <i class='fa fa-check-square'></i> &nbsp;&nbsp; Barang Diterima</button>
                                  <?php }?> 
                        </div>
                        </div>
                    </section>

               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "cektdkSesuai":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tampil = mysqli_query($koneksi,"   SELECT  a.registrasi, a.unit, a.unut,
                                                            a.pemohon, a.tglmohon, a.prosedur,
                                                            a.tglkirimunit, a.user, a.idminta,
                                                            b.r_idutama, b.r_ruangutama, 
                                                            b.r_namaruang, c.pns_nip, c.pns_nama,
                                                            d.flag, d.ur_flag
                                                    FROM c_unitsediaminta a
                                                    LEFT JOIN r_ruangutama b ON b.r_idutama = a.unut
                                                    LEFT JOIN m_pegawai c ON c.pns_nip = a.pemohon
                                                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                    WHERE a.registrasi = '$_GET[registrasi]'
                                                    ORDER BY a.idminta AND a.tglmohon ASC");
                    $rs = mysqli_fetch_array($tampil);
                ?>
                    <section class="content-header">
                      <h1>
                        Upload Barang
                        <small>Barang Persediaan masuk dan keluar</small>
                      </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary"> 
                                        <div class="box-header with-border">
                                            <h6 class="box-title"><?php echo "$rs[registrasi]"; ?> - [<?php echo "$rs[r_idutama]"; ?>] <?php echo "$rs[r_ruangutama]"; ?></h6>
                                        </div>

                                      <div class="callout bg-blue color-palette">
                                        <h4>Pemberitahuan</h4>

                                        <p>
                                        Untuk memastikan ATK / ARTK / Bakom yang akan diajukan, pada  <a class="btn btn-danger btn-xs" href="?module=tbl_brg">
                                        tabel barang</a> atau bisa juga di lihat pada menu Master/tbl_brg
                                        </p> 
                                      </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">  
                                                <div class="col-sm-5">
                                                <!-- CARI KODE DULU -->
                                                <form id='sediak_brg' class='form-horizontal' method=post action='' enctype='multipart/form-data'>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-10'>
                                                            <select class="s2 form-control"  name='kd_brg'>
                                                                <option value='BLANK'>PILIH</option>
                                                                <?php
                                                                $dataSql = "SELECT  a.kd_brg, a.ur_brg, a.satuan, a.kd_kbrg, 
                                                                                    a.kd_jbrg,b.kd_brg, b.flag
                                                                            FROM c_brgsedia a
                                                                            LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                                            WHERE b.flag = '2'
                                                                            ORDER BY a.kd_brg ASC";
                                                                $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                                while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                                if ($dataRow['kd_brg'] == $_POST['kd_brg']) {$cek = " selected";
                                                                } else {$cek = "";}
                                                                echo "<option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_brg]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                          </select>
                                                          <small>Tentukan Barang yang akan di ajukan</small>
                                                        </div>
                                                        <button type="submit" class='btn btn-primary btn-md'>
                                                        <i class="fa fa-search"></i>&nbsp;&nbsp; Cari</button>
                                                    </div>
                                                </form>
                                                <!-- END -->
                                                <!-- QUERY CARI KODE DAN STOK -->
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

                                                $a = mysqli_query($koneksi,
                                                            " SELECT a.kd_brg, a.ur_brg, a.satuan, 
                                                                     a.kd_kbrg, a.kd_jbrg,
                                                                     b.kd_brg, b.img, b.merek_type
                                                              FROM   c_brgsedia a
                                                              LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                              WHERE  a.kd_brg='$_POST[kd_brg]'");
                                                $data = mysqli_fetch_array($a);
                                                $dm = mysqli_fetch_array($querymasuk);
                                                $dk = mysqli_fetch_array($querykeluar);
                                                $masuk=$dm['masuk'];
                                                $keluar=$dk['keluar'];
                                                $stokAkhir=$masuk-$keluar  ;
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                                echo "<h4><font color='red'>Data Tidak Ditemukan!</font></h4>";
                                                }else{
                                                  ?>
                                                <!-- END -->
                                                <form class='form-horizontal' method='post' action='<?php echo"$aksi?module=sedia_pengajuan&act=upload&registrasi=$_GET[registrasi]";?>' enctype='multipart/form-data'>
                                                <input type="hidden" name='noreg' value='<?php echo "$rs[registrasi]"; ?>' readonly>
                                                <input type="hidden" name='unut' value='<?php echo "$rs[r_idutama]"; ?>'readonly>
                                                <input type="hidden" name='pic' value='<?php echo "$rs[pemohon]"; ?>' readonly>
                                                <!-- UPLOAD -->
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                    <input type='text' class='form-control' name='kd_brg' value='<?php echo"$data[kd_brg]";?>' readonly>  
                                                    </div>
                                                    <div class="col-sm-9">
                                                    <input type='text' class='form-control' name='ur_brg' value='<?php echo"$data[ur_brg]";?>' readonly>  
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                    <input type='text' class='form-control' name='merek_type' value='<?php echo"$data[merek_type]";?>' readonly>  
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <input type='text' class='form-control' name='satuan' value='<?php echo"$data[satuan]";?>' readonly>  
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-2">
                                                    <input type='text' class='form-control' name='stok' value='<?php echo"$stokAkhir";?>' readonly>  
                                                    <small><strong>Stok</strong> </small>
                                                    </div>
                                                </div>
                                                <?php if($stokAkhir=='0'){?>

                                                <h4><font color="red">Maaf Barang sedang Kosong Atau <br> Tidak ada pengajuan</font></h4>

                                                <?php } else { ?>
                                                <div class="form-group">
                                                    <div class="col-sm-2">
                                                    <input type='text' class='form-control' maxlength="4" name='qtyButuh' value='<?php echo"$_POST[qtyButuh]";?>'> 
                                                    <small><strong>qty Unit</strong> </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                    <input type='text' class='form-control' name='catatan' value='<?php echo"$_POST[catatan]";?>'> 
                                                    <small><strong>Catatan</strong></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRIVIEW IMG</label>
                                                    <div class="col-sm-12">
                                                    <img src='<?php echo"_imgsedia/".$data[img]."";?>' width='70%' height='60%' alt="User Image" class="rounded"/>
                                                    </div>
                                                </div>

                                                <button type='submit' id='btnInsert' class='btn btn-sm bg-green'>
                                                <i class='fa fa-plus'></i> &nbsp;&nbsp; TAMBAHKAN KE TABEL</button>
                                                <?php } ?>                                               
                                                <!-- END -->
                                                </form>
                                                <?php } ?>
                                                </div> 
                                                <div class="col-sm-7">
                                                  <?php
                                                  $qry = mysqli_query($koneksi,
                                                  " SELECT  a.registrasi, a.kd_brg, a.qtyMohon, 
                                                            a.catatan, a.qtyACC, 
                                                            a.merek_type, a.flag_kirim,
                                                            b.registrasi, b.unit, b.unut, 
                                                            b.pemohon, b.idminta,
                                                            b.tglmohon, b.qtypesanan, b.prosedur,
                                                            c.kd_brg, c.ur_brg, c.satuan
                                                    FROM c_sediakeluarunit a
                                                    LEFT JOIN c_unitsediaminta b ON b.registrasi = a.registrasi
                                                    LEFT JOIN c_brgsedia c ON c.kd_brg = a.kd_brg
                                                    WHERE a.registrasi='$_GET[registrasi]' AND a.flag_kirim = 'N'
                                                    ORDER BY b.idminta ASC");
                                                ?>
                                                    <div class="form-group">
                                                    <form name='myform' method='post' action='<?php echo"$aksi?module=sedia_pengajuan&act=kirimPermohonan";?>'>
                                                  <input type='hidden' class='form-control' name='registrasi' placeholder='Nomor Pengajuan' maxlength='4' value='<?php echo"$r[registrasi]";?>' readonly>

                                                  <table id="table_4" class="table table-bordered table-striped responsive">
                                                  <thead>
                                                    <tr>
                                                        <th bgcolor="#d2d6de"><input class='minimal' type="checkbox" onchange="checkAll(this)">&nbsp;&nbsp;&nbsp;PILIH</th>
                                                        <th bgcolor="#d2d6de">URAIAN (KODE - UR BARANG)</th>
                                                        <th bgcolor="#d2d6de">SAT.</th>
                                                        <th bgcolor="#d2d6de">MEREK_TYPE</th>
                                                        <th bgcolor="#d2d6de">QTY</th>
                                                        <th bgcolor="#d2d6de">HAPUS</th>
                                                    </tr>
                                                    </thead>
                                                        <tbody>
                                                  <?php
                                                  $i = 0;
                                                  while($o = mysqli_fetch_array($qry)){
                                                  ?>
                                                    <tr>
                                                        <td>
                                                        <div class='border-checkbox-group border-checkbox-group-primary'>
                                                        <input class='minimal' type='checkbox' name='registrasi<?php echo"$i";?>' value='<?php echo"$o[registrasi]";?>' />
                                                        </div>
                                                        </td>
                                                        <td><?php echo"$o[kd_brg] - $o[ur_brg]";?></td>
                                                        <td><?php echo"$o[satuan]";?></td>
                                                        <td><?php echo"$o[merek_type]";?></td>
                                                        <td><?php echo"$o[qtyMohon]";?></td>
                                                        <td><a class='btn btn-danger btn-sm' href='<?php echo "$aksi?module=sedia_pengajuan&act=hapus&kd_brg=$o[kd_brg]&registrasi=$o[registrasi]"?>' onClick="return confirm('Anda yakin ingin menghapus ?<?php echo $o['ur_brg'];?>?');"><i class='fa fa-trash'></i></a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                  <?php $i++;  } ?>
                                                  </table>
                                                  <input type='hidden' name='n' value='<?php echo"$i";?>'/>
                                                  <button type='submit' id='btnKirim' class='btn btn-sm bg-red'>
                                                  <i class='fa fa-send'></i> &nbsp;&nbsp; KIRIM PENGAJUAN</button>
                                                  </div>
                                                  <!-- /.box-body -->
                                                  </form>

                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div> 
                                </div>
                            </div>
                        </div>
                          <a href='<?php echo"?module=sedia_pengajuan";?>'>
                          <button class="btn btn-default btn-sm" type="button"> 
                          <i class="fa fa-arrow-left "> </i>&nbsp;&nbsp;&nbsp;&nbsp;Kembali</button>
                          </a>
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
  function checkAll(box) 
  {
   let checkboxes = document.getElementsByTagName('input');

   if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = true;
     }
    }
   } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = false;
     }
    }
   }
  }
 </script>
