<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if (!$login) {
    die(LANG_ERROR_DENIED);
}
$err = array();
$warn = array();
if ($_SESSION['user']['type'] === 'client'):
    if (!empty($_POST['message'])) {
        $ticket = preg_replace('/\D+/', '', $_POST['id']);
        if (!is_array($_POST['message'])) $msg = $_POST['message'];
        $msgid = PostMessage($ticket, $msg, '', true, $_FILES, 'custreplied');
        if (mysql_error()) {
            $err[] = LANG_FAILED . ' ' . mysql_error();
        }
        if (is_array($msgid)) {
            $warn = $msgid;
        }
        if (empty($msgid)) {
            $err[] = LANG_ERROR_NOT_POSTED;
        }
        if (empty($err)) {
            header('Location: ' . $_SERVER['REQUEST_URI'] . '#end');
            die();
        }
    } elseif (isset($_POST['reopen'])) { 
        ReopenTicket($_GET['id']);
        $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
        header('Location: ' . $url);
    } else {
        $err = LANG_ERROR_MISSING_FIELDS;
    }
    $inc = 'viewticket';
endif;
if ($_SESSION['user']['type'] === 'admin'):
    if (isset($_POST['delete'])) {
        if (!empty($_POST['privid'])) {
            $id = $_POST['privid'];
            $id = preg_replace('/\D+/', '', $id); //sanitise
            $priv_res = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['privmsg'] . " WHERE ID='$id'"));
            if (($_SESSION['user']['id'] == $priv_row['rep']) || $login['ID'] == ADMIN) {
                mysql_query("DELETE FROM " . $db_table['privmsg'] . " WHERE ID=" . $id);
                if (!empty($priv_row['attachment'])) {
                    mysql_query("DELETE FROM " . $db_table['attachments'] . " WHERE filename=" . $priv_row['attachment']);
                    if (file_exists($db_settings['attachment_dir'] . $priv_row['attachment'])) {
                        @unlink($db_settings['attachment_dir'] . $priv_row['attachment']);
                    }
                }
                if (mysql_error()) {
                    $err[] = LANG_DELETE . ' ' . LANG_ERROR . ' : ' . mysql_error();
                }
            }
        } elseif ($login['delete'] || $login['ID'] == ADMIN) {
            $delete = DeleteTicket($_GET['id']);
            if (!empty($delete)) {
                $err[] = LANG_DELETE . ' ' . LANG_ERROR . ' ' . $_GET['id'] . " : $delete";
            } else {
                $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
                header('Location: ' . $url);
                die();
            }
        }
    } elseif (isset($_POST['hold'])) {
        $hold = HoldTicket($_GET['id']);
        $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
        header('Location: ' . $url);
        die();
    } elseif (isset($_POST['change_status'])) {
    	$query = mysql_query("UPDATE " . $db_table['tickets'] . " SET status='" . $_POST['newstatus'] . "' WHERE ID=" . $_GET['id']);
            if ($query) {
                $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
        		header('Location: ' . $url);
        		die();
            } else {
                $err = LANG_FAILED . ': ' . mysql_error();
            }       
    } elseif (isset($_POST['close'])) {
        $close = CloseTicket($_GET['id']);
        $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
        header('Location: ' . $url);
        die();
    } elseif (isset($_POST['submit'])) {
        $userid = $_SESSION['user']['id'];
        $reps_row = mysql_fetch_array(mysql_query("SELECT ID FROM " . $db_table['reps'] . " WHERE username='$userid'"));
        $id = preg_replace('/\D+/', '', $_REQUEST['id']); //sanitise
        $msgid = $id; //message ref id
        $msg_res = mysql_query("SELECT ticket FROM " . $db_table['messages'] . " WHERE ID='$msgid'");
        if ($msg_res) {
            $msg_row = mysql_fetch_array($msg_res);
            $id = $msg_row['ticket']; // ticket id
            
        }
        $repid = $reps_row['ID']; //rep id
        if ($_POST['priv']) {
            if (!empty($_POST['priv'])) {
                $msg = escape_string(htmlspecialchars($_POST['priv']));
            }
            if (!empty($_POST['message'])) {
                $msg = escape_string(htmlspecialchars($_POST['message']));
            }
            if ($_POST['tid']) {
                $ticket = $_POST['tid'];
            }
            $ticket = preg_replace('/\D+/', '', $ticket); //sanitise
            $privid = PostPrivMessage($ticket, $repid, $msg, $_FILES);
            if (mysql_error()) {
                $err[] = LANG_FAILED . ' ' . mysql_error();
            }
            if (is_array($privid)) {
                $warn = $privid;
            }
            if (empty($privid)) {
                $err[] = LANG_ERROR_NOT_POSTED;
            }
            $inc = 'viewticket';
        } else {
            //normal message
            if (empty($_POST['message'])) {
                $err[] = LANG_ERROR_MISSING_FIELDS;
            }
            if (empty($err)) {
                $ansid = PostAnswer($_POST['message'], $repid, $msgid, $_FILES, $_POST['newstatus']);
                if (mysql_error()) {
                    $err[] = LANG_FAILED . ' ' . mysql_error();
                }
                if (is_array($ansid)) {
                    $warn = $ansid;
                }
                if (empty($ansid)) {
                    $err[] = LANG_ERROR_NOT_POSTED;
                }
                if ($_POST['newstatus'] == "closed") {
                    CloseTicket($id);
                    $url = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
                    header('Location: ' . $url);
                    die();
                }
                $end = '#end';
                if (!empty($warn)) {
                    $_SESSION['user']['warn'] = $warn;
                    $end = '';
                }
                if (!empty($err)) {
                    $_SESSION['user']['warn'] = $err;
                    $end = '';
                }
                ob_clean();
                header('Location: ' . $_SERVER['REQUEST_URI'] . $end);
                die();
            }
        }
        if ($_POST['close']) {
            CloseTicket($id);
        }
    }
    $inc = 'viewticket';
endif;
?>