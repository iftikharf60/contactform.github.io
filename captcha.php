<?php
//Start session
session_start();
//Generate random number with md5 encryption
$captcha = md5(rand(1000, 9999));
//Get 6 digits encrypted main captcha code from a random number
$captcha_code = substr($captcha, 0, 6);
//Store captcha in session
$_SESSION['captcha'] = $captcha_code;
//Generate standard captcha image
$captcha_img = imagecreatetruecolor(65, 27); 
//Background color
$captcha_bg = imagecolorallocate($captcha_img, 22, 86, 165);
//Give captcha image a background
imagefill($captcha_img, 0, 0, $captcha_bg);
//foreground color
$captcha_fg = imagecolorallocate($captcha_img, 255, 255, 255);
//Print captcha text in the image with a random position and size
imagestring($captcha_img, 7, 7, 5,  $captcha_code, $captcha_fg);
//Prevent browser cache
header("Cache-Control: no-store, no-cache, must-revalidate");
//Render this PHP file as an image
header('Content-type: image/png');
//Show the captcha as a PNG image on the browser
imagepng($captcha_img);
?>