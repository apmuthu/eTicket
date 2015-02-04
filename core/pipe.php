#!/usr/local/bin/php
<?php
ob_start();
require_once ('init.php');
require_once ('inc/class.parsemail.php');
$incoming = fopen("php://stdin", "r");
while (!feof($incoming)) {
    $email.= fread($incoming, 1024);
}
fclose($incoming);
$parse = new Parser($email);
if ($parse->message['html']) {
    $body = strip_tags($parse->message['html']);
} elseif ($parse->message['plain']) {
    $body = $parse->message['plain'];
} else {
    $body = $parse->plain;
}
$banlist = array();
$ban_res = mysql_query("SELECT * FROM " . $db_table['banlist']);
while ($ban_row = mysql_fetch_array($ban_res)) {
    $banlist[] = $ban_row['value'];
}
$email = str_replace("'", "", $parse->from);
$name = '';
if (strpos($email, '<')) {
    $email = eregi_replace('.*<(.*)>.*', '\\1', $email);
}
if (preg_match("/^(?:(.*?)[ ]?)?<(.*?)>|(.*?)$/", $parse->from, $matches)) {
    if ($email == '') $email = $matches[2] . $matches[3];
    $name = $matches[1];
    if (preg_match("/^\".+\"$/i", $name)) $name = substr($name, 1, -1);
}
if (preg_match("/^(?:(.*?)[ ]?)?<(.*?)>|(.*?)$/", $parse->to, $matches)) {
    if ($toemail == '') $toemail = $matches[2] . $matches[3];
    $toname = $matches[1];
}
if ($name == '') {
    $name = $email;
}
$banned = 0;
foreach($banlist as $banline) {
    if (!empty($banline)) {
        if (stristr($parse->from, $banline)) {
            $banned = 1;
        }
        if (stristr($parse->subject, $banline)) {
            $banned = 1;
        }
        if (stristr($body, $banline)) {
            $banned = 1;
        }
    }
}


if (eregi('^Yes', $parse->spam)) {
    $stopmessage = 1;
}

if ($parse->returnpath == "<>") {
    $stopmessage = 1;
}

if ($parse->autosubmitted == "auto-generated") {
    $stopmessage = 1;
} elseif ($parse->autosubmitted == "auto-replied") {
    $stopmessage = 1;
}

if ($stopmessage == 1 or $banned == 1) {
    ob_clean();
    exit();
}    

if ($parse->importance == "high") {
    $pri = 3;
} elseif ($parse->importance == "low") {
    $pri = 1;
} elseif ($parse->priority == 1 or $parse->priority == 2) {
    $pri = 1;
} elseif ($parse->priority == 4 or $parse->priority == 5) {
    $pri = 3;
} else {
    $pri = 2;
}

if ($db_settings['remove_original'] && $db_settings['remove_tag'] && strpos($body, $db_settings['remove_tag'])) {
    preg_match('/(.+?)>? ?' . $db_settings['remove_tag'] . '.+/s', $body, $matches);
    if (!empty($matches[1])) $body = $matches[1];
}
$body = trim($body);
$c = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `$db_table_tickets` WHERE `email`='$email' AND `status`!='closed';"));
if ($c['cnt'] >= $db_settings['ticket_max']) {
    $limit_msg = str_replace('%url', $db_settings['root_url'], $db_settings['limit_msg']);
    $limit_msg = str_replace('%local_email', $cat_row['email'], $limit_msg);
    $limit_msg = str_replace('%user_email', $email, $limit_msg);
    $limit_msg = str_replace('%ticket_max', $db_settings['ticket_max'], $limit_msg);
    if ($db_settings['limit_response']) {
        send_mail($email, $db_settings['limit_subj'], $limit_msg, $db_settings['limit_email'], FALSE, $pri);
    }
    ob_clean();
    exit();
}
unset($ticket_id);
unset($send_notice);
if (preg_match("/$db_settings[ticket_format]/", $parse->subject, $matches)) {
    $id = trim($matches[1]);
    if (ValidID($id)) {
        $ticket_id = $id;
    }
    $send_notice = TRUE;
}
$cat_res = mysql_query("SELECT * FROM " . $db_table['categories'] . " WHERE email='" . $toemail . "'");
$cat_row = mysql_fetch_array($cat_res);
if ($cat_row['email'] != $email) {
    if (empty($ticket_id)) {
        $ticket_id = CreateTicket($parse->subject, $name, $email, $cat_row['ID'], '', $pri, $ip, $body);
        $send_notice = FALSE; //a notice is already sent by CreateTicket
        $iid = PostMessage($ticket_id, $body, $parse->header, $send_notice, 'new');
    } else {
        $iid = PostMessage($ticket_id, $body, $parse->header, $send_notice, 'custreplied');
    }
}
if (is_dir($db_settings['attachment_dir']) && $db_settings['accept_attachments']) {
    foreach($parse->files as $key) {
        $filetypes = explode(';', $db_settings['filetypes']);
        if (in_array("." . $key[ext], $filetypes)) {
            if (!$db_settings['attachment_size'] || (strlen($key['content']) <= $db_settings['attachment_size'])) {
                mt_srand(time());
                $rand = mt_rand(100000, 999999); //six chars.
                $destfile = $rand . '_' . $key['base_name'] . "." . $key['ext'];
                $dest = $db_settings['attachment_dir'] . $destfile;
                $ifp = fopen($dest, "wb");
                fwrite($ifp, $key['content']);
                fclose($ifp);
                $sql = "INSERT INTO " . $db_table['attachments'] . " (ticket, ref, filename, type) VALUES (" . $ticket_id . ", " . $iid . ", '" . $rand . "_" . $key[base_name] . "." . $key[ext] . "', 'q')";
                mysql_query($sql);
            }
        }
    }
}
ob_clean();
exit();
?>