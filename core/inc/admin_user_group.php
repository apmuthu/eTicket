<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
$err = '';
if ($login[$a] || $login['ID'] == ADMIN) {
    $_POST['g_id'] = (int)$_POST['g_id'];
    if ($_POST['submit']) {
        if ($_POST['g_id'] == ADMIN) {
            $err.= LANG_ERROR_ADMIN_GROUP_NOMOD . '<br>';
        }
        if (!$_POST['name']) {
            $err.= LANG_ERROR_MISSING_FIELDS . '<br>';
        }
        $sql = sprintf("SELECT * FROM %s WHERE name='%s'", $db_table['groups'], mysql_real_escape_string($_POST['name']));
        $namecheck = mysql_fetch_array(mysql_query($sql));
        if ($namecheck['name'] && ($_POST['name'] !== $_POST['old_name'])) {
            $err.= LANG_ERROR_GROUP_EXISTS . '<br>';
        }
        if (!$err) {
            $_POST['rep'] = isset($_POST['rep']) ? 1 : 0;
            $_POST['cat'] = isset($_POST['cat']) ? 1 : 0;
            $_POST['group'] = isset($_POST['group']) ? 1 : 0;
            $_POST['pref'] = isset($_POST['pref']) ? 1 : 0;
            $_POST['mail'] = isset($_POST['mail']) ? 1 : 0;
            $_POST['banlist'] = isset($_POST['banlist']) ? 1 : 0;
            $_POST['db'] = isset($_POST['db']) ? 1 : 0;
            if (isset($_POST['cat_access'])) {
                if ($_POST['cat_access']['all']) {
                    $ca = 'all';
                } else {
                    foreach($_POST['cat_access'] as $id => $val) {
                        $id = escape_string($id, false);
                        if (!empty($val)) {
                            $ca[] = $id;
                        }
                    }
                    if ($ca) $ca = implode(':', $ca);
                }
            }
            $data = array('name' => $_POST['name'], 'rep' => $_POST['rep'], 'cat' => $_POST['cat'], 'user_group' => $_POST['group'], 'pref' => $_POST['pref'], 'mail' => $_POST['mail'], 'banlist' => $_POST['banlist'], 'db' => $_POST['db'], 'cat_access' => $ca);
            $w = array('ID' => $_POST['g_id']);
            $sql = mysql_build_query('update', $db_table['groups'], $data, $w);
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
        }
    } elseif ($_POST['delete']) {
        if ($_POST['g_id'] == ADMIN) {
            $err.= LANG_ERROR_ADMIN_GROUP_NODEL . '<br>';
        }
        if ($login['ID'] == $_POST['g_id']) {
            $err.= LANG_ERROR_GROUP_INUSE . '<br>';
        }
        if (!$err) {
            $sql = sprintf("DELETE FROM %s WHERE ID=%s", $db_table['groups'], mysql_real_escape_string($_POST['g_id']));
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
        }
    } elseif ($_POST['add']) {
        if (!$_POST['name']) {
            $err.= LANG_ERROR_MISSING_FIELDS . '<br>';
        }
        $sql = sprintf("SELECT * FROM %s WHERE name='%s'", $db_table['groups'], mysql_real_escape_string($_POST['name']));
        $namecheck = mysql_fetch_array(mysql_query($sql));
        if ($namecheck['name']) {
            $err.= LANG_ERROR_GROUP_EXISTS . '<br>';
        }
        if (!$err) {
            $_POST['rep'] = isset($_POST['rep']) ? 1 : 0;
            $_POST['cat'] = isset($_POST['cat']) ? 1 : 0;
            $_POST['group'] = isset($_POST['group']) ? 1 : 0;
            $_POST['pref'] = isset($_POST['pref']) ? 1 : 0;
            $_POST['mail'] = isset($_POST['mail']) ? 1 : 0;
            $_POST['banlist'] = isset($_POST['banlist']) ? 1 : 0;
            $_POST['db'] = isset($_POST['db']) ? 1 : 0;
            if (isset($_POST['cat_access'])) {
                if ($_POST['cat_access']['all']) {
                    $ca = 'all';
                } else {
                    foreach($_POST['cat_access'] as $id => $val) {
                        if ($val == 'on') {
                            $ca[] = $id;
                        }
                    }
                    if ($ca) $ca = implode(':', $ca);
                }
            }
            $data = array('name' => $_POST['name'], 'rep' => $_POST['rep'], 'cat' => $_POST['cat'], 'user_group' => $_POST['group'], 'pref' => $_POST['pref'], 'mail' => $_POST['mail'], 'banlist' => $_POST['banlist'], 'db' => $_POST['db'], 'cat_access' => $ca);
            $sql = mysql_build_query('insert', $db_table['groups'], $data);
            mysql_query($sql);
            if (mysql_error()) {
                $err.= LANG_FAILED . ' ' . mysql_error();
            }
            $_POST['g_id'] = mysql_insert_id(); // select group created
            
        }
    }
    $inc = 'admin_user_group.html';
}
/* html */
$vars = array();
$vars['g_id'] = preg_replace('/\D+/', '', $_POST['g_id']);
$vars['submit_new'] = isset($_POST['submit_new']) ? 1 : 0;
$query = mysql_query("SELECT * FROM " . $db_table['groups']);
$tmp = '';
while ($data = mysql_fetch_array($query)) {
    $selected = ($data['ID'] == $vars['g_id']) ? ' SELECTED' : '';
    $tmp.= sprintf($html['option'], $data['ID'], $selected, $data['name']) . "\n";
}
$vars['groups'] = $tmp;
$vars['access_cats'] = array();
if ((!empty($vars['g_id'])) && ($vars['submit_new'] == 0)) {
    $group = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['groups'] . " WHERE ID=" . $vars['g_id']));
    $group['access_cats'] = explode(':', $group['cat_access']);
    if (is_array($group)) {
        $vars = array_merge($vars, $group);
    }
}
$vars['submit_type'] = $group ? 1 : 0;
$vars['submit_name'] = $vars['submit_type'] ? 'submit' : 'add';
$vars['submit_value'] = $vars['submit_type'] ? LANG_SAVE_CHANGES : LANG_CREATE_USER_GROUP;
// categories list
$query = mysql_query("SELECT * FROM " . $db_table['categories']);
$data = array();
$selected = ($vars['g_id'] == 1 || $vars['access_cats'][0] == 'all') ? ' CHECKED' : '';
$data[] = sprintf($html['input'], 'checkbox', 'cat_access[all]', 'all', $selected, LANG_ALL);
while ($array = mysql_fetch_array($query)) {
    $selected = (in_array($array['ID'], $vars['access_cats']) || $vars['g_id'] == 1 || $vars['access_cats'][0] == 'all') ? ' CHECKED' : '';
    $data[] = sprintf($html['input'], 'checkbox', 'cat_access[' . $array['ID'] . ']', $array['ID'], $selected, $array['name']);
}
$vars['cats'] = implode("<br>\n", $data);
?>
