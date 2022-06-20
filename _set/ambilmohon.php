<?php
	include "../config/koneksi.php";

	echo"<select class='form-control select2' name='unit' id='unit'>
	<option value='BLANK'>- PILIH PEMOHON -</option>";

    $nipmohon ="SELECT m_pegawai.pns_nip, m_pegawai.pns_nama,m_pegawai.pns_unitkerja,
    				   m_pegawai.pns_jabatan, m_jabatan.idjab,
    		 	       m_jabatan.jab_nama, m_uniker.id_ukerj, m_uniker.ur_urg
    		 	FROM   m_pegawai, m_jabatan, m_uniker
    		 	WHERE  m_pegawai.pns_unitkerja=m_uniker.id_ukerj
    		 	AND    m_pegawai.pns_jabatan=m_jabatan.idjab
    		 	AND    m_pegawai.pns_unitkerja='".$_POST["unit"]."'";

    $q=mysqli_query($koneksi, $nipmohon);
    while($unit=mysqli_fetch_array($q)){

    ?>
        <option value="<?php echo $unit["pns_nip"] ?>"><?php echo $unit["pns_nama"] ?></option><br>

    <?php
    }
      echo" </select>";
?>
