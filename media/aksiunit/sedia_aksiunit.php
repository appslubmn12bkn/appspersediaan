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
                                  <div class="box box-solid">
                                      <div class="box-body">
                                          <div class="row">
                                            <div class="col-md-12">
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
                                              <p><font color="blue">Barang yang sesuai akan terupdate dan otomatis hilang dari tabel dan barang yang tidak sesuai akan tetap ada sampai admin memproses data yang baru</font><br>
                                              </font>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  <strong>NOMOR REGISTRASI : </strong>
                                                <form method='post' class='form-horizontal' action=''>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-4'>
                                                            <select class="s2 form-control" style="width: 100%" name='registrasi'>
                                                                <option value=''></option>
                                                                <?php
                                                                $dataSql = "SELECT  a.registrasi, a.unut, 
                                                                                    a.unit, a.prosedur,
                                                                                    b.r_idutama, b.r_ruangutama
                                                                            FROM c_unitsediaminta a 
                                                                            LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
                                                                            WHERE prosedur = '6'
                                                                            ORDER BY a.registrasi ASC";
                                                                $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                                while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                    if ($dataRow['registrasi'] == $_POST['registrasi']) {
                                                                        $cek = " selected";
                                                                    } else {
                                                                        $cek = "";
                                                                    }
                                                                    echo "
                                                                <option value='$dataRow[registrasi]' $cek>$dataRow[registrasi]  -  $dataRow[r_ruangutama]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                            </select>
                                                            <small> Pilih Registrasi </small>
                                                        </div>
                                                    <button type='submit' name='preview' class='btn btn-md btn-primary flat'>
                                                        <i class='fa fa-search'></i>&nbsp;&nbsp; view</button>
                                                    </div>
                                                </form>                                        
                                                <?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.registrasi, a.unut, 
                                                        a.unit,
                                                        b.r_idutama, b.r_ruangutama                          
                                                FROM c_unitsediaminta a 
                                                LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
                                                WHERE  a.registrasi ='$_POST[registrasi]'
                                                ORDER BY a.registrasi ASC"
                                        );
                                        $data = mysqli_fetch_array($a);
                                        $cekdata = mysqli_num_rows($a);
                                        if (isset($_POST['registrasi']) && $cekdata == 0) {
                                            echo "
                                            <Font color='red'> <h3>DATA TIDAK DITEMUKAN!</h3></font>";
                                        } else {
                                        ?>
                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <form name='myform' method='post' action='<?php echo"$aksi?module=c_aksiProsedia&act=terimaUnit";?>'>
                                    <input type='hidden' name='registrasi' value='<?php echo"$head[registrasi]";?>' readonly>
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
                                                      <?php if($head[flag]=='71'){?>
                                                      <th bgcolor="#d2d6de" width="120">DESKRIPSI ADMIN</th>
                                                      <?php }else{ ?>
                                                      <th bgcolor="#d2d6de">TS</th>
                                                      <?php } ?>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    <?php
                                                    $tabel = mysqli_query($koneksi,
                                                    "SELECT a.registrasi, a.tglproses, a.satuan,
                                                            a.flag_kirim, a.kd_brg, a.qtyACC, a.tanggaltl,
                                                            a.qtyMohon, a.merek_type, a.prosedur,
                                                            b.registrasi, a.catatanpersetujuan, a.catatanklaim,
                                                            b.tglmohon, b.prosedur,
                                                            c.kd_brg, c.ur_brg, c.kd_kbrg, c.kd_jbrg,
                                                            d.flag, d.ur_flag,
                                                            e.kd_brg, e.jns_trn
                                                    FROM c_sediakeluarunit  a
                                                    LEFT JOIN c_unitsediaminta b ON b.registrasi = a.registrasi
                                                    LEFT JOIN c_brgsedia c ON c.kd_brg = a.kd_brg
                                                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                    LEFT JOIN c_sediakeluar e ON e.kd_brg = a.kd_brg
                                                    WHERE a.registrasi = '$_POST[registrasi]' 
                                                    AND (a.prosedur IN ('6','63','64','71')) 
                                                    AND a.flag_kirim = 'Y'
                                                    ORDER BY a.registrasi ASC");

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

                                                      <?php }elseif($x[flag]=='64'){  ?>
                                                      <td align='center'>
                                                      <span class="label bg-green">
                                                      <?php echo"$x[ur_flag]";?></span></td>

                                                      <?php }else{ ?>
                                                      <td align='center'>
                                                      <span class="label bg-red"><?php echo"$x[ur_flag]";?></span>
                                                      </td>
                                                      <?php } ?>

                                                      <?php if($x[flag]=='6'){?>
                                                      <td width="240"><?php echo"$x[catatanpersetujuan]";?>
                                                      </td>
                                                      <?php }elseif($x[flag]=='64'){ ?>
                                                      <td width="240"><?php echo"$x[catatanklaim]";?>
                                                      </td>
                                                      <?php }else{ ?>
                                                      <td width="240"><?php echo"$x[catatanpersetujuan]";?>
                                                      </td>
                                                      <?php } ?>



                                                      <td align='center' width="50">
                                                      <?php if($x[flag]=='6'){?>  
                                                      <a class='btn bg-green btn-xs' 
                                                      href='<?php echo "$aksi?module=c_aksiProsedia&act=cekBarang&kd_brg=$x[kd_brg]&registrasi=$x[registrasi]"?>'>
                                                      <i class='fa fa-check'></i></a> 
                                                      <?php }elseif($x[flag]=='41'){ ?>
                                                      <b><i class='fa fa-times'></i></b>
                                                      <?php }elseif($x[flag]=='64'){ ?>
                                                      <a class='btn bg-maroon btn-xs' 
                                                      href='<?php echo "$aksi?module=c_aksiProsedia&act=tlAdmin&kd_brg=$x[kd_brg]&registrasi=$x[registrasi]"?>'>
                                                      <i class='fa fa-check'></i></a>
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
                                                      <?php }elseif($x[flag]=='63'){ ?>
                                                      <b>BELUM TINDAK LANJUT : <?php echo indotgl($x[tanggaltl]);?></b> 
                                                      <?php }else{ ?>
                                                      <b>TINDAK LANJUT SELESAI : <?php echo indotgl($x[tanggaltl]);?></b>   
                                                      <?php } ?>
                                                      </td>
                                                    </tr>
                                                    </tfoot>
                                                    <?php } ?>
                                                    </table>  
                                  </div>
                                </div>
                                <font color="blue">Keterangan :
                                    <li>S  = SESUAI</li>
                                    <li>TS = TIDAK SESUAI</li>
                                    <li>DESKRIPSI ADMIN = PENYELESAIAN TINDAK LANJUT</li>
                                </font>
                                <?php } ?> 
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

                case "cektdkSesuai":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tampil = mysqli_query($koneksi,"   SELECT  a.registrasi, a.unit, a.unut,
                                                                a.pemohon, a.idminta,
                                                                b.r_idutama, b.r_ruangutama, 
                                                                b.r_namaruang, 
                                                                c.pns_nip, c.pns_nama,
                                                                d.flag, d.ur_flag
                                                    FROM c_unitsediaminta a
                                                    LEFT JOIN r_ruangutama b ON b.r_idutama = a.unut
                                                    LEFT JOIN m_pegawai c ON c.pns_nip = a.pemohon
                                                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                    WHERE a.registrasi = '$_GET[registrasi]'
                                                    ORDER BY a.idminta AND a.tglmohon ASC");
                    $rs = mysqli_fetch_array($tampil);

                    $klaim = mysqli_query($koneksi,
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
                    WHERE a.registrasi = '$_GET[registrasi]' 
                    AND a.kd_brg = '$_GET[kd_brg]'
                    AND (a.prosedur IN ('6')) 
                    AND a.flag_kirim = 'Y'
                    ORDER BY a.registrasi ASC");
                    $kl = mysqli_fetch_array($klaim);
                ?>
                    <section class="content-header">
                      <h1>
                        Klaim Atas ATK/ARTK/Bakom yang diterima (UNIT)
                        <small>Barang Persediaan masuk dan keluar</small>
                      </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-primary"> 
                                        <div class="box-header with-border">
                                            <h6 class="box-title"><?php echo "$rs[registrasi]"; ?> - [<?php echo "$rs[r_idutama]"; ?>] <?php echo "$rs[r_ruangutama]"; ?></h6>
                                        </div>

                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">  

                                                    <!-- FORM KLAIM -->
                                                    <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=c_aksiProsedia&act=simpanKlaim"; ?>' enctype='multipart/form-data'>

                                                    <div class="form-group">
                                                        <div class="col-sm-3">
                                                            <label class="control-label">KLP BARANG</label>
                                                            <input type="text" class="form-control" name='kd_kbrg' value='<?php echo "$kl[kd_kbrg]"; ?>' readonly>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <label class="control-label">JNS BARANG</label>
                                                            <input type="text" class="form-control" name='kd_jbrg' value='<?php echo "$kl[kd_jbrg]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <label class="control-label">KODE BARANG</label>
                                                        <input type="hidden" name='registrasi' value='<?php echo "$rs[registrasi]"; ?>' readonly>
                                                            <input type="text" class="form-control" name='kd_brg' value='<?php echo "$kl[kd_brg]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="control-label">NAMA BARANG</label>
                                                            <input type="text" class="form-control" name='ur_brg' value='<?php echo "$kl[ur_brg]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                            <label class="control-label">PENGAJUAN</label>
                                                            <input type="text" class="form-control" name='qtyMohon' value='<?php echo "$kl[qtyMohon]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label class="control-label">SATUAN</label>
                                                            <input type="text" class="form-control" name='satuan' value='<?php echo "$kl[satuan]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                            <label class="control-label">ACC (ADMIN)</label>
                                                            <input type="text" class="form-control" name='qtyACC' value='<?php echo "$kl[qtyACC]"; ?>' readonly>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label class="control-label">SATUAN</label>
                                                            <input type="text" class="form-control" name='satuan' value='<?php echo "$kl[satuan]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label class="control-label">DESKRIPSI ADMIN TTG BARANG</label>
                                                            <textarea class="form-control" rows="4" name='catatanpersetujuan' readonly><?php echo "$kl[catatanpersetujuan]"; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label class="control-label">KLAIM TIDAK SESUAI (ALASAN)</label>
                                                            <textarea class="form-control" rows="4" name='alasantidaksesuai'><?php echo "$_POST[alasantidaksesuai]"; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                            <label class="control-label">QTY KLAIM</label>
                                                            <input type="text" class="form-control" name='qtytidaksesuai' maxlength="2" value='0'>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label class="control-label">SATUAN</label>
                                                            <input type="text" class="form-control" name='satuan' value='<?php echo "$kl[satuan]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <a href='<?php echo"?module=c_aksiProsedia";?>'>
                                                    <button class="btn btn-default btn-sm pull-right" type="button"> 
                                                    <i class="fa fa-arrow-left "> </i>&nbsp;&nbsp;&nbsp;&nbsp;Kembali
                                                    </button>
                                                    </a>

                                                    <button name="qtyMasuk" type="submit" class="btn bg-green btn-sm pull-right">
                                                    <i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Proses Klaim
                                                    </button>
                                                    </form>
                                                    <!-- END -->
                                                </div>
                                            </div> 
                                        <font color="blue">Catatan : <br>
                                            QTY KLAIM : diisi apabila terdapat jumlah pengajuan berbeda dengan jumlah yang di ACC apabila tanpa keterangan (Deskripsi Admin)
                                        </font>
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
