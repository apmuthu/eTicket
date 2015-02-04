<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if (!$_SESSION['user']) {
    logout($page);
}
if ($_REQUEST['s'] == 'reset') {
    unset($_SESSION['view']);
}
/* Filter & Session Data - START */
//Switch view status
if ($a == 'view_reopen') {
    $_SESSION['view']['status'] = 'reopened'; 
} elseif ($a == 'view_open') {
    $_SESSION['view']['status'] = 'open';
} elseif ($a == 'view_onhold') {
    $_SESSION['view']['status'] = 'onhold';
} elseif ($a == 'view_awaitingcustomer') {
    $_SESSION['view']['status'] = 'awaitingcustomer';
} elseif ($a == 'view_closed') {
    $_SESSION['view']['status'] = 'closed';
} elseif ($a == 'view_all') {
    $_SESSION['view']['status'] = 'all';
} elseif ($a == 'view_new') {
    $_SESSION['view']['status'] = 'new';
} elseif ($a == 'view_reopened') {
    $_SESSION['view']['status'] = 'reopened';
}
//the default is to read 'open' tickets - no more.
if (!isset($_SESSION['view']['status'])) {
    if ($_SESSION['user']['type'] == 'admin') $_SESSION['view']['status'] = 'open';
    if ($_SESSION['user']['type'] == 'client') $_SESSION['view']['status'] = 'all';
}
//if an admin submits an email search
if (($_SESSION['user']['type'] == 'admin') && (isset($_REQUEST['email'])) && ($_REQUEST['email'])) {
    $filter['email'] = $_REQUEST['email'];
}
//if they are a client (not admin) we must force filter their query
if ($_SESSION['user']['type'] == 'client') {
    $filter['email'] = $_SESSION['user']['id'];
}
//how should we order?
if ((!$_SESSION['view']['sort']) || (!$_SESSION['view']['way']) || !$_REQUEST['s']) {
    switch ($_SESSION['view']['status']) {
        case open:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'ASC';
        break;
        case answered:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'DESC';
        break;
        case closed:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'DESC';
        break;
        case all:
            $_SESSION['view']['sort'] = 'status';
            $_SESSION['view']['way'] = 'DESC';
        break;
    }
}
if ($_REQUEST['s']) {
    if ($_REQUEST['sort']) {
        $_SESSION['view']['sort'] = htmlspecialchars($_REQUEST['sort'], ENT_QUOTES);
    }
    if ($_REQUEST['way']) {
        $_SESSION['view']['way'] = htmlspecialchars($_REQUEST['way'], ENT_QUOTES);
    }
}
if (($_SESSION['view']['sort']) && ($_SESSION['view']['way'])) {
    $_SESSION['view']['orderby'] = $db_table['tickets'] . '.' . $_SESSION['view']['sort'] . ' ' . $_SESSION['view']['way'];
}
//filter by catagory
if (isset($_REQUEST['cat'])) $_SESSION['view']['cat'] = htmlspecialchars($_REQUEST['cat'], ENT_QUOTES);
//filter by rep
if (isset($_REQUEST['rep'])) $_SESSION['view']['rep'] = htmlspecialchars($_REQUEST['rep'], ENT_QUOTES);
//set tickets per page
$_SESSION['view']['per'] = (int)$_REQUEST['per'] ? $_REQUEST['per'] : $db_settings['tickets_per_page'];
//set page number
$_SESSION['view']['p'] = $_REQUEST['p'] ? htmlspecialchars($_REQUEST['p'], ENT_QUOTES) : 1;
/* Filter & Session Data - END */
//correct dates
if (isset($_REQUEST['date_from'])) {
    $_REQUEST['date_from'] = format_time('Y-m-d', strtotime($_REQUEST['date_from']));
    $_SESSION['view']['date_from'] = $_REQUEST['date_from'];
}
if (isset($_REQUEST['date_to'])) {
    $_REQUEST['date_to'] = format_time('Y-m-d', strtotime($_REQUEST['date_to']));
    $_SESSION['view']['date_to'] = $_REQUEST['date_to'];
}
/* set vars */
if ((isset($_REQUEST['text'])) && ($_REQUEST['text'])) $text = htmlspecialchars($_REQUEST['text'], ENT_QUOTES);
if (isset($_REQUEST['s'])) {
    $s = $_REQUEST['s'] == 'advanced' ? 'advanced' : 'basic';
}
$orderby = $_SESSION['view']['orderby'];
$per = $_SESSION['view']['per'];
$p = $_SESSION['view']['p'];
$status = $_SESSION['view']['status'];
$date_from = escape_string($_SESSION['view']['date_from']);
$date_to = escape_string($_SESSION['view']['date_to']);
/*Table Details*/
if ($_REQUEST['s']) {
    $newway = ($_SESSION['view']['way'] == 'ASC') ? 'DESC' : 'ASC';
} else {
    $newway = $_SESSION['view']['way'];
}
/* Create Query Start */
//set filters for the where statement
if ($_SESSION['view']['status']!='all' && $_SESSION['view']['status']!='open')
	$filter['status'] = $_SESSION['view']['status'];

