<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
// CLAIM THE TICKET
if ($_SESSION['user']['type'] === 'admin' && $ticket->status != 'closed') {
    if ($rep_row['ID'] == 0) {
        $sql = "SELECT * FROM " . $db_table['reps'] . " WHERE username = '" . $_SESSION['user']['id'] . "' LIMIT 1";
        $uid_res = mysql_query($sql);
        $uid_raw = mysql_fetch_array($uid_res);
        $cvars = array();
        $cvars['form_action'] = htmlspecialchars($_SERVER['REQUEST_URI']);
        $cvars['ticketid'] = $ticket->id;
        $cvars['text'] = LANG_UNASSIGNED_TICKET . ' ' . LANG_CLAIM_TEXT;
        $cvars['submit_text'] = LANG_CLAIM_IT;
        $cvars['myuid'] = $uid_raw['ID'];
        $tmp = $html['claim'];
        foreach($cvars as $key => $val) {
            $tmp = preg_replace('/\$' . $key . '/i', $val, $tmp);
        }
        echo $tmp;
    }
}
?>
