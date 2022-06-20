<?php
include "../config/koneksi.php";
session_start();
echo"   <select class='from-control select2' name='pbi' id='pbi' >
       <option value='$_POST[pbi]'>PILIH PBI</option>";

    $pebin="SELECT a.kd_pebin, a.ur_pebin,
					b.kd_pebin, b.kd_pbi, b.ur_pbi
				FROM   m_pebin a
				LEFT JOIN m_pbi b ON b.kd_pebin=a.kd_pebin
				WHERE  a.kd_pebin='".$_POST["pebin"]."'";

    $q=mysqli_query($koneksi, $pebin);
    while($pbi=mysqli_fetch_array($q)){

    ?>
    <option value="<?php echo $pbi["kd_pbi"] ?>"><?php echo $pbi["kd_pbi"] ?> | <?php echo $pbi["ur_pbi"] ?></option><br>

    <?php
    }

echo" </select>";
?>
