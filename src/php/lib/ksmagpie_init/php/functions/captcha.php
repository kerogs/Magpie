<?php
/**
    * @brief Generates and displays a captcha image.
    *
    * The ksmagpie_captchaMaker() function initializes a session, generates a random captcha text,
    * stores it in the session, then creates an image containing the captcha and displays it.
    *
    * @note This function uses the GD library for image manipulation.
    * @author Kerogs
*/
function ksmagpie_captchaMaker(){
    session_start();

    $captchaText = mt_rand(10000, 99999);
    $_SESSION['captcha'] = $captchaText;
    
    $image = imagecreate(50, 20);
    $bgColor = imagecolorallocate($image, 255, 255, 255);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    
    // TrueType font path (replace with the actual path to your font)
    $fontFile = __DIR__ . '/pdestroy.ttf';
    
    imagettftext($image, 20, 0, 00, 20, $textColor, $fontFile, $captchaText);
    
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
}