<?php
	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 

	function indotgl($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = Bulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.'-'.$bulan.'-'.$tahun;		 
	}	

	function Bulan($bln){
				switch ($bln){
					case 1: 
						return "01";
						break;
					case 2:
						return "02";
						break;
					case 3:
						return "03";
						break;
					case 4:
						return "04";
						break;
					case 5:
						return "05";
						break;
					case 6:
						return "06";
						break;
					case 7:
						return "07";
						break;
					case 8:
						return "08";
						break;
					case 9:
						return "09";
						break;
					case 10:
						return "10";
						break;
					case 11:
						return "11";
						break;
					case 12:
						return "12";
						break;
				}
			} 

			function TanggalIndonesia($date) {
				$date = date('Y-m-d',strtotime($date));
				if($date == '0000-00-00')
					return 'Tanggal Kosong';
			 
				$tgl = substr($date, 8, 2);
				$bln = substr($date, 5, 2);
				$thn = substr($date, 0, 4);
			 
				switch ($bln) {
					case 1 : {
							$bln = 'Januari';
						}break;
					case 2 : {
							$bln = 'Februari';
						}break;
					case 3 : {
							$bln = 'Maret';
						}break;
					case 4 : {
							$bln = 'April';
						}break;
					case 5 : {
							$bln = 'Mei';
						}break;
					case 6 : {
							$bln = "Juni";
						}break;
					case 7 : {
							$bln = 'Juli';
						}break;
					case 8 : {
							$bln = 'Agustus';
						}break;
					case 9 : {
							$bln = 'September';
						}break;
					case 10 : {
							$bln = 'Oktober';
						}break;
					case 11 : {
							$bln = 'November';
						}break;
					case 12 : {
							$bln = 'Desember';
						}break;
					default: {
							$bln = 'UnKnown';
						}break;
				}
			 
				$hari = date('N', strtotime($date));
				switch ($hari) {
					case 0 : {
							$hari = 'Minggu';
						}break;
					case 1 : {
							$hari = 'Senin';
						}break;
					case 2 : {
							$hari = 'Selasa';
						}break;
					case 3 : {
							$hari = 'Rabu';
						}break;
					case 4 : {
							$hari = 'Kamis';
						}break;
					case 5 : {
							$hari = "Jum'at";
						}break;
					case 6 : {
							$hari = 'Sabtu';
						}break;
					default: {
							$hari = 'UnKnown';
						}break;
				}
			 
			//	$tanggalIndonesia = "".$hari.", ".$tgl . " " . $bln . " " . $thn;
			//	return $tanggalIndonesia;

				$tanggalIndonesia = " ".$tgl . " " . $bln . " " . $thn;
				return $tanggalIndonesia;
			}

function rupiah($angka){
	
	$hasil_rupiah = "" . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
?>