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


?>
                    <section class="content-header">
                      <h1>
                        Pengajuan ATK / ARTK / BAKOM
                        <small>Barang Persediaan masuk dan keluar</small>
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">

                        <button type="button" class="btn bg-blue btn-md flat" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; BARU | PENGAJUAN ATK / ARTK / BAKOM</button>

                        <!-- MODAL DAFTAR UNIT -->
                        <?php
                        $kode = rand(0,999999);
                        $data = mysqli_fetch_array(mysqli_query($koneksi,
                        "SELECT MAX(register) AS akhir
                        FROM c_unitsediaminta
                        WHERE register LIKE '%$kode%'"));
                        $lastindex  = $data['akhir'];
                        $kdReg      = $kode . sprintf($lastindex);
                        ?>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Form Pengajuan</h4>
                                </div>
                            <div class="modal-body">

                            <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=sedia_pengajuan&act=savePengajuan"; ?>' enctype='multipart/form-data'>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-2 text-right control-label col-form-label">
                                    Nomor Register</label>
                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" name='register' value='<?php echo $kdReg; ?>' readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                <label for="fname" class="col-sm-2 text-right control-label col-form-label">
                                Unit Utama</label>
                                <div class="col-sm-10">
                                    <select class="s2 form-control" style="width: 100%; height:36px;" name='unut'>
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
                                </div>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-2 text-right control-label col-form-label">
                                    Unit Kerja</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name='unitk' placeholder="contoh : Sub.Bagian Umum" value='<?php echo $_POST[unitk]; ?>'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-2 text-right control-label col-form-label">
                                    Tanggal Pengajuan</label>
                                    <div class="col-sm-2">
                                    <input type="text" class="form-control datepicker" name='tglmohon' value='<?php echo $_POST[tglmohon]; ?>'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-2 text-right control-label col-form-label">
                                    P I C</label>
                                    <div class="col-sm-3">
                                    <input type="text" maxlength='18' class="form-control" name='pic' value='' placeholder='NIP Pemohon'> 
                                    </div>
                                </div>
                        </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-md flat">
                                <i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Simpan</button>
                            </div>
                        </form>
                        </div>
                        </div>
                        </div>
                        <!-- END DAFTAR UNIT -->

                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_1" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> NO </th>
                                                    <th bgcolor='#dcdcdc'> REGISTER</th>
                                                    <th bgcolor='#dcdcdc'> UNIT</th>
                                                    <th bgcolor='#dcdcdc'> UNIT KERJA</th>
                                                    <th bgcolor='#dcdcdc'> <i class="fa fa-calendar"></i> </th>
                                                    <th bgcolor='#dcdcdc'> P I C</th>
                                                    <th bgcolor='#dcdcdc'> QTY</th>
                                                    <th bgcolor='#dcdcdc' width='25px'>UPLOAD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $newData = mysqli_query(
                                                    $koneksi,
                                                    " SELECT a.registrasi, a.unit, a.unut, a.qtypesanan,
                                                             a.pemohon, a.tglmohon, a.prosedur,
                                                             a.tglkirimunit, a.user, a.idminta,
                                                             b.r_idutama, b.r_ruangutama, b.r_namaruang,
                                                             c.pns_nip, c.pns_nama,
                                                             d.flag, d.ur_flag
                                                        FROM c_unitsediaminta a
                                                        LEFT JOIN r_ruangutama b ON b.r_idutama = a.unut
                                                        LEFT JOIN m_pegawai c ON c.pns_nip = a.pemohon
                                                        LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                        WHERE a.tglmohon BETWEEN '$rs[s_tglawal]' AND '$rs[s_tglakhir]'
                                                        ORDER BY a.idminta AND a.tglmohon ASC");

                                                $no = 0;
                                                while ($r = mysqli_fetch_array($newData)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[registrasi]"; ?></td>
                                                        <td><?php echo "$r[r_ruangutama]"; ?></td>
                                                        <td><?php echo "$r[unit]"; ?></td>
                                                        <td><?php echo indotgl($r[tglmohon]); ?></td>
                                                        <td><?php echo "$r[pns_nama]"; ?></td>
                                                        <td><?php echo "$r[qtypesanan]"; ?></td>
                                                        <td align="center" width="170">
                                                        <?php if($r['prosedur']=='1'){?>
                                                        <a class='btn bg-blue btn-sm' href=<?php echo "?module=sedia_pengajuan&act=upload&registrasi=$r[registrasi]"; ?>>
                                                        <i class="fa fa-upload"></i></a>
                                                        <?php } else { ?>
                                                        <i class="fa fa-check"></i>
                                                        &nbsp;&nbsp; terupload - <?php echo $update ; ?> 
                                                        <?php } ?>
                                                        </td>
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

                case "upload":
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
