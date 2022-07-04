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
                        Cetak Pengajuan ATK / ARTK / Bakom (Unit)
                        <small>Barang Persediaan masuk dan keluar</small>
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                  <div class="box box-solid">
                                      <div class="box-body">
                                              <div>
                                              <strong>NOMOR REGISTRASI : </strong>
                                                <form method='post' class='form-horizontal' action=''>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-4'>
                                                            <select class="s2 form-control" style="width: 100%" name='registrasi'>
                                                                <option value=''></option>
                                                                <?php
                                                                $dataSql = "SELECT  a.registrasi, a.unut, 
                                                                                    a.unit,
                                                                                    b.r_idutama, b.r_ruangutama
                                                                            FROM c_unitsediaminta a 
                                                                            LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
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
                                  </div>
                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped mb-none" id="table_4">
                                                  <thead>
                                                  <tr>
                                                      <th bgcolor="#d2d6de">#</th>
                                                      <th bgcolor="#d2d6de">URAIAN BARANG (KODE - NAMA)</th>
                                                      <th bgcolor="#d2d6de">PENGAJUAN</th>
                                                      <th bgcolor="#d2d6de">KELUAR</th>
                                                      <th bgcolor="#d2d6de">MEREK_TYPE</th>
                                                      <th bgcolor="#d2d6de">TRANSAKSI</th>
                                                      <th bgcolor="#d2d6de">CATATAN ADMIN (KLAIM UNIT)</th>
                                                      <th bgcolor="#d2d6de">PROSES ADMIN</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    <?php
                                                    $tabel = mysqli_query($koneksi,
                                                    "SELECT a.registrasi, a.tglproses, 
                                                            a.satuan, a.flag_kirim, 
                                                            a.kd_brg, a.qtyACC, a.tanggaltl,
                                                            a.qtyMohon, a.merek_type, a.prosedur,
                                                            b.registrasi, a.catatanpersetujuan, 
                                                            a.catatanklaim,
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
                                                    AND (a.prosedur IN ('61')) 
                                                    AND a.flag_kirim = 'Y'
                                                    ORDER BY a.registrasi ASC");

                                                    $numRows = mysqli_num_rows($tabel);
                                                    $no = 0;
                                                    while ($x = mysqli_fetch_array($tabel)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                      <td><?php echo"$no";?></td>
                                                      <td><?php echo"$x[kd_kbrg] $x[kd_jbrg] - $x[ur_brg]";?></td>
                                                      <td><?php echo"$x[qtyMohon] $x[satuan]";?></td>
                                                      <td><?php echo"$x[qtyACC] $x[satuan]";?></td>
                                                      <td><?php echo"$x[merek_type]";?></td>
                                                      <td><?php echo"$x[jns_trn]";?></td>
                                                      <td><?php echo"$x[catatanklaim]";?></td>
                                                      <td><?php echo indotgl($x[tglproses]);?></td>
                                                    </tr>
                                                    </tfoot>
                                                    <?php } ?>
                                                    </table> 
                                <font face=tahoma size=2>Jumlah ATK/ARTK/BAKOM diajukan: <b><?php echo "$numRows"; ?></b></font>
                                <table>
                                <thead>
                                <tr>
                                <th>
                                <form method=POST action='<?php echo "media/CETAK/sedia_cetakbast.php?registrasi=$_POST[registrasi]"; ?>' target='_blank'>
                                <button type=submit class='btn bg-navy btn-sm'><i class='fa fa-print'></i>
                                &nbsp;&nbsp;&nbsp;BAST (Pdf.)</button></a>
                                </form>
                                </th>
                                <th>&nbsp;&nbsp;&nbsp;</th>
                                <th>
                                <form method=POST action='<?php echo "media/CETAK/sedia_cetaklamp.php?registrasi=$_POST[registrasi]"; ?>' target='_blank'>
                                <button type=submit class='btn bg-navy btn-sm'><i class='fa fa-print'></i>
                                &nbsp;&nbsp;&nbsp;Lamp. BAST (Pdf.)</button></a>
                                </form>
                                </th>
                                </tr>
                                </thead>
                                </table>
                                <?php } ?> 
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
                ?>
<?php
        }
    }
}
?>

