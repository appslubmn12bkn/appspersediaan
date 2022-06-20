<?php
// membuat koneksi database

//$SERVER = "localhost";
//$U_NAME = "root";
//$PASSWORD = "";
//$DATABASE = "mydbx";

$SERVER = "178.100.212.8";
$U_NAME = "bmnkanreg";
$PASSWORD = "Kanreg12";
$DATABASE = "mydbx";

//$server = "10.100.3.142";
//$username = "siluman";
//$password = "FS@#RserP2v#@";
//$database = "bkn12_silum4n";
include_once 'psl-config.php';   // As functions.php is not included
$koneksi = mysqli_connect("$SERVER", "$U_NAME", "$PASSWORD", "$DATABASE");
// Check connection
if (mysqli_connect_errno()) {
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
} else {
  echo "";
}
