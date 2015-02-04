<?php
/*
Use this to include the "open form" into your site
eg:

//enter helpdesk dir
chdir('helpdesk');
//include form
include('open_inc.php');
//return to dir
chdir(dirname($_SERVER['SCRIPT_FILENAME']));

*/
define('NO_JS', 1);
require_once ('init.php');
include_once (INC_DIR . 'open_inc.php');
if (function_exists('DisplayErrWarn')) {
    DisplayErrWarn();
}
if (isset($submitmsg)) {
    echo $submitmsg;
} else {
    include_once (INC_DIR . 'open_form.php');
}
//return to dir
chdir(dirname($_SERVER['SCRIPT_FILENAME']));
?>
