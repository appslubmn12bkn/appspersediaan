<?php
include "../config/koneksi.php";
session_start();
echo "   <select name='r_unit' id='r_unit' >
       <option value='$_POST[r_unit]'>PILIH UNIT</option>";

$unut = "SELECT a.r_idutama, a.r_ruangutama, a.r_namaruang,
					b.r_ruangutama, b.r_ruangunit, 
                    b.r_ruangannama, b.r_ruanganpjawab
				FROM   r_ruangutama a
				LEFT JOIN r_ruangan b ON b.r_ruangutama=a.r_idutama
				WHERE  a.r_idutama='" . $_POST["unut"] . "'";

$q = mysqli_query($koneksi, $unut);
while ($unit = mysqli_fetch_array($q)) {

?>
    <option value="<?php echo $unit["r_ruangunit"] ?>"><?php echo $unit["r_ruangunit"] ?> | <?php echo $unit["r_ruangannama"] ?></option><br>

<?php
}

echo " </select>";
?>