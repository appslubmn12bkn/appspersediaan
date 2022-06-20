<?php
	include "../config/koneksi.php";

	   echo"<select class='form-control select2' name='unit' id='unit'>";


    $nipttd="SELECT m_pegawai.pns_nip, m_pegawai.pns_nama,m_pegawai.pns_unitkerja,
					m_pegawai.pns_jabatan, m_jabatan.idjab,
					m_jabatan.jab_nama, m_uniker.id_ukerj, m_uniker.ur_urg
				FROM   m_pegawai, m_jabatan, m_uniker
				WHERE  m_pegawai.pns_unitkerja=m_uniker.id_ukerj
				AND    (m_pegawai.idpegawai IN (1,2,3,4,5,6,7,8,9,21,22,23,25,28,36,37,38,40,46,47,60,61,62,66,68,69,70,73))
				AND    m_pegawai.pns_jabatan=m_jabatan.idjab
				AND    m_pegawai.pns_unitkerja='".$_POST["unit"]."'";

    $q=mysqli_query($koneksi, $nipttd);
    while($unit=mysqli_fetch_array($q)){

    ?>
        <option value="<?php echo $unit["pns_nip"] ?>"><?php echo $unit["pns_nama"] ?> - <?php echo $unit["jab_nama"] ?></option><br>

    <?php
    }

 echo" </select>";
?>
