<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
$err = array();
$warn = array();
if ((empty($_POST['message'])) && ($_SESSION['user']['type'] == 'admin')) {
    $_POST['message'] = LANG_NEW_TICKET_MSG;
}
if (isset($_POST['submit_x'])) {
    /* Input Error Checking */
    $email_confirm = $login ? $_POST['email'] : $_POST['email_confirm'];
    if (!$_POST['subject']) {
        $err[] = LANG_ERROR_NO_SUBJECT;
    }
    if (!is_email($_POST['email'])) {
        $err[] = LANG_ERROR_INVALID_EMAIL;
    }
    if ($_POST['email'] != $email_confirm) {
        $err[] = LANG_ERROR_EMAIL_NOMATCH;
    }
    if (!$_POST['name']) {
        $err[] = LANG_ERROR_NO_NAME;
    }
    if (!$_POST['message']) {
        $err[] = LANG_ERROR_NO_MSG;
    }
    if ((file_exists('captcha/' . $db_settings['captcha_file'])) && ($_SESSION['user']['type'] != 'admin') && $db_settings['accept_captcha'] == 1) {
        if (md5($_POST['captcha_input']) != $_SESSION['captcha_hash']) {
            $err[] = LANG_ERROR_CAPTCHA;
        }
    }
    if ($_SESSION['user']['type'] == 'client') {
        $sql_email = escape_string($_POST['email']);
        $c = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS cnt FROM ". $db_table['tickets'] ." WHERE email=" . $sql_email . " AND status != 'closed'"));
        if ($c['cnt'] > $db_settings['ticket_max']) {
            $limit_msg = $db_settings['limit_msg'];
            $limit_msg = str_replace('%url', $db_settings['root_url'], $limit_msg);
            $limit_msg = str_replace('%local_email', $cat_row['email'], $limit_msg);
            $limit_msg = str_replace('%user_email', $_POST['email'], $limit_msg);
            $limit_msg = str_replace('%ticket_max', $db_settings['ticket_max'], $limit_msg);
            $err[] = $limit_msg;
            unset($limit_msg);
        }
    }
    if (empty($err)) {
        $message = $_POST['message'];
        // for the extra fields
        if (isset($_POST['e'])) {
            foreach($_POST['e'] as $key => $val) {
                $message.= "\n$key: $val";
            }
        }
        // cleanup client name field (delete HTML injection)
        $client_name = strip_tags($_POST['name']);
        $client_name = htmlspecialchars($client_name);
        if ((!empty($_POST['answer'])) && ($_SESSION['user']['type'] == 'admin')) {
            $answer = $_POST['answer'];
        }
        $ticket = CreateTicket($_POST['subject'], $client_name, $_POST['email'], $_POST['cat'], $_POST['phone'], $_POST['pri'], $_SERVER['REMOTE_ADDR'], $message, !$answer);
        if (!is_numeric($ticket)) {
            $err[] = LANG_FAILED . ': ' . LANG_OPEN_TICKET . ' ' . $ticket;
        }
        $files = $answer ? false : $_FILES; //if an answer, don't include files in the PostMessage, else do.
        
        if ($answer) {
            $msgid = PostMessage($ticket, $message, '', false, $files, 'awaitingcustomer');
        } else {
            $msgid = PostMessage($ticket, $message, '', false, $files, 'new');
        }    
        if (mysql_error()) {
            $err[] = LANG_FAILED . ': ' . LANG_MSG . ' ' . mysql_error();
        }
        if (!is_numeric($msgid)) {
            $err[] = LANG_FAILED . ' ' . LANG_MSG . ' ' . $msgid;
        }
        if (is_array($msgid)) {
            $warn = $msgid;
        }
        if (empty($msgid)) {
            $err[] = LANG_ERROR_NOT_POSTED;
        }
        if (!empty($answer)) {
            $userid = $_SESSION['user']['id'];
            $reps_row = mysql_fetch_array(mysql_query("SELECT ID,signature FROM " . $db_table['reps'] . " WHERE username='$userid'"));
            $repid = $reps_row['ID'];
            $ansid = PostAnswer($answer, $repid, $msgid, $_FILES, 'awaitingcustomer');
            if (mysql_error()) {
                $err[] = LANG_FAILED . ' ' . LANG_ANSWER . ' ' . mysql_error();
            }
            if (!is_numeric($ansid)) {
                $err[] = LANG_FAILED . ' ' . LANG_ANSWER . ' ' . $ansid;
            }
            if (is_array($ansid)) {
                $warn = $ansid;
            }
            if (empty($ansid)) {
                $err[] = LANG_ERROR_NOT_POSTED;
            }
        }
    }
    if (empty($err)) {
        if ($login) {
            $_SESSION['view']['status'] = 'new';
            if (!defined('NO_REDIRECT')) {
                if ($_SESSION['user']['type'] == 'admin') {
                    header("Location: $page?a=view&id=$ticket");
                    die();
                } else {
                    $warn = LANG_OPENED_TICKET_MSG;
                    header('Location: ' . $page);
                    die();
                }
            }
        }
        if ($_SESSION['user']['type'] == 'admin') {
            $submitmsg = sprintf($html['open']['submitmsg'], "$page?a=view&id=$ticket", LANG_TITLE_VIEWTICKET);
        } else {
            $submitmsg = sprintf($html['open']['submitmsg'], "$page?e=$_POST[email]&t=$ticket", LANG_VIEW_OPEN);
        }
    } elseif (mysql_error()) {
        $err[] = LANG_FAILED . ': ' . mysql_error();
    }
    if (!empty($warn)) {
        $_SESSION['user']['warn'] = $warn;
    }
    if (!empty($err)) {
        $_SESSION['user']['err'] = $err;
    }
}
?>
