<?php
require_once ('init.php');
if (($_SESSION['user']['type']) && ($login)) {
    $inc = 'search_form';
} else {
    header('Location: ' . $page);
    die();
}
$include = $site_header;
if (file_exists($include)) {
    include_once ($include);
}
if (function_exists('DisplayErrWarn')) {
    DisplayErrWarn();
}
if ($login && file_exists('core.js')) {
    echo $html['core.js'];
}
if (isset($inc)) {
    include_once (INC_DIR . "$inc.php");
}
if (isset($_REQUEST['s'])) {
    include_once (INC_DIR . "main.php");
}
$include = $site_footer;
if (file_exists($include)) {
    include_once ($include);
}
?>