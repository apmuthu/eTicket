<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
$id = preg_replace('/\D+/', '', $_GET['id']); //sanitise
if ($res = mysql_query("SELECT * FROM " . $db_table['tickets'] . " WHERE ID=" . $id)) {
    if ($ticket_row = mysql_fetch_array($res)) {
        if ($ticket_row['cat']) {
            $cat_row = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['categories'] . " WHERE ID=" . $ticket_row['cat']));
        }
        if ($ticket_row['rep']) {
            $rep_row = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['reps'] . " WHERE ID=" . $ticket_row['rep']));
        }
    }
}
$show = $_SESSION['user']['type'] == 'admin' ? 1 : !$cat_row['hidden'];
$admin_permis = ($_SESSION['user']['type'] == 'admin' && (@in_array($cat_row['ID'], $login['cat_access']) || $login['cat_access']['0'] == 'all' || $login['ID'] == ADMIN));
$client_permis = ($_SESSION['user']['type'] == 'client' && strtolower($ticket_row['email']) == $_SESSION['user']['id']);
if (!$client_permis && !$admin_permis) {
    $error = LANG_ERROR_DENIED;
}
if (!$res || !mysql_num_rows($res)) {
    $error = LANG_ERROR_NOTFOUND;
}
if (isset($error)) {
    echo sprintf($html['error'], $error) . "\n";
    exit;
}
//get ticket details
$ticket = new ticket($ticket_row);
//priorities
if ($ticket->priority) {
    $pri = $ticket->priority ? $ticket->priority : 2;
    $pri = $db_settings['pri_text'][$pri];
    if ($_SESSION['user']['type'] === 'admin') {
        $tmp = '';
        $array = $db_settings['pri'];
        foreach($array as $key => $val) {
            $text = $db_settings['pri_text'][$val];
            $selected = ($val == $ticket->priority) ? ' SELECTED' : '';
            $tmp.= sprintf($html['option'], $val, $selected, $text) . "\n";
        }
        if (!empty($tmp)) {
            $pri = sprintf($html['viewticket']['pri_form'], $form_action, $ticket->id, $tmp);
        }
    }
}
/* start html */
$vars = array();
//reps
$tmp = '';
if (($_SESSION['user']['type'] === 'admin') && ($login['ID'] == ADMIN || $_SESSION['user']['ID'] === $rep_row['ID'] || !$ticket_row['rep'])) {
    $query = mysql_query("SELECT * FROM " . $db_table['reps']);
    while ($array = mysql_fetch_array($query)) {
        $selected = ($array['ID'] == $rep_row['ID']) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $array['ID'], $selected, $array['name'] . $hidden) . "\n";
    }
    if (!empty($tmp)) $vars['reps'] = $tmp;
}
//cats
$tmp = '';
if ($_SESSION['user']['type'] === 'admin') {
    $query = mysql_query("SELECT * FROM " . $db_table['categories']);
    while ($array = mysql_fetch_array($query)) {
        $selected = ($array['ID'] == $cat_row['ID']) ? ' SELECTED' : '';
        $hidden = $array['hidden'] ? '*' : '';
        $tmp.= sprintf($html['option'], $array['ID'], $selected, $array['name'] . $hidden) . "\n";
    }
    if (!empty($tmp)) $vars['cats'] = $tmp;
}
//private messages
$tmp = '';
if ($_SESSION['user']['type'] == 'admin') {
    $query = mysql_query("SELECT * FROM " . $db_table['privmsg'] . " WHERE ticket='$id'");
    while ($array = mysql_fetch_array($query)) {
        $rep = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['reps'] . " WHERE ID=" . $array['rep']));
        $datetime = format_time($db_settings['time_format'], time_convert($array['timestamp']));
        if ($array['attachment']) {
            $file = $db_settings['attachment_dir'] . $array['attachment'];
        }
        $attach = '';
        if (isset($file) && file_exists($file)) {
            $attachurl = $db_settings['attachment_url'] . '?file=' . urlencode($array['attachment']);
            $attach = htmlspecialchars($array['attachment']);
            $attach_extra = '(' . size_readable($file) . ')' . mp3_player($array['attachment']);
            $attach = sprintf($html['viewticket']['attach'], $attachurl, $attach, $attach_extra);
        }
        $delete = '';
        if (($_SESSION['user']['id'] == $array['rep']) || $login['ID'] == ADMIN) {
            $delete = $html['viewticket']['input_delete'];
        }
        $tmp.= sprintf($html['viewticket']['privmsgs'], $form_action, $ticket->id, $array['ID'], $rep['name'], $datetime, $delete, $attach, clean_input($array['message']));
    }
    if (!empty($tmp)) $vars['privmsg'] = $tmp;
} //endif session user type is admin
//get messages
$tmp = '';
$msg_res = mysql_query("SELECT * FROM " . $db_table['messages'] . " WHERE ticket=" . $ticket_row['ID'] . " ORDER BY timestamp");
while ($msg_row = mysql_fetch_array($msg_res)) {
    $datetime = format_time($db_settings['time_format'], time_convert($msg_row['timestamp']));
    //get file attachments
    $files = mysql_query("SELECT * FROM " . $db_table['attachments'] . " WHERE ref=" . $msg_row['ID'] . " AND type='q'");
    $fstr = array();
    while ($file = mysql_fetch_array($files)) {
        if (file_exists($db_settings['attachment_dir'] . $file['filename'])) {
            $size = size_readable($db_settings['attachment_dir'] . $file['filename']);
            //we no longer need to restrict this to admin only links
            $attachurl = $db_settings['attachment_url'] . '?file=' . urlencode($file['filename']);
            $attach_extra = " ($size) " . mp3_player($file['filename']);
            $fstr[] = sprintf($html['href'], $attachurl, htmlspecialchars($file['filename']), $attach_extra);
        }
    }
    if (!empty($fstr)) {
        $fstr = implode(' ; ', $fstr);
        $fstr = sprintf($html['viewticket']['attachment'], $fstr) . "\n";
    }
    if (empty($fstr)) {
        $fstr = '';
    }
    if ($msg_row['headers'] && $_SESSION['user']['type'] == 'admin') {
        $fstr = sprintf($html['viewticket']['headers'], $msg_row['ID']) . "\n" . $fstr;
    }
    if (!empty($fstr)) {
        $fstr = sprintf($html['viewticket']['msgattach'], $fstr) . "\n";
    } else {
        $fstr = '';
    }
    $msg = $msg_row['message'];
    $msg = str_replace("\'", "'", $msg); //replaces stripslashes, bug #1721308
    $msg = clean_input($msg);
    $tmp.= sprintf($html['viewticket']['msgreceived'], $datetime, $fstr, $msg);
    //get answers for messages
    $answers_res = mysql_query("SELECT * FROM " . $db_table['answers'] . " WHERE reference=" . $msg_row['ID'] . " ORDER BY timestamp");
    while ($answer_row = mysql_fetch_array($answers_res)) {
        $rep = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['reps'] . " WHERE ID=" . $answer_row['rep']));
        $datetime = format_time($db_settings['time_format'], time_convert($answer_row['timestamp']));
        //get file attachments
        $files = mysql_query("SELECT * FROM " . $db_table['attachments'] . " WHERE ref=" . $answer_row['ID'] . " AND type='a'");
        $fstr = array();
        while ($file = mysql_fetch_array($files)) {
            if (file_exists($db_settings['attachment_dir'] . $file['filename'])) {
                $size = size_readable($db_settings['attachment_dir'] . $file['filename']);
                $attachurl = $db_settings['attachment_url'] . '?file=' . urlencode($file['filename']);
                $attach_extra = " ($size) " . mp3_player($file['filename']);
                $fstr[] = sprintf($html['href'], $attachurl, htmlspecialchars($file['filename']), $attach_extra);
            }
        }
        if (!empty($fstr)) {
            $fstr = implode(' ; ', $fstr);
            $fstr = sprintf($html['viewticket']['attachment'], $fstr) . "\n";
        } else {
            $fstr = '';
        }
        if (!empty($fstr)) {
            $fstr = sprintf($html['viewticket']['msgattach'], $fstr) . "\n";
        }
        $msg = $answer_row['message'];
        $msg = str_replace("\'", "'", $msg); //replaces stripslashes, bug #1721308
        $msg = clean_input($msg);
        $tmp.= sprintf($html['viewticket']['msganswered'], $rep['name'], $datetime, $fstr, $msg);
    } //end while answers
    if ($_SESSION['user']['type'] === 'admin') {
        $lastid = $msg_row['ID'];
    }
} //end while messages
$vars['messages'] = '';
if (!empty($tmp)) $vars['messages'] = $tmp;
if (empty($lastid)) {
    $lastid = $ticket_row['ID'];
}
//Predefined answer responses
$tmp = '';
if ((!empty($db_settings['predef_answers'])) && ($_SESSION['user']['type'] === 'admin')) {
    foreach($db_settings['predef_answers'] as $key => $value) {
        $name = htmlspecialchars($ticket->name);
        $firstname = substr($firstname, 0, strpos($firstname, ' '));
        $value = str_replace('%name', $name, $value);
        $value = str_replace('%firstname', $firstname ? $firstname : $name, $value);
        $tmp.= sprintf($html['option'], htmlspecialchars($value), '', htmlspecialchars($key)) . "\n";
    }
    if (!empty($tmp)) $vars['predef'] = $tmp;
}
$vars['backurl'] = $_SESSION['view']['qs'] ? $page . '?' . $_SESSION['view']['qs'] : $page;
// Claim This Ticket button
$include = INC_DIR . 'claim.php';
if (file_exists($include)) {
    include_once ($include);
}
include_once ($themes_dir . $db_settings['theme'] . '/' . '/viewticket.html.php');
?>
