<?php

    //membuat koneksi ke database
include "../config/koneksi.php";
session_start();

    //menangkap variabel yang diketik oleh user
    $cari   = $_GET['cari'];


    //jika tidak ada data yang dicari
    if($cari == null){
        echo "data kosong";
    
    //jika ada data yang dicari
    }else{
        //cari sesuai kata yang diketik
        $data   = mysqli_query($koneksi, "SELECT kd_brg,ur_sskel,satuan FROM b_nmbmn WHERE kd_brg LIKE '%$cari%'");

        $list = array();
        $key=0;

        //lakukan looping untuk menampilkan data yang sesuai
        while($row = mysqli_fetch_assoc($data)) {
            $list[$key]['text'] = $row['ur_sskel']; 
            $list[$key]['id'] = $row['kd_brg'];
            $key++;
        }

        //data ditampilkan dalam bentuk json
        echo json_encode($list);
    }