if ($_SESSION['view']['cat']) {
    $filter['cat'] = ($_SESSION['user']['type'] == 'client' || (in_array($_SESSION['view']['cat'], $login['cat_access']) || $login['cat_access'][0] == 'all')) ? $_SESSION['view']['cat'] : '';
}
if ($_SESSION['view']['rep']) $filter['rep'] = $_SESSION['view']['rep'];
//implode the $filter array together into the WHERE
if (is_array($filter)) {
    foreach($filter as $key => $value) {
        if (empty($where)) {
            $where = '';
        } else {
            $where.= ' AND ';
        }
        if (!preg_match('/\./', $key)) {
            $key = $db_table['tickets'] . ".$key";
        }
        if (!empty($value)) {
            $value = escape_string($value);
            $where.= " $key = $value";
        }
    }
}
if ($_SESSION['user']['type'] != 'client' && $login['cat_access'][0] != 'all') {
    if (empty($where)) {
        $where = '';
    } else {
        $where.= ' AND ';
    }
    $key = $db_table['tickets'] . ".cat";
    $where.= "$key =" . implode(" OR $key = ", $login['cat_access']);
}
if ($_REQUEST['use_dates']) {
    //format_time('Y-m-d H:i:s',$date);
    if (empty($where)) {
        $where = '';
    } else {
        $where.= ' AND ';
    }
    $where.= $db_table['tickets'] . ".timestamp BETWEEN $date_from AND $date_to";
}
if (!empty($text)) {
    $query = "SELECT DISTINCT 
	" . $db_table['tickets'] . ".ID AS ID,
	" . $db_table['tickets'] . ".status,
	" . $db_table['tickets'] . ".timestamp as timestamp,
	" . $db_table['tickets'] . ".cat AS cat, 
	" . $db_table['tickets'] . ".subject AS subject,
	" . $db_table['tickets'] . ".rep AS rep,
	" . $db_table['tickets'] . ".email AS email,
	priority,
	" . $db_table['tickets'] . ".name AS name FROM (
		( " . $db_table['tickets'] . " LEFT JOIN " . $db_table['messages'] . " ON " . $db_table['messages'] . ".ticket = " . $db_table['tickets'] . ".ID )
		LEFT JOIN " . $db_table['answers'] . " ON " . $db_table['answers'] . ".reference = " . $db_table['messages'] . ".ID 
	)";
    if (!empty($where)) {
        $where.= ' AND ';
    } else {
        $where = '';
    }
    $where.= "(
	    " . $db_table['messages'] . ".message LIKE '%$text%' OR
	    " . $db_table['answers'] . ".message LIKE '%$text%' OR
	    " . $db_table['tickets'] . ".subject LIKE '%$text%' OR
	    " . $db_table['tickets'] . ".phone LIKE '%$text%' OR
	    " . $db_table['tickets'] . ".ip LIKE '%$text%' OR
	    " . $db_table['tickets'] . ".name LIKE '%$text%'
	)";
} else {
    $query = "SELECT * FROM " . $db_table['tickets'];
}
//add the where to the rest of the query
if ((isset($where)) && ($where)) {
    $query.= " WHERE $where";
}
//add the ordering at the end
if ($orderby) $query.= " ORDER BY " . $orderby;
//debug query
//echo "\n<!-- Query: ".$query." -->\n";
/* Create Query End */
//get a list of tickets as per query

