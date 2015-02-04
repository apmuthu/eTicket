<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
if ($login[$a] || $login['ID'] == ADMIN) {
    if (isset($_REQUEST['e'])) {
        $e = $_REQUEST['e'];
        switch ($e) {
            case "add":
                if (!$_POST['Action']) {
                    $inc = 'admin_banlist_addedit.html';
                }
                ob_start();
                // get action
                $ab = $_POST['ab'];
                if (empty($ab)) {
                    $ab = $_GET['key'] ? 'C' : 'I'; //copy record or display blank
                    
                }
                switch ($ab) {
                    case "C":
                        // get a record to display
                        $tkey = (int)$_GET['key'];
                        $strsql = "SELECT * FROM " . $db_table['banlist'] . " WHERE `value_id`=" . $tkey;
                        $rs = mysql_query($strsql);
                        if (mysql_num_rows($rs) == 0) {
                            ob_end_clean();
                            header('Location: admin.php?a=banlist');
                            die();
                        } else {
                            $row = mysql_fetch_array($rs);
                            // get the field contents
                            $x_value = @$row['value'];
                        }
                        mysql_free_result($rs);
                    break;
                    case "A":
                        // add
                        // get the form values
                        $x_value = @$_POST['x_value'];
                        $x_value_id = @$_POST['x_value_id'];
                        // add the values into an array
                        if ($x_value != '') {
                            // value
                            $theValue = get_magic_quotes_gpc() ? $x_value : addslashes($x_value);
                            $theValue = ($theValue != '') ? "'$theValue'" : "NULL";
                            $fieldList['value'] = $theValue;
                            // insert into database
                            $strsql = "INSERT INTO " . $db_table['banlist'] . " (" . implode(',', array_keys($fieldList)) . ") VALUES (" . implode(',', array_values($fieldList)) . ")";
                            mysql_query($strsql) or die(mysql_error());
                            ob_end_clean();
                        }
                        header('Location: admin.php?a=banlist');
                        die();
                    break;
                }
                break;
            case "delete":
                if (!$_POST['submit']) {
                    $inc = 'admin_banlist_delete.html';
                }
                ob_start();
                $page = 'admin.php';
                // multiple delete records
                $key = $_REQUEST['key'];
                if (count($key) == 0) {
                    header('Location: admin.php?a=banlist');
                    die();
                }
                $sqlKey = '';
                foreach($key as $reckey) {
                    $reckey = (int)$reckey;
                    // build the SQL
                    $sqlKey.= "(" . "`value_id`=" . "" . $reckey . "" . " AND ";
                    if (substr($sqlKey, -5) == " AND ") {
                        $sqlKey = substr($sqlKey, 0, strlen($sqlKey) -5);
                    }
                    $sqlKey.= ") OR ";
                }
                if (substr($sqlKey, -4) == " OR ") {
                    $sqlKey = substr($sqlKey, 0, strlen($sqlKey) -4);
                }
                // get action
                if (isset($_POST['ab'])) {
                    $ab = $_POST['ab'];
                }
                if (empty($ab)) {
                    $ab = 'I';
                }
                switch ($ab) {
                    case "I":
                        // display
                        $strsql = "SELECT * FROM " . $db_table['banlist'] . " WHERE " . $sqlKey;
                        $rs = mysql_query($strsql) or die(mysql_error());
                        if (mysql_num_rows($rs) == 0) {
                            ob_end_clean();
                            header('Location: admin.php?a=banlist');
                            die();
                        }
                        $recCount = 0;
                        while ($row = mysql_fetch_array($rs)) {
                            $recCount = $recCount++;
                            $x_value = @$row['value'];
                            $items[] = $x_value;
                        }
                        mysql_free_result($rs);
                    break;
                    case "D":
                        // delete
                        $strsql = "DELETE FROM " . $db_table['banlist'] . " WHERE " . $sqlKey;
                        $rs = mysql_query($strsql) or die(mysql_error());
                        ob_end_clean();
                        header('Location: admin.php?a=banlist');
                        die();
                    break;
                }
                break;
            case "edit":
                if (!$_POST['submit']) {
                    $inc = 'admin_banlist_addedit.html';
                }
                ob_start();
                $page = 'admin.php';
                $key = (int)$_REQUEST['key'];
                if (empty($key)) {
                    header('Location: admin.php?a=banlist');
                    die();
                }
                // get action
                $ab = @$_POST["ab"];
                if (empty($ab)) {
                    //display with input box
                    $ab = "I";
                }
                // get fields from form
                $x_value = @$_POST["x_value"];
                $x_value_id = @$_POST["x_value_id"];
                switch ($ab) {
                    case "I":
                        // get a record to display
                        $tkey = "" . $key . "";
                        $strsql = "SELECT * FROM " . $db_table['banlist'] . " WHERE `value_id`=" . $tkey;
                        $rs = mysql_query($strsql) or die(mysql_error());
                        if (!($row = mysql_fetch_array($rs))) {
                            ob_end_clean();
                            header('Location: admin.php?a=banlist');
                            die();
                        }
                        // get the field contents
                        $x_value = @$row["value"];
                        $x_value_id = @$row["value_id"];
                        mysql_free_result($rs);
                    break;
                    case "U":
                        // update
                        $tkey = "" . $key . "";
                        // get the form values
                        $x_value = @$_POST["x_value"];
                        $x_value_id = @$_POST["x_value_id"];
                        // add the values into an array
                        // value
                        $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_value) : $x_value;
                        $theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
                        $fieldList["`value`"] = $theValue;
                        // update
                        $updateSQL = "UPDATE " . $db_table['banlist'] . " SET ";
                        foreach($fieldList as $key => $temp) {
                            $updateSQL.= "$key = $temp, ";
                        }
                        if (substr($updateSQL, -2) == ", ") {
                            $updateSQL = substr($updateSQL, 0, strlen($updateSQL) -2);
                        }
                        $updateSQL.= " WHERE `value_id`=" . $tkey;
                        $rs = mysql_query($updateSQL) or die(mysql_error());
                        ob_end_clean();
                        header('Location: admin.php?a=banlist');
                        die();
                }
                break;
            }
    } else {
        if (!$_POST['submit']) {
            $inc = "admin_banlist.html";
        }
        $displayRecs = 20;
        $recRange = 10;
        $dbwhere = "";
        $masterdetailwhere = "";
        $searchwhere = "";
        $a_search = "";
        $b_search = "";
        $whereClause = "";
        // get search criteria for basic search
        $pSearch = @$_GET["psearch"];
        $pSearchType = @$_GET["psearchtype"];
        if ($pSearch <> "") {
            $pSearch = str_replace("'", "\'", $pSearch);
            if ($pSearchType <> "") {
                while (strpos($pSearch, "  ") > 0) {
                    $pSearch = str_replace("  ", " ", $pSearch);
                }
                $arpSearch = explode(" ", trim($pSearch));
                foreach($arpSearch as $kw) {
                    $b_search.= "(";
                    $b_search.= "`value` LIKE '%" . trim($kw) . "%' OR ";
                    if (substr($b_search, -4) == " OR ") {
                        $b_search = substr($b_search, 0, strlen($b_search) -4);
                    }
                    $b_search.= ") " . $pSearchType . " ";
                }
            } else {
                $b_search.= "`value` LIKE '%" . $pSearch . "%' OR ";
            }
        }
        if (substr($b_search, -4) == " OR ") {
            $b_search = substr($b_search, 0, strlen($b_search) -4);
        }
        if (substr($b_search, -5) == " AND ") {
            $b_search = substr($b_search, 0, strlen($b_search) -5);
        }
        // build search criteria
        if ($a_search <> "") {
            //advanced search
            $searchwhere = $a_search;
        } elseif ($b_search <> "") {
            //basic search
            $searchwhere = $b_search;
        }
        // save search criteria
        if ($searchwhere <> "") {
            $_SESSION['banlist']['searchwhere'] = $searchwhere;
            $_SESSION['banlist']['pSearch'] = $pSearch;
            $_SESSION['banlist']['pSearchType'] = $pSearchType;
            //reset start record counter (new search)
            $startRec = 1;
            $_SESSION['banlist']['REC'] = $startRec;
        } else {
            $searchwhere = @$_SESSION['banlist']["searchwhere"];
            $pSearch = $_SESSION['banlist']['pSearch'];
            $pSearchType = $_SESSION['banlist']['pSearchType'];
        }
        // get clear search cmd
        if (@$_GET["cmd"] <> "") {
            $cmd = $_GET["cmd"];
            if (strtoupper($cmd) == "RESET") {
                //reset search criteria
                $searchwhere = '';
                $_SESSION['banlist']['searchwhere'] = $searchwhere;
                $pSearch = '';
                $_SESSION['banlist']['pSearch'] = $pSearch;
                $pSearchType = '';
                $_SESSION['banlist']['pSearchType'] = $pSearchType;
            } elseif (strtoupper($cmd) == "RESETALL") {
                //reset search criteria
                $searchwhere = '';
                $_SESSION['banlist']["searchwhere"] = $searchwhere;
                $pSearch = '';
                $_SESSION['banlist']['pSearch'] = $pSearch;
                $pSearchType = '';
                $_SESSION['banlist']['pSearchType'] = $pSearchType;
            }
            //reset start record counter (reset command)
            $startRec = 1;
            $_SESSION['banlist']['REC'] = $startRec;
        }
        // build dbwhere
        if ($masterdetailwhere <> "") {
            $dbwhere.= "(" . $masterdetailwhere . ") AND ";
        }
        if ($searchwhere <> "") {
            $dbwhere.= "(" . $searchwhere . ") AND ";
        }
        if (strlen($dbwhere) > 5) {
            // trim rightmost AND
            $dbwhere = substr($dbwhere, 0, strlen($dbwhere) -5);
        }
        // default order
        $DefaultOrder = '';
        $DefaultOrderType = '';
        // default filter
        $DefaultFilter = '';
        // check for an Order parameter
        $OrderBy = '';
        if (@$_GET['order'] <> "") {
            $OrderBy = $_GET["order"];
            // check if an ASC/DESC toggle is required
            if (@$_SESSION['banlist']["OB"] == $OrderBy) {
                if (@$_SESSION['banlist']["OT"] == "ASC") {
                    $_SESSION['banlist']["OT"] = "DESC";
                } else {
                    $_SESSION['banlist']["OT"] = "ASC";
                }
            } else {
                $_SESSION['banlist']["OT"] = "ASC";
            }
            $_SESSION['banlist']["OB"] = $OrderBy;
            $_SESSION['banlist']['REC'] = 1;
        } else {
            $OrderBy = @$_SESSION['banlist']["OB"];
            if ($OrderBy == "") {
                $OrderBy = $DefaultOrder;
                $_SESSION['banlist']["OB"] = $OrderBy;
                $_SESSION['banlist']["OT"] = $DefaultOrderType;
            }
        }
        // build SQL
        $strsql = "SELECT * FROM " . $db_table['banlist'];
        if ($DefaultFilter <> "") {
            $whereClause.= "(" . $DefaultFilter . ") AND ";
        }
        if ($dbwhere <> "") {
            $whereClause.= "(" . $dbwhere . ") AND ";
        }
        if (substr($whereClause, -5) == " AND ") {
            $whereClause = substr($whereClause, 0, strlen($whereClause) -5);
        }
        if ($whereClause <> "") {
            $strsql.= " WHERE " . $whereClause;
        }
        if ($OrderBy <> "") {
            $strsql.= " ORDER BY `" . $OrderBy . "` " . @$_SESSION['banlist']["OT"];
        }
        //echo $strsql; // comment out this line to view the SQL
        $rs = mysql_query($strsql);
        $totalRecs = intval(@mysql_num_rows($rs));
        // check for a START parameter
        if (@$_GET["start"] <> "") {
            $startRec = $_GET["start"];
            $_SESSION['banlist']['REC'] = $startRec;
        } elseif (@$_GET["pageno"] <> "") {
            $pageno = $_GET["pageno"];
            if (is_numeric($pageno)) {
                $startRec = ($pageno-1) *$displayRecs+1;
                if ($startRec <= 0) {
                    $startRec = 1;
                } elseif ($startRec >= (($totalRecs-1) /$displayRecs) *$displayRecs+1) {
                    $startRec = (($totalRecs-1) /$displayRecs) *$displayRecs+1;
                }
                $_SESSION['banlist']['REC'] = $startRec;
            } else {
                $startRec = @$_SESSION['banlist']['REC'];
                if (!is_numeric($startRec)) {
                    // reset start record counter
                    $startRec = 1;
                    $_SESSION['banlist']['REC'] = $startRec;
                }
            }
        } else {
            $startRec = @$_SESSION['banlist']['REC'];
            if (!is_numeric($startRec)) {
                // reset start record counter
                $startRec = 1;
                $_SESSION['banlist']['REC'] = $startRec;
            }
        }
    }
}
/* html vars start */
$vars = array();
//psearchtype
$tmp = '';
$check_var = $_SESSION['banlist']['pSearchType'];
$types = array('' => LANG_EXACT_PHRASE, 'AND' => LANG_ALL_WORDS, 'OR' => LANG_ANY_WORD);
foreach($types as $type => $val) {
    $checked = ($check_var == $type) ? ' checked' : '';
    $tmp.= sprintf($html['banlist']['input'], 'radio', 'psearchtype', $type, $checked, $val);
}
$vars['psearchtype'] = $tmp;
$vars['pSearch'] = htmlspecialchars($_SESSION['banlist']['pSearch']);
if ($OrderBy == 'value') {
    $vars['orderby'] = (@$_SESSION['banlist']['OT'] == 'ASC') ? 5 : ((@$_SESSION['banlist']['OT'] == 'DESC') ? 6 : '');
}
// avoid starting record > total records
if ($startRec > $totalRecs) {
    $startRec = $totalRecs;
}
// set the last record to display
$stopRec = $startRec+$displayRecs-1;
$recCount = $startRec-1;
// move to the first record
@mysql_data_seek($rs, $recCount);
$recActual = 0;
$tmp = '';
while (($row = @mysql_fetch_array($rs)) && ($recCount < $stopRec)) {
    $recCount++;
    if ($recCount >= $startRec) {
        $recActual++;
        // load key for record
        $key = @$row["value_id"];
        $x_value = @$row["value"];
        $x_value_id = @$row["value_id"];
        $edit_href = (!is_null(@$row["value_id"])) ? "admin.php?a=banlist&amp;e=edit&key=" . urlencode($row["value_id"]) : "javascript:alert('" . LANG_INVALID_RECORD . "');";
        $copy_href = (!is_null(@$row["value_id"])) ? "admin.php?a=banlist&amp;e=add&key=" . urlencode($row["value_id"]) : "javascript:alert('" . LANG_INVALID_RECORD . "');";
        $tmp.= sprintf($html['banlist']['main_table_content'], $key, $edit_href, $copy_href, $x_value);
    }
}
//end while
@mysql_free_result($rs); // close connection
$vars['main_table_content'] = $tmp;
$tmp = '';
// display page numbers
if ($totalRecs > 0) {
    $rsEof = ($totalRecs < ($startRec+$displayRecs));
    // find out if there should be backward or forward Buttons on the table
    if ($startRec == 1) {
        $isPrev = False;
    } else {
        $isPrev = True;
        $PrevStart = $startRec-$displayRecs;
        if ($PrevStart < 1) {
            $PrevStart = 1;
        }
        $tmp.= sprintf($html['banlist']['prev'], $PrevStart);
    }
    if ($isPrev || $totalRecs != 0) {
        $x = 1;
        $y = 1;
        $dx1 = intval(($startRec-1) /($displayRecs*$recRange)) *$displayRecs*$recRange+1;
        $dy1 = intval(($startRec-1) /($displayRecs*$recRange)) *$recRange+1;
        if (($dx1+$displayRecs*$recRange-1) > $totalRecs) {
            $dx2 = intval($totalRecs/$displayRecs) *$displayRecs+1;
            $dy2 = intval($totalRecs/$displayRecs) +1;
        } else {
            $dx2 = $dx1+$displayRecs*$recRange-1;
            $dy2 = $dy1+$recRange-1;
        }
        while ($x <= $totalRecs) {
            if ($x >= $dx1 && $x <= $dx2) {
                if ($startRec == $x) {
                    $tmp.= sprintf($html['banlist']['b'], $y);
                } else {
                    $tmp.= sprintf($html['banlist']['ab'], $x, $y);
                }
                $x = $x+$displayRecs;
                $y = $y+1;
            } elseif ($x >= ($dx1-$displayRecs*$recRange) && $x <= ($dx2+$displayRecs*$recRange)) {
                if ($x+$recRange*$displayRecs < $totalRecs) {
                    $tmp.= sprintf($html['banlist']['ab'], $x, $y . '-' . $y+$recRange-1);
                } else {
                    $ny = intval(($totalRecs-1) /$displayRecs) +1;
                    if ($ny == $y) {
                        $tmp.= sprintf($html['banlist']['ab'], $x, $y);
                    } else {
                        $tmp.= sprintf($html['banlist']['ab'], $x, $y . '-' . $ny);
                    }
                }
                $x = $x+$recRange*$displayRecs;
                $y = $y+$recRange;
            } else {
                $x = $x+$recRange*$displayRecs;
                $y = $y+$recRange;
            }
        }
    }
    // next link
    if ($totalRecs >= $startRec+$displayRecs) {
        $NextStart = $startRec+$displayRecs;
        $isMore = True;
        $tmp.= sprintf($html['banlist']['next'], $NextStart);
    } else {
        $isMore = FALSE;
    }
    if ($startRec > $totalRecs) {
        $startRec = $totalRecs;
    }
    $stopRec = $startRec+$displayRecs-1;
    $recCount = $totalRecs-1;
    if ($rsEof) {
        $recCount = $totalRecs;
    }
    if ($stopRec > $recCount) {
        $stopRec = $recCount;
    }
    $RecText = LANG_BANLIST_RECORD_TOTAL;
    $RecText = str_replace('%start', $startRec, $RecText);
    $RecText = str_replace('%stop', $stopRec, $RecText);
    $RecText = str_replace('%total', $totalRecs, $RecText);
    $tmp.= "($RecText)";
} else {
    $tmp.= LANG_NO_RECORDS_FOUND;
}
$vars['pagination'] = $tmp;
/* html vars end */
?>