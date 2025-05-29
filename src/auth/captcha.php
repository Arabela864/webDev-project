<?php
session_start();

// 6-char random code
$random_num   = md5(random_bytes(5));
$captcha_code = substr($random_num, 0, 6);
$_SESSION['captcha'] = $captcha_code;

// create a 70×30 px image
$layer = imagecreatetruecolor(70, 30);

// fill background
$bg = imagecolorallocate($layer, 255, 160, 119);
imagefill($layer, 0, 0, $bg);

// draw text
$txt_col = imagecolorallocate($layer, 0, 0, 0);
imagestring($layer, 5, 5, 5, $captcha_code, $txt_col);

// output PNG
header("Content-Type: image/png");
imagepng($layer);
imagedestroy($layer);
