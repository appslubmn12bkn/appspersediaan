<?php
session_start();
function timer(){
//set waktu 10 menit
$time=(1*10);
$_SESSION[timeout]=time()+$time;
}
function cek_login(){
$timeout=$_SESSION[timeout];
if(time()<$timeout){
timer();
return true;
}else{
unset($_SESSION[timeout]);
return false;
}
}
?>
