
<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
ob_start();
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');
if (empty($_SESSION['UNAME']) AND empty($_SESSION['PASSWORD'])){
	echo "<link href='../../asset/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'>

                        <div class='alert alert-info'>
                        <br>
						<h2><i class='icon fa fa-info'></i> Pemberitahuan!</h2>
                        <b> MAAF BERITA ACARA TIDAK BISA DITAMPILKAN !,</b> <bR>
                        Untuk menampilkan BERITA ACARA yang mau dicetak, Anda harus login terlebih dahulu <br>
                        <br>
											  </div>";
}
else{
$html = '
<html>
<head>
</head>
<body>';


# Baca variabel URL
# Perintah untuk mendapatkan data dari tabel penjualan
echo "";
?>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<style type="text/css">
		body {
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}
		
		/* Table */
		.demo-table {
			border-collapse: collapse;
			font-size: 11px;
		}
		.demo-table th, 
		.demo-table td {
			border: 1px solid #808080;
			padding: 7px 17px;
			font-size: 12px;
		}
		.demo-table .title {
			caption-side: bottom;
			margin-top: 15px;
		}
		
		/* Table Header */
		.demo-table thead th {
			background-color: #dcdcdc;
			color: #000;
			border-color: #808080 !important;
			text-transform: uppercase;
		}
		
		/* Table Body */
		.demo-table tbody td {
			color: #353535;
		}
		.demo-table tbody td:first-child,
		.demo-table tbody td:last-child,
		.demo-table tbody td:nth-child(4) {
			text-align: right;
		}
		.demo-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.demo-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
			transition: all .2s;
		}
		
		/* Table Footer */
		.demo-table tfoot th {
			background-color: #e5f5ff;
		}
		.demo-table tfoot th:first-child {
			text-align: left;
		}
		.demo-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
<?php
$registrasi = $_GET['registrasi'];
?>
<table width="100%" align="center" border='0'>
  <tr>
	<td colspan="3" align="center">
	<br><br>
	<img src="../../dist/img/headLogo.png" width="75px" height="75px" align='center' />
	<h3>BADAN KEPEGAWAIAN NEGARA<BR>KANTOR REGIONAL XII</h3>
	<h5>Jalan Hangtuah Ujung Nomor 148, Sialang Sakti, Tenayan Raya, Pekanbaru, Riau 28285<br>
		Telepon (0761) 7870006; Faksimile (0761) 46104<br>
		Laman: https://pekanbaru.bkn.go.id;|Pos-el: kanreg12.pekanbaru@bkn.go.id
	</h5>
	<hr>
	<p>Berita Acara Keluar Masuk Barang Persediaan</p>
	</td>
  </tr> 
</table>

