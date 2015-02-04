<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
$err = '';
if ($login[$a] || $login['ID'] == ADMIN) {
    $_POST['r_id'] = (int)$_POST['r_id'];
    if ($_POST['submit']) {
        if (empty($_POST['username'])) {
            $err.= LANG_ERROR_MISSING_FIELDS . ' (username)<br>';
        }
        if (empty($_POST['name'])) {
            $err.= LANG_ERROR_MISSING_FIELDS . ' (name)<br>';
        }
        if (empty($_POST['email'])) {
            $err.= LANG_ERROR_MISSING_FIELDS . ' (email)<br>';
        }
        if (empty($_POST['group'])) {
            $err.= LANG_ERROR_MISSING_FIELDS . ' (group)<br>';
        }
        $sql = sprintf("SELECT * FROM %s WHERE username='%s'", $db_table['reps'], mysql_real_escape_string($_POST['username']));
        $usercheck = mysql_fetch_array(mysql_query($sql));
        if ($usercheck['username'] && $_POST['username'] !== $_POST['old_username']) {
            $err.= LANG_ERROR_REP_USER_EXISTS . '<br>';
        }
        $sql = sprintf("SELECT * FROM %s WHERE name='%s'", $db_table['reps'], mysql_real_escape_string($_POST['name']));
        $namecheck = mysql_fetch_array(mysql_query($sql));
        if ($namecheck['name'] && $_POST['name'] !== $_POST['old_name']) {
            $err.= LANG_ERROR_NAME_EXISTS . '<br>';
        }
        if (!$err) {
            $password = $_POST['password'] ? md5($_POST['password']) : $_POST['password_hash'];
            $password = str_replace('*LOCKED*', '', $password);
            if ($_POST['locked'] == 'on') {
                $password = '*LOCKED*' . $password;
            }
            if ($_POST['nomail'] == 'on') {
                $_POST['email'] = ':' . $_POST['email'];
            }
            $data = array('username' => $_POST['username'], 'name' => $_POST['name'], 'email' => $_POST['email'], 'password' => $password, 'signature' => $_POST['sig'], 'user_group' => $_POST['group']);
            $w = array('ID' => $_POST['r_id']);
            $sql = mysql_build_query('update', $db_table['reps'], $data, $w);
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
        } else {
            $err.= LANG_FIX_ABOVE_ERRORS;
        }
    } elseif ($_POST['delete']) {
        $rnum = mysql_num_rows(mysql_query("SELECT * FROM " . $db_table['reps']));
        if ($rnum == 1) {
            $err = LANG_ERROR_ONE_REP;
        }
        if (!$err) {
            $sql = sprintf("DELETE FROM %s WHERE ID=%s", $db_table['reps'], mysql_real_escape_string($_POST['r_id']));
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
        }
    } elseif ($_POST['add']) {
        if (!$_POST['name'] || !$_POST['email'] || !$_POST['username'] || !$_POST['password'] || !$_POST['group']) {
            $err.= LANG_ERROR_MISSING_FIELDS . '<br>';
        }
        $sql = sprintf("SELECT * FROM %s WHERE username='%s'", $db_table['reps'], mysql_real_escape_string($_POST['username']));
        $usercheck = mysql_fetch_array(mysql_query($sql));
        if ($usercheck['name']) {
            $err.= LANG_ERROR_REP_USER_EXISTS . '<br>';
        }
        if (!$err) {
            $password = $_POST['password'] ? md5($_POST['password']) : $_POST['password_hash'];
            $password = str_replace('*LOCKED*', '', $password);
            if ($_POST['locked'] == 'on') {
                $password = '*LOCKED*' . $password;
            }
            if ($_POST['nomail'] == 'on') {
                $_POST['email'] = ':' . $_POST['email'];
            }
            $data = array('username' => $_POST['username'], 'name' => $_POST['name'], 'email' => $_POST['email'], 'password' => $password, 'signature' => $_POST['sig'], 'user_group' => $_POST['group']);
            $sql = mysql_build_query('insert', $db_table['reps'], $data);
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
            $_POST['r_id'] = mysql_insert_id(); // select rep created
            
        }
    }
    $inc = 'admin_rep.html';
}
/* for html */
$vars = array();
$vars['r_id'] = (int)$_POST['r_id'];
$vars['submit_new'] = isset($_POST['submit_new']) ? 1 : 0;
if ((!empty($vars['r_id'])) && ($vars['submit_new'] == 0)) {
    $rep = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['reps'] . " WHERE ID=" . $vars['r_id']));
    if (substr($rep['password'], 0, 8) === '*LOCKED*') {
        $rep['locked'] = ' checked';
    }
    if ($rep['email'][0] === ':') {
        $rep['nomail'] = ' checked';
        $rep['email'] = substr($rep['email'], 1, strlen($rep['email']));
    }
    if (is_array($rep)) {
        $vars = array_merge($vars, $rep);
    }
}
$vars['submit_type'] = $rep ? 1 : 0;
$vars['submit_name'] = $vars['submit_type'] ? 'submit' : 'add';
$vars['submit_value'] = $vars['submit_type'] ? LANG_SAVE_CHANGES : LANG_CREATE_REP;
//rep_options
$tmp = '';
$query = mysql_query("SELECT * FROM " . $db_table['reps']);
while ($array = mysql_fetch_array($query)) {
    $selected = ($array['ID'] == $vars['r_id']) ? ' SELECTED' : '';
    $tmp.= sprintf($html['option'], $array['ID'], $selected, $array['name']) . "\n";
}
$vars['reps'] = $tmp;
//group_options
$tmp = '';
$query = mysql_query("SELECT * FROM " . $db_table['groups']);
while ($array = mysql_fetch_array($query)) {
    $selected = ($array['ID'] == $rep['user_group']) ? ' SELECTED' : '';
    $tmp.= sprintf($html['option'], $array['ID'], $selected, $array['name']) . "\n";
}
$vars['groups'] = $tmp;
?>
