<?php
if (empty($_SESSION)) {
    session_start();
} // start a session
$rand = rand(10000, 99999); // generate 5 digit random number
$_SESSION['captcha'] = $rand; //debug ONLY
$_SESSION['captcha_hash'] = md5($rand); // create the hash for the random number and put it in the session
if ($rand) {
    header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    //output the image
    header('Content-type: image/jpeg'); // tell the browser that this is an image
    //You can change the following, providing it still uses $rand
    $image = imagecreate(55, 15); // create the image
    $bgColor = imagecolorallocate($image, 255, 255, 255); // use white as the background image
    $textColor = imagecolorallocate($image, 0, 0, 0); // the text color is black
    imagestring($image, 5, 5, 0, $rand, $textColor); // write the random number
    imagejpeg($image); // send the image to the browser
    imagedestroy($image); // destroy the image to free up the memory
    
}
?>