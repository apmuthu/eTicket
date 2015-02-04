<?php
require_once ('init.php');
if ($_SESSION['user']['type'] == 'client') {
    if ($login) {
        switch ($a) {
            case "view":
                $id = preg_replace('/\D+/', '', $_REQUEST['id']);
                $titles['viewticket'] = "$id: " . $titles['viewticket'];
                $inc_php = 'viewticket';
            break;
            case "close":
                if (count($_POST['t'])) {
                    foreach($_POST['t'] as $id => $val) {
                        CloseTicket($id);
                    }
                }
            break;
            case "reopen":
                if (count($_POST['t'])) {
                    foreach($_POST['t'] as $id => $val) {
                        ReopenTicket($id);
                    }
                }
            break;
            case "post":
                include_once (INC_DIR . $a . '.php');
            break;
            case "logout":
                $page = $page ? $page : $_SERVER['PHP_SELF'];
                logout($page);
            break;
        }
    } else {
        if ($_POST) {
            $err = LANG_ERROR_LOGIN;
            session_destroy();
        }
        $inc = 'user_login.html';
    }
} else {
    $inc = 'user_login.html';
}
if (!isset($inc) && !isset($inc_php)) {
    $inc_php = 'main';
}
$include = $site_header;
if (file_exists($include)) {
    include ($include);
}
if (function_exists('DisplayErrWarn')) {
    DisplayErrWarn();
}
if ($login && file_exists('core.js')) {
    echo $html['core.js'];
}
if (file_exists($themes_dir . $db_settings['theme'] . '/' . $inc . '.php')) {
    include_once ($themes_dir . $db_settings['theme'] . '/' . "$inc.php");
}
if (file_exists(INC_DIR . $inc_php . '.php')) {
    include_once (INC_DIR . $inc_php . '.php');
}
echo $html['end'];
$include = $site_footer;
if (file_exists($include)) {
    include ($include);
}
?>