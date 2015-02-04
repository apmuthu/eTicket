<?php
require_once ('init.php');
if (($_SESSION['user']['type'] == 'admin') && ($login['name'])) {
    $file = INC_DIR . 'admin_' . $a . '.php';
    switch ($a) {
        case "logout":
            logout($page);
        break;
        case "view":
            $id = preg_replace('/\D+/', '', $_GET['id']);
            $titles['viewticket'] = "$id: " . $titles['viewticket'];
            $inc = 'viewticket';
        break;
        case "delete":
            if ($login[$a] || $login['ID'] == ADMIN) {
                if (count($_POST['t'])) {
                    foreach($_POST['t'] as $id => $val) {
                        $id = (int)$id;
                        $delete = DeleteTicket($id);
                        if (!empty($delete)) {
                            $err[] = LANG_DELETE . ' ' . LANG_ERROR . " $id: $delete";
                        }
                    }
                }
            }
        break;
        case "close":
            if (count($_POST['t'])) {
                foreach($_POST['t'] as $tid => $val) {
                    CloseTicket($tid);
                }
            }
        break;
        case "onhold":
            if (count($_POST['t'])) {
                foreach($_POST['t'] as $tid => $val) {
                    HoldTicket($tid);
                }
            }
        break;
        case "reopen":
            if (count($_POST['t'])) {
                foreach($_POST['t'] as $tid => $val) {
                    ReopenTicket($tid);
                }
            }
        break;
        case "transfer":
            $tid = (int)$_POST['tid'];
            $cid = (int)$_POST['cid'];
            $add_msg = escape_string(htmlspecialchars($_POST['add_msg']));
            $alert = isset($_POST['trans_alert']) ? true : false;
            TransCatTicket($tid, $cid, $add_msg, $alert);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        break;
        case "transfer_rep":
            $tid = (int)$_POST['tid'];
            $rid = (int)$_POST['rid'];
            $alert = isset($_POST['trans_alert']) ? true : false;
            TransRepTicket($tid, $rid, $alert);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        break;
        case "priority":
            $pri = (int)$_POST['pri'];
            $tid = (int)$_POST['tid'];
            $query = mysql_query("UPDATE " . $db_table['tickets'] . " SET priority='" . $pri . "' WHERE ID=" . $tid);
            if ($query) {
                header('Location: ' . $_SERVER['REQUEST_URI']);
                die();
            } else {
                $err = LANG_FAILED . ': ' . mysql_error();
            }
        break;
        case "headers":
            header('Content-type: text/plain;');
            $msgid = (int)$_GET['msg'];
            $message = mysql_fetch_array(mysql_query("SELECT headers FROM " . $db_table['messages'] . " WHERE ID='" . $msgid . "'"));
            echo $message['headers'];
            die();
        break;
        case "post":
            include (INC_DIR . $a . '.php');
        break;
        case "my":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "pref":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "mail":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "db":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "cat":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "rep":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "user_group":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "banlist":
            if (file_exists($file)) {
                include ($file);
            }
        break;
        case "mytickets":
            if (file_exists($file)) {
                include ($file);
            }
        break;
    }
} else {
    if ($_POST) {
        $err = LANG_ERROR_LOGIN;
        session_destroy();
    }
    $inc = $themes_dir . $db_settings['theme'] . '/' . "admin_login.html.php";
}
if (!isset($inc)) {
    $inc = 'main';
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
if (file_exists($inc)) {
    include_once ($inc);
} else {
    include_once (INC_DIR . $inc . '.php');
}
echo $html['end'];
$include = $site_footer;
if (file_exists($include)) {
    include ($include);
}
?>