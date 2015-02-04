<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
if ($_POST['submit']) {
    $fields = array('name', 'email', 'password', 'username');
    foreach($fields as $field) {
        if ($_POST[$field] == '') {
            $err[] = LANG_ERROR_MISSING_FIELDS . " ($field)";
        }
    }
    $username = $_SESSION['user']['id'];
    $password = md5($_POST['password']);
    $sql = sprintf("SELECT * FROM %s WHERE username='%s' AND password='%s'", $db_table['reps'], mysql_real_escape_string($_SESSION['user']['id']), mysql_real_escape_string($password));
    $passcheck = mysql_fetch_array(mysql_query($sql));
    if (!$passcheck['ID']) {
        $err[] = LANG_ERROR_INVALID_PASS;
    }
    $sql = sprintf("SELECT * FROM %s WHERE username='%s'", $db_table['reps'], mysql_real_escape_string($_SESSION['user']['id']));
    $usercheck = mysql_fetch_array(mysql_query($sql));
    if ($_POST['npassword'] !== $_POST['vpassword']) {
        $err[] = LANG_ERROR_PASSWORD_NOMATCH;
    }
    if ($usercheck['ID'] && ($_POST['username'] !== $_SESSION['user']['id'])) {
        $err[] = LANG_ERROR_USER_EXISTS;
    }
    if (!$err) {
        if (!empty($_POST['npassword'])) {
            $_SESSION['user']['pass'] = md5($_POST['npassword']);
        }
        $_SESSION['user']['id'] = $_POST['username'];
        if (isset($_POST['nomail'])) {
            $_POST['email'] = ':' . $_POST['email'];
        }
        $data = array('name' => $_POST['name'], 'email' => $_POST['email'], 'username' => $_SESSION['user']['id'], 'password' => $_SESSION['user']['pass'], 'signature' => $_POST['sig']);
        $w = array('username' => $_SESSION['user']['id']);
        $sql = mysql_build_query('update', $db_table['reps'], $data, $w);
        mysql_query($sql);
        if (mysql_error()) {
            $err.= LANG_FAILED . ' ' . mysql_error();
        }
    }
}
$vars = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['reps'] . " WHERE username='" . $_SESSION['user']['id'] . "'"));
if ($vars['email'][0] == ':') {
    $vars['nomail'] = ' checked';
    $vars['email'] = substr($vars['email'], 1, strlen($vars['email']));
}
$inc = 'admin_my.html';
?>