<p class="" align="justify">
Pada hari ini
<strong><?php echo tglIndonesia(date('D'));?></strong>
tanggal <strong><?php echo terbilang (tglIndonesia(date('d')));?></strong>
bulan <strong><?php echo tglIndonesia(date('F'));?></strong>
Tahun <strong><?php echo terbilang (tglIndonesia(date('Y')));?></strong>
kami yang bertanda tangan dibawah ini :
<br>
<?php
	$PIHAK1 = mysqli_query($koneksi,
	" SELECT 	a.kota, a.idttd,
						a.tanggal, a.tgl_isi,
						a.tgl_setuju, 
						a.nipsedia, a.namasedia,
						b.pns_nip, b.pns_jabatan, 
						b.pns_nama, b.pns_unitkerja,
						b.pns_unitkerja2,
						b.pns_namdepan, b.pns_namblkg,
						c.JBF_KODJAB, c.JBF_NAMJAB,
						d.r_idutama, d.r_ruangutama
	FROM s_ttd a
	LEFT JOIN m_pegawai b ON b.pns_nip=a.nipsedia
	LEFT JOIN m_jabatan c ON c.JBF_KODJAB=b.pns_jabatan
	LEFT JOIN r_ruangutama d ON d.r_idutama = b.pns_unitkerja
	GROUP BY a.idttd ASC");
	$a = mysqli_fetch_array($PIHAK1);

	$PIHAK2 = mysqli_query($koneksi,
	" SELECT 	a.registrasi, a.user, a.pemohon,
						b.pns_nip, b.pns_jabatan, b.pns_nama,
						b.pns_namdepan, b.pns_namblkg,
						b.pns_unitkerja, b.pns_unitkerja2,
						c.JBF_KODJAB, c.JBF_NAMJAB,
						d.r_idutama, d.r_ruangutama
	FROM c_unitsediaminta a
	LEFT JOIN m_pegawai b ON b.pns_nip=a.pemohon
	LEFT JOIN m_jabatan c ON c.JBF_KODJAB=b.pns_jabatan
	LEFT JOIN r_ruangutama d ON d.r_idutama = b.pns_unitkerja
	WHERE a.registrasi = '$registrasi'
	GROUP BY a.registrasi ASC");
	$b = mysqli_fetch_array($PIHAK2);

	$mengetahui = mysqli_query($koneksi,
	" SELECT 	a.registrasi, a.user,
						b.pns_nip, b.pns_jabatan, b.pns_nama,
						b.pns_unitkerja, b.pns_unitkerja2,
						c.JBF_KODJAB, c.JBF_NAMJAB,
						d.r_idutama, d.r_ruangutama
	FROM c_unitsediaminta a
	LEFT JOIN m_pegawai b ON b.pns_nip=a.user
	LEFT JOIN m_jabatan c ON c.JBF_KODJAB=b.pns_jabatan
	LEFT JOIN r_ruangutama d ON d.r_idutama = b.pns_unitkerja
	WHERE a.registrasi = '$registrasi'
	GROUP BY a.registrasi ASC");
	$c = mysqli_fetch_array($mengetahui);
?>
<table border='0' >
  <tr>
      <td width="10px">&nbsp;1. </td>
      <td width="100px">&nbsp;Nama</td>
      <td width="15px">:</td>
      <td><?php echo $a['namasedia']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;N I P</td>
      <td width="15px">:</td>
      <td><?php echo $a['nipsedia']; ?></td>
  </tr>
    <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Jabatan</td>
      <td width="15px">:</td>
      <td><?php echo $a['JBF_NAMJAB']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Unit Kerja</td>
      <td width="15px">:</td>
      <td><?php echo $a['r_ruangutama']; ?> - <?php echo $a['pns_unitkerja2']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;</td>
      <td width="15px"></td>
      <td>Dalam berita acara ini disebut <b>PIHAK PERTAMA</td>
  </tr>
  <br><br>
  <tr>
      <td width="10px">&nbsp;2. </td>
      <td width="100px">&nbsp;Nama</td>
      <td width="15px">:</td>
      <td><?php echo $b['pns_nama']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;N I P</td>
      <td width="15px">:</td>
      <td><?php echo $b['pemohon']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Jabatan</td>
      <td width="15px">:</td>
      <td><?php echo $b['JBF_NAMJAB']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Unit Kerja</td>
      <td width="15px">:</td>
      <td><?php echo $b['r_ruangutama']; ?> - <?php echo $b['pns_unitkerja2']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;</td>
      <td width="15px"></td>
      <td>Dalam berita acara ini disebut <b>PIHAK KEDUA</td>
  </tr>
</table>
<p class="" align="justify">
  <b>PIHAK PERTAMA</b> telah menyerahkan barang persediaan berupa ATK/ARTK/Bahan Komputer kepada <b>PIHAK KEDUA</b> dan  <b>PIHAK KEDUA</b> telah menerima barang persediaan berupa ATK/ARTK/Bahan Komputer dengan rincian sebagaimana terlampir sbb:
</p>
	<table width="650" class="demo-table" align="center" border='0'>
		<thead>
			<tr>
				<th rowspan='2' width='250px' >URAIAN (KD - BRG)</th>
				<th rowspan='2' width='50px' >SAT</th>
				<th rowspan='2' width='100px' >MEREK_TYPE</th>
				<th colspan='2' scope="col">KUANTITAS</th>
				<th rowspan='2' width='65px' >Cat.</th>
			</tr>
			<tr>
				<th width='50px' align="center">MOHON</th>
				<th width='50px' align="center">ACC</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan='6' align='center'>Terlampir</td>
			</tr>
			</tfoot>
	</table>
<p align="justify">
Barang-barang tersebut di atas telah diterima dalam keadaan kondisi <strong>baik</strong>.<br>
Demikian Berita Acara Serah Terima Barang ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
</p>


<table width='100%' border='0' align="center">
      <tr>
        <td width='150' align="center"><BR>PIHAK KEDUA<br><?php echo $b['JBF_NAMJAB']; ?></td>
        <td width='50' align="center"></td>
        <td width='150' align="center">Pekanbaru, <?php echo TanggalIndonesia($a[tgl_setuju]); ?> <br />
          PIHAK PERTAMA<br><?php echo $a['JBF_NAMJAB']; ?></td>
      </tr>
      <tr>
        <td height='60' align='center'></td>
        <td></td>
        <td align='center'></td>
      </tr>
      <tr>
        <td align="center"><?php echo $b['pns_nama']; ?> 
				<br>NIP. <?php echo $b['pemohon']; ?>
				</td>
        <td align="center"></td>
        <td align="center"><?php echo $a['namasedia']; ?>
        <br>NIP. <?php echo $a['nipsedia']; ?>
        </td>
      </tr>

      <tr>
        <td width='150' align="center">&nbsp;&nbsp;&nbsp;</td>
        <td width='50' align="center">&nbsp;&nbsp;&nbsp;</td>
        <td width='150' align="center">&nbsp;&nbsp;&nbsp;</td>
      </tr>

      <tr>
        <td width='150' align="center">Mengetahui,<br><?php echo $c['JBF_NAMJAB']; ?></td>
        <td width='50' align="center">&nbsp;&nbsp;&nbsp;</td>
        <td width='150' align="center">&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td height='60' align='center'></td>
        <td></td>
        <td align='center'></td>
      </tr>
      <tr>
        <td width='150' align="center"><?php echo $c['pns_nama']; ?>
        <br>NIP. <?php echo $a['pns_nip']; ?></td>
        <td width='50' align="center">&nbsp;&nbsp;&nbsp;</td>
        <td width='150' align="center">&nbsp;&nbsp;&nbsp;</td>
      </tr>
</table>
</body>
</html>
<?php }?>
<?php
$out = ob_get_contents();
ob_end_clean();
include("../../MPDF/mpdf.php");
$mpdf = new mPDF('c','A4-P','');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('mpdf/mpdf.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>