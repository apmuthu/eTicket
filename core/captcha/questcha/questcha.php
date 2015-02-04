<?php
if (empty($_SESSION)) {
    session_start();
}
//BEGIN QUESTCHA
$questcha_block = file_get_contents('http://thissitekicksass.net/incoming.php');
$questcha = explode('<br />', $questcha_block);
$_SESSION['captcha_hash'] = md5($questcha[6]);
echo '
    <strong>' . $questcha[0] . '</strong>
    <ul>
    <ol>' . $questcha[1] . '</ol>
    <ol>' . $questcha[2] . '</ol>
    <ol>' . $questcha[3] . '</ol>
    <ol>' . $questcha[4] . '</ol>
    <ol>' . $questcha[5] . '</ol>
    </ul>';
?>