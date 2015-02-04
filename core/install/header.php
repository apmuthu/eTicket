<?php
$themepage = 'template.php';
$bodytag = '%%BODY%%';
$header = '';
$footer = '';
if (file_exists($themepage)) {
    ob_start();
    include_once $themepage;
    $temp = ob_get_contents();
    ob_end_clean();
    if (isset($title)) $temp = preg_replace('/(<title>)(.*)(<\/title>)/is', '${1}' . $title . '$3', $temp);
    $header = eregi_replace($bodytag . '.*', '', $temp);
    $footer = eregi_replace('.*' . $bodytag, '', $temp);
}
if (!empty($header)) {
    echo $header;
    unset($header);
}
?>
