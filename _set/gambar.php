<?php
require_once("../config/koneksi.php");

if($_POST['getDetail']) {
    $kdbrg = $_POST['getDetail'];
    $nup = $_POST['getDetail'];
    $img = mysqli_query($koneksi,
    "SELECT a.kdbrg, a.nup, a.imgdepan,
            b.kd_brg, b.ur_sskel
    FROM m_daftarbmn a
    LEFT JOIN m_bmnbarang b ON b.kd_brg = a.kdbrg
    WHERE a.kdbrg = '$kdbrg' AND a.nup = '$nup'
    ORDER BY a.kdbrg AND a.nup ASC");
    $view = mysqli_fetch_array($img);{       
?>

            <!-- Modal -->
            <img src='<?php echo"../_imgbmn/".$view['imgdepan']."";?>' width='100%' height='100%'/>    
        <?php } }
?>