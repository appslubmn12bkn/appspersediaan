<?php
include "../config/koneksi.php";
if (isset($_POST['unut'])) {
    $unut = $_POST["unut"];

    $sql = "SELECT a.id_unut, a.ur_unut,
                   b.id_ukerj, b.id_unut, b.ur_urg 
            FROM   m_unut a
            LEFT JOIN m_uniker b ON b.id_unut=a.id_unut 
            WHERE  a.id_unut=$unut";
    $hasil = mysqli_query($koneksi, $sql);
    while ($data = mysqli_fetch_array($hasil)) {
        ?>
        <option value="<?php echo  $data['id_ukerj']; ?>"><?php echo $data['ur_urg']; ?></option>
        <?php
    }
}
if (isset($_POST['merk'])) {
    $merk = $_POST["merk"];

    $sql = "select * from tipe_kendaraan where id_merk_kendaraan=$merk";
    $hasil = mysqli_query($kon, $sql);
    while ($data = mysqli_fetch_array($hasil)) {
        ?>
        <option value="<?php echo  $data['id_tipe_kendaraan']; ?>"><?php echo $data['tipe_kendaraan']; ?></option>
        <?php
    }
}

?>