<?php
require_once ('init.php');
include_once (INC_DIR . 'open_inc.php');
$include = $site_header;
if (file_exists($include)) {
    include_once ($include);
}
if (file_exists('core.js')) {
    echo $html['core.js'];
}
if (function_exists('DisplayErrWarn')) {
    DisplayErrWarn();
}
if (isset($submitmsg)) {
    echo $submitmsg;
} else {
    include_once (INC_DIR . 'open_form.php');
}
$include = $site_footer;
if (file_exists($include)) {
    include_once ($include);
}
?>