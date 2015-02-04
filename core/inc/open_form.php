<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
//vars are what are used in the HTML
$vars = array();
$type = 'text';
$name = '';
$email = '';
if ($login && $_SESSION['user']['type'] == 'client') {
    $type = 'hidden';
    $email = $_SESSION['user']['id'];
    $array = mysql_fetch_array(mysql_query("SELECT DISTINCT name FROM " . $db_table['tickets'] . " WHERE email=" . escape_string($email)));
    $name = $array['name'] ? $array['name'] : $email;
} elseif (isset($_GET['email'])) {
    $type = 'text';
    $email = $_GET['email'];
    if (is_array($email)) {
        die('Attempted hack');
    }
    $array = mysql_fetch_array(mysql_query("SELECT DISTINCT name FROM " . $db_table['tickets'] . " WHERE email=" . escape_string($email)));
    $name = $array['name'] ? $array['name'] : $email;
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['name'])) {
    $name = $_POST['name'];
}   
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$vars['name_html'] = sprintf($html['open_form']['name'], $type, $name);
$vars['email_html'] = sprintf($html['open_form']['email'], $type, $email);
if ($type == 'hidden') {
    $vars['name_html'].= $name;
    $vars['email_html'].= $email;
}
// Disable hidden categories in user "new ticket" form, but not in admin form
if ($_SESSION['user']['type'] == 'admin') {
    $cats = mysql_query("SELECT * FROM " . $db_table['categories']);
} else {
    $cats = mysql_query("SELECT * FROM " . $db_table['categories'] . " WHERE NOT hidden");
}
$vars['cat_options'] = '';
while ($cat = mysql_fetch_array($cats)) {
    if ($_GET['cat'] == $cat['ID'] or $_POST['cat'] == $cat['ID']) {
        $selected = ' SELECTED';
    } 
    $hidden = ($cat['hidden']) ? '*' : '';
    $vars['cat_options'].= sprintf($html['open_form']['options'], $cat['ID'], $selected, $cat['name'] . $hidden);
    unset($selected);
}
$vars['pri_options'] = '';
foreach($db_settings['pri'] as $pri) {
    $pri_text = $db_settings['pri_text'][$pri];
    if ($_GET['pri'] == $pri or $_POST['pri'] == $pri) {
        $selected = ' SELECTED';
    }
    $vars['pri_options'].= sprintf($html['open_form']['options'], $pri, $selected, $pri_text);
    unset($selected);
}
//Predefined answer responses MOD START
if ((!empty($db_settings['predef_answers'])) && ($_SESSION['user']['type'] === 'admin')) {
    echo $html['open_form']['predef_js'];
    $vars['response_options'] = '';
    foreach($db_settings['predef_answers'] as $key => $value) {
        $name = htmlspecialchars($ticket->name);
        $firstname = substr($firstname, 0, strpos($firstname, ' '));
        $value = str_replace('%name', $name, $value);
        $value = str_replace('%firstname', $firstname ? $firstname : $name, $value);
        $vars['response_options'].= sprintf($html['open_form']['options'], htmlspecialchars($value), '', htmlspecialchars($key));
    }
} //end answers
//Predefined answer responses MOD END
$vars = array_merge($vars, htmlspecialchars_array($_POST));
$form_action = $db_settings['root_url'].'/open.php';
include_once ($themes_dir . $db_settings['theme'] . '/' . 'open_form.html.php');
?>
