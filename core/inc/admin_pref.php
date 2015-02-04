<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
if ($login[$a] || $login['ID'] == ADMIN) {
    if ($_POST['submitpref']) {
        $sqls = array();
        if ($_POST['accept_attachments']) {
            if (!(is_writable($db_settings['attachment_dir'])) && (file_exists($db_settings['attachment_dir']))) {
                unset($db_settings['accept_attachments']);
                $inc = 'pref';
            }
        }
        $_POST['accept_captcha'] = isset($_POST['accept_captcha']) ? 1 : 0;
        $_POST['accept_attachments'] = isset($_POST['accept_attachments']) ? 1 : 0;
        $_POST['search_disp'] = isset($_POST['search_disp']) ? 1 : 0;
        $_POST['remove_original'] = isset($_POST['remove_original']) ? 1 : 0;
        $_POST['save_headers'] = isset($_POST['save_headers']) ? 1 : 0;
        $_POST['force_category'] = isset($_POST['force_category']) ? 1 : 0;
        $_POST['smtp_auth'] = isset($_POST['smtp_auth']) ? 1 : 0;
        $_POST['show_badge'] = isset($_POST['show_badge']) ? 1 : 0;
        $sqls = array();
        //normal keys for settings
        $query = @mysql_query("SELECT `key` FROM `" . $db_table['settings'] . "` WHERE `group`='' OR `group` IS NULL");
        if ($query) {
            while ($keys = mysql_fetch_array($query)) {
                $key = $keys['key'];
                if (isset($_POST[$key])) $sqls[] = "UPDATE " . $db_table['settings'] . " SET VALUE = " . escape_string($_POST[$key]) . " WHERE `key` = '" . $key . "' LIMIT 1;";
            }
        }
        if (!empty($sqls)) {
            if (mysql_error()) {
                $err[] = LANG_FAILED . ': ' . mysql_error();
            }
            foreach($sqls as $sql) {
                if (!mysql_query($sql)) {
                    $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
                }
            }
        }
        if (empty($err)) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        }
    } elseif ($_POST['remove_filetype'] && $_POST['filetypes']) {
        $sql = "UPDATE " . $db_table['settings'] . " SET value = REPLACE(value, " . escape_string($_POST['filetypes'] . ';') . ", '') WHERE `key` = 'filetypes'";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        if (empty($err)) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        }
    } elseif ($_POST['add_filetype'] && $_POST['ext']) {
        $ext = $_POST['ext'];
        if ($ext{0} != '.') {
            $ext = '.' . $ext;
        }
        $sql = "UPDATE " . $db_table['settings'] . " SET value = CONCAT(value, '$ext;') WHERE `key` = 'filetypes'";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        if (empty($err)) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        }
    } elseif ($_POST['answer_add']) { //button submit
        $group = escape_string('predef_answers');
        $value = escape_string($_POST['answer_value']);
        $key = escape_string($_POST['answer_key']);
        $sql = "INSERT INTO " . $db_table['settings'] . " (`group`,`key`,`value`) VALUES (" . $group . "," . $key . "," . $value . ");";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        $db_settings['predef_answers'][$_POST['answer_key']] = $_POST['answer_value'];
        $_POST['answer'] = $_POST['answer_key'];
    } elseif ($_POST['answer_save']) { //button submit
        $group = 'predef_answers';
        $value = escape_string($_POST['answer_value']);
        $key = escape_string($_POST['answer']);
        $sql = "UPDATE `" . $db_table['settings'] . "` SET `value` = " . $value . " WHERE `key` = " . $key . " AND `group` = '" . $group . "' LIMIT 1;";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        $db_settings['predef_answers'][$_POST['answer']] = $_POST['answer_value'];
    } elseif ($_POST['answer_remove']) { //button submit
        $group = 'predef_answers';
        $key = escape_string($_POST['answer']);
        $sql = "DELETE FROM `" . $db_table['settings'] . "` WHERE `key` = " . $key . " AND `group` = '" . $group . "' LIMIT 1";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        if (empty($err)) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die();
        }
    } elseif ($_POST['pri_save']) { //button submit
        $key = (string)escape_string($_POST['pri']);
        $group = 'pri_text';
        $value = escape_string($_POST[$group]);
        $sql = "UPDATE `" . $db_table['settings'] . "` SET `value` = " . $value . " WHERE `key` = " . $key . " AND `group` = '" . $group . "' LIMIT 1;";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        $db_settings['pri_text'][(string)$db_settings['pri'][$_POST['pri']]] = stripslashes($_POST['pri_text']);
        $group = 'pri_style';
        $value = escape_string($_POST[$group]);
        $sql = "UPDATE `" . $db_table['settings'] . "` SET `value` = " . $value . " WHERE `key` = " . $key . " AND `group` = '" . $group . "' LIMIT 1;";
        if (!mysql_query($sql)) {
            $err[] = LANG_FAILED . ': ' . mysql_error() . " :<br>\n $sql";
        }
        $db_settings['pri_style'][(string)$db_settings['pri'][$_POST['pri']]] = stripslashes($_POST['pri_style']);
    }
    $inc = 'admin_pref.html';
}
/* html start */
//filetypes
$array = explode(';', $db_settings['filetypes']);
$tmp = '';
if (!empty($array)) {
    foreach($array as $key => $val) {
        if (!empty($val)) {
            $tmp.= sprintf($html['option'], $val, '', $val) . "\n";
        }
    }
}
$vars['filetypes'] = $tmp;
//timezones
if ($timezones) {
    $array = $timezones;
}
$tmp = '';
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($db_settings['timezone'] == $key) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $key, $selected, $val) . "\n";
    }
}
$vars['timezones'] = $tmp;
//tickets per page
$array = array(5, 10, 15, 20, 25, 50, 100);
$tmp = '';
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($db_settings['tickets_per_page'] == $val) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $val, $selected, $val) . "\n";
    }
}
$vars['tickets_per_page'] = $tmp;
//predef_answers
$tmp = '';
if ($db_settings['predef_answers']) {
    $array = $db_settings['predef_answers'];
}
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($_POST['answer'] == $key) ? ' SELECTED' : '';
        $key = htmlspecialchars($key);
        $tmp.= sprintf($html['option'], $key, $selected, $key) . "\n";
    }
}
$vars['predef_answers'] = $tmp;
//pri text/pri style
$tmp = '';
$pri = $db_settings['pri'][(string)$_POST['pri']];
if ($db_settings['pri']) {
    $array = $db_settings['pri'];
}
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($pri == $val) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $key, $selected, $val) . "\n";
    }
}
$vars['pri'] = $tmp;
$vars['pri_text'] = $pri ? htmlspecialchars($db_settings['pri_text'][$pri]) : '';
$vars['pri_style'] = $pri ? htmlspecialchars($db_settings['pri_style'][$pri]) : '';
$array = getdirs($themes_dir);
$tmp = '';
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($db_settings['theme'] == $val) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $val, $selected, $val) . "\n";
    }
}
$vars['themes'] = $tmp;

// Default Category
$cats = mysql_query("SELECT * FROM " . $db_table['categories'] . " WHERE NOT hidden");
while ($cat = mysql_fetch_array($cats)) {
    $selected = ($db_settings['default_category'] == $cat['ID']) ? ' SELECTED' : '';
    $hidden = ($cat['hidden']) ? '*' : '';
    $vars['default_category'].= sprintf($html['open_form']['options'], $cat['ID'], $selected, $cat['name']);
}

// Update check
$array = array(0 => 'Daily', 1 => 'Weekly', 2 => 'Monthly');
$tmp = '';
if (!empty($array)) {
    foreach($array as $key => $val) {
        $selected = ($db_settings['upgrade_check'] == $key) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $key, $selected, $val) . "\n";
    }
}
$vars['upgrade_check'] = $tmp;
/* html end */
?>
