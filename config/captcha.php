<?php
session_start();
header("Content-Type: image/png");
// Generating Random Numbers Between 1 to 99
$sum1 = rand(1,20); // First Number
$sum2 = rand(1,20); // Second Number
//Save the sum of the first and second number into the session.
$_SESSION['captcha'] = $sum1 + $sum2;
$im = imagecreate(100, 35);// SET WIDTH AND HEIGHT
$background_color = imagecolorallocate($im, 0, 0, 0); // SET IMAGE BACKGROUND COLOR
$text_color = imagecolorallocate($im, 255, 255, 255); // SET IMAGE TEXT COLOR
imagestring($im, 5, 20, 10,  $sum1 .' + '. $sum2, $text_color);
imagepng($im);
imagedestroy($im);
?>
