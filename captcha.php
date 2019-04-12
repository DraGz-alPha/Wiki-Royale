<?php
    session_start();

    // Generating Random Code
    $captcha_number = rand(0,9999);

    $_SESSION['captcha_text'] = $captcha_number;

    $captcha_image = imagecreatefromjpeg("captcha.jpg");
    $font_color = imagecolorallocate($captcha_image, 0, 0, 0);
    imagestring($captcha_image, 5, 20, 10, $captcha_number, $font_color);
    imagejpeg($captcha_image);
    imagedestroy($captcha_image);
?>