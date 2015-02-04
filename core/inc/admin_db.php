<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
if ($login[$a] || $login['ID'] == ADMIN) {
    if ($_POST['suba'] == 'backup') {
        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename='.$db_name.'.sql');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        echo db_dump();
        die();
    }
    if ($_POST['suba'] == 'optimize') {
        foreach($db_table as $table) {
            $vars['optimize'][] = LANG_DB_OPTIMIZING ." $table... ". table_status($table, 'Data_free') . LANG_DB_OPTIMIZED;
            mysql_query("OPTIMIZE TABLE `$table`");
        }
    }
}

$inc = 'admin_db.html';
?>