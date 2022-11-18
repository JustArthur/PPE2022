<?php
session_start();
$code=rand(1000,9999);
$_SESSION["code"]=$code;
$image = imagecreatetruecolor(50, 24);
$background = imagecolorallocate($image, 245, 73, 73);
$forground = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $background);
imagestring($image, 5, 5, 5,  $code, $forground);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>