<?php
	include "../config/koneksi.php";

	   echo"<select class='form-control select2' name='unit' id='unit' >
       <option value='$_POST[dir_kodruang]'>PILIH LOC. BMN</option>";

         $kodrg=
         "SELECT 	a.ruang_gabung, a.uniker_id,
                  a.ruang_uraian,
                  b.id_ukerj, b.ur_urg
         FROM  m_ruang a
         LEFT JOIN m_uniker b ON b.id_ukerj=a.uniker_id
         WHERE  a.uniker_id='".$_POST["unit"]."'";

    $q=mysqli_query($koneksi, $kodrg);
    while($unit=mysqli_fetch_array($q)){

    ?>
        <option value="<?php echo $unit["ruang_gabung"] ?>"><?php echo $unit["ur_urg"] ?> |<?php echo $unit["ruang_uraian"] ?></option><br>

    <?php
    }

 echo" </select>";
?>
