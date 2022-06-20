<?php
include "../config/koneksi.php";
session_start();
echo"   <select name='unit' id='unit' >
       <option value='$_POST[unit]'>PILIH UNIT</option>";

    $unut="SELECT a.id_unut, a.ur_unut,
					b.id_ukerj, b.id_unut, b.ur_urg
				FROM   m_unut a
				LEFT JOIN m_uniker b ON b.id_unut=a.id_unut
				WHERE  a.id_unut='".$_POST["unut"]."'";

    $q=mysqli_query($koneksi, $unut);
    while($unit=mysqli_fetch_array($q)){

    ?>
    <option value="<?php echo $unit["id_ukerj"] ?>"><?php echo $unit["id_ukerj"] ?> |<?php echo $unit["ur_urg"] ?></option><br>

    <?php
    }

echo" </select>";
?>