if ($sql = mysql_query($query)) {
    while ($result = mysql_fetch_array($sql)) {
    	if ($status == 'all')
    	{
    		$results[] = $result;
    	}
    	elseif ($status == 'open')
    	{
    	if ($result['status'] == 'new' || $result['status'] == 'custreplied') { //filter by status (now we have answered)
            	$results[] = $result;
        	}
    	}
        else
        {
        	if ($result['status'] == $status) { //filter by status (now we have answered)
            	$results[] = $result;
        	}
        }
    }
}
//work out page title
if ($s == 'basic') {
    $pagetitle = LANG_BASIC_SEARCH;
} elseif ($s == 'advanced') {
    $pagetitle = LANG_ADVANCED_SEARCH;
} else {
    $pagetitle = get_real_status_names($status);
}
$pagetitle = mb_convert_case($pagetitle, MB_CASE_TITLE, $db_settings['charset']);
/*pagingation*/
$total = count($results);
$pages = ceil($total/$per);
//if total pages is more than current page, display last page instead of nothing
if ($p > ($pages-1)) {
    $p = $pages;
}
$start = ((($p-1) *$per) -1);
$end = (($p*$per) -1);
//get a list of the catagories - save repeating
$cats_res = mysql_query("SELECT * FROM " . $db_table['categories']);
while ($cats_row = mysql_fetch_array($cats_res)) {
    $cats_rows[$cats_row['ID']] = $cats_row;
}
//get a list of the reps - save repeating
$reps_res = mysql_query("SELECT * FROM " . $db_table['reps']);
while ($reps_row = mysql_fetch_array($reps_res)) {
    $reps_rows[$reps_row['ID']] = $reps_row;
}
/* start html vars */
$main_table = $html['main']['no_tickets'];
$main_table_content = '';
if ($results) {
    $class = 'mainTable'; //for table stripes (default)
    foreach($results as $key => $result) {
        if (($key > $start) && ($key <= $end)) {
            //case by case vars
            $eval = new Ticket($result);
            $cat_row = $cats_rows[$eval->cat];
            $rep_row = $reps_rows[$eval->rep];
            $hide = ($_SESSION['user']['type'] == '' && $cat_row['hidden']);
            $cat_row['name'] = $hide ? LANG_IN_PROGRESS : $cat_row['name'];
            $pri_text = $db_settings['pri_text'][$eval->priority];
            $pri_style = $db_settings['pri_style'][$eval->priority];
            $class = ($class == 'mainTableAlt') ? 'mainTable' : 'mainTableAlt';
            $this_content = $html['main_table_content'];
            $this_content = str_replace('{class}', $class, $this_content);
            $this_content = str_replace('{page}', $page, $this_content);
            $this_content = str_replace('{id}', $eval->id, $this_content);
            $this_content = str_replace('{checkbox}', sprintf($html['main']['input'], 'checkbox', 't[' . $eval->id . ']', 'checkbox'), $this_content);
            $this_content = str_replace('{short_time}', $eval->short_time, $this_content);
            $this_content = str_replace('{subject}', htmlspecialchars(stripslashes($eval->subject)), $this_content);
            $this_content = str_replace('{cat_name}', $cat_row['name'], $this_content);
            $this_content = str_replace('{rep_name}', $rep_row['name'], $this_content);
            $this_content = str_replace('{pri_style}', $pri_style, $this_content);
            $this_content = str_replace('{pri_text}', $pri_text, $this_content);
            $status = get_real_status_name($eval->status);
                        
            $this_content = str_replace('{status}', $status, $this_content);
            $this_content = str_replace('{email}', htmlspecialchars(stripslashes($eval->email)), $this_content);
            $this_content = str_replace('{name}', htmlspecialchars(stripslashes($eval->name)), $this_content);
            $this_content = str_replace('{unanswered}', $eval->unanswered . has_priv_msg($eval->id), $this_content);
            $main_table_content.= $this_content;
        }
    }
    if (!empty($main_table_content)) {
        $main_table = $html['main_table'];
        $main_table = str_replace('%way', $newway, $main_table);
        $main_table = str_replace('%status', $status, $main_table);
        $main_table = str_replace('%content', $main_table_content, $main_table);
    }
    unset($main_table_content);
    /*pagination*/
    @($pages = $total/$per);
    $pages = (intval($pages) == $pages) ? $pages : intval($pages) +1;
    if ($pages > 1) {
        $pgs = array();
        for ($x = 1;$x <= $pages;++$x) {
            if ($x == $p) {
                $pgs[] = sprintf($html['main']['currentpage'], $x) . "\n";
            } else {
                $purl = $_SERVER['PHP_SELF'] . '?p=' . $x;
                $qs = preg_replace('/p=[0-9]+/', '', $_SERVER['QUERY_STRING']);
                if (!empty($qs)) {
                    $purl.= (substr($qs, 0, 1) == '&') ? $qs : "&amp;$qs";
                }
                $pgs[] = sprintf($html['main']['page'], $purl, $x) . "\n";
            }
        }
        $pgs = implode(', ', $pgs);
    }
}
if (($db_settings['search_disp']) && (!strstr($_SERVER['PHP_SELF'], 'search'))) {
    $vars['search_include'] = 1;
}
/* end html vars */
include ($themes_dir . $db_settings['theme'] . '/' . 'main.html.php');
?>
