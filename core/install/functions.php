<?php
function DisplayErrors($errors) {
    $output = '';
    foreach($errors as $error) {
        if (!is_array($error)) {
            $output.= "<p><b>Error:</b> $error</p>\n";
        }
    }
    return $output;
}
function rootpath_dir() {
    $current_dir = getcwd(); //store current dir
    chdir('..'); //drop down a level
    $rootpath_dir = add_trailing_slash(getcwd(), "/"); //save this, add a slash (if it needs one)
    chdir($current_dir); //return to dir
    return $rootpath_dir;
}
function root_url() {
    $proto = (isset($_SERVER['HTTPS']) ? 'https' : 'http');
    $root_url = $proto . '://' . $_SERVER['HTTP_HOST'] . remove_trailing_slash(cleanPath(dirname($_SERVER['PHP_SELF']) . '/../'));
    return $root_url;
}
function checkfortable($table) {
    $result = mysql_query('select * from ' . $table);
    if (!$result) {
        return false;
    }
    return true;
}
function remove_trailing_slash($dir, $slash = '/') {
    if (substr($dir, -1) == $slash) {
        $dir = substr($dir, 0, -1);
    }
    return $dir;
}
function add_trailing_slash($dir, $slash = '/') {
    if (substr($dir, -1) != $slash) {
        $dir = $dir . $slash;
    }
    return $dir;
}
//Start: *** special mysql database functions for restoring databases, borrowed from phpBB ***
function remove_remarks($sql) {
    $lines = explode("\n", $sql);
    // try to keep mem. use down
    $sql = "";
    $linecount = count($lines);
    $output = "";
    for ($i = 0;$i < $linecount;$i++) {
        if (($i != ($linecount-1)) || (strlen($lines[$i]) > 0)) {
            if ((!isset($lines[$i][0])) || ($lines[$i][0] != "#")) {
                $output.= $lines[$i] . "\n";
            } else {
                $output.= "\n";
            }
            // Trading a bit of speed for lower mem. use here.
            $lines[$i] = "";
        }
    }
    return $output;
}
//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter) {
    // Split up our string into "possible" SQL statements.
    $tokens = explode($delimiter, $sql);
    // try to save mem.
    $sql = "";
    $output = array();
    // we don't actually care about the matches preg gives us.
    $matches = array();
    // this is faster than calling count($oktens) every time thru the loop.
    $token_count = count($tokens);
    for ($i = 0;$i < $token_count;$i++) {
        // Don't wanna add an empty string as the last thing in the array.
        if (($i != ($token_count-1)) || (strlen($tokens[$i] > 0))) {
            // This is the total number of single quotes in the token.
            $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
            // Counts single quotes that are preceded by an odd number of backslashes,
            // which means they're escaped quotes.
            $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
            $unescaped_quotes = $total_quotes-$escaped_quotes;
            // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
            if (($unescaped_quotes%2) == 0) {
                // It's a complete sql statement.
                $output[] = $tokens[$i];
                // save memory.
                $tokens[$i] = "";
            } else {
                // incomplete sql statement. keep adding tokens until we have a complete one.
                // $temp will hold what we have so far.
                $temp = $tokens[$i] . $delimiter;
                // save memory..
                $tokens[$i] = "";
                // Do we have a complete statement yet?
                $complete_stmt = false;
                for ($j = $i+1;(!$complete_stmt && ($j < $token_count));$j++) {
                    // This is the total number of single quotes in the token.
                    $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                    // Counts single quotes that are preceded by an odd number of backslashes,
                    // which means they're escaped quotes.
                    $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
                    $unescaped_quotes = $total_quotes-$escaped_quotes;
                    if (($unescaped_quotes%2) == 1) {
                        // odd number of unescaped quotes. In combination with the previous incomplete
                        // statement(s), we now have a complete statement. (2 odds always make an even)
                        $output[] = $temp . $tokens[$j];
                        // save memory.
                        $tokens[$j] = "";
                        $temp = "";
                        // exit the loop.
                        $complete_stmt = true;
                        // make sure the outer loop continues at the right point.
                        $i = $j;
                    } else {
                        // even number of unescaped quotes. We still don't have a complete statement.
                        // (1 odd and 1 even always make an odd)
                        $temp.= $tokens[$j] . $delimiter;
                        // save memory.
                        $tokens[$j] = "";
                    }
                } // for..
                
            } // else
            
        }
    }
    return $output;
}
//mysql_run_queries function was in part stolen from phpBB, turned into a function for this.
function mysql_run_queries($sql_query) {
    $sql_query = remove_remarks($sql_query);
    $pieces = split_sql_file($sql_query, ";");
    $sql_count = count($pieces);
    for ($i = 0;$i < $sql_count;$i++) {
        $sql = trim($pieces[$i]);
        if (!empty($sql) and $sql[0] != "#") {
            $result = mysql_query($sql);
            if (!$result) {
                echo '<p><b>Error:</b> ' . mysql_error() . "<br>\n";
                $errors = 1;
            }
        }
    }
    if (!isset($errors)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
function mysql_restore_db($file) {
    $sql_query = file_get_contents($file);
    mysql_run_queries($sql_query);
}
//End: special mysql database functions
function cleanPath($path) {
    $result = array();
    // $pathA = preg_split('/[\/\\\]/', $path);
    $pathA = explode('/', $path);
    if (!$pathA[0]) $result[] = '';
    foreach($pathA AS $key => $dir) {
        if ($dir == '..') {
            if (end($result) == '..') {
                $result[] = '..';
            } elseif (!array_pop($result)) {
                $result[] = '..';
            }
        } elseif ($dir && $dir != '.') {
            $result[] = $dir;
        }
    }
    if (!end($pathA)) $result[] = '';
    return implode('/', $result);
}
function checkversion() {
    $rootpath_dir = rootpath_dir();
    $include = '../settings.php';
    if (file_exists($include)) {
        include_once ($include);
    }
    $include = '../lang.php';
    if (file_exists($include)) {
        include_once ($include);
    }
}
function phppath() {
    if ((isset($_ENV['OS'])) && ($_ENV['OS'] == 'Windows_NT')) {
        $paths = explode(';', $_ENV['Path']);
        $paths[] = $_ENV['CommonProgramFiles'];
        $paths[] = $_ENV['ProgramFiles'];
        $files = array();
        foreach($paths as $path) {
            $files[] = $path . '\php\bin\php.exe';
            $files[] = $path . '\php.exe';
        }
        $files[] = 'C:\php\bin\php.exe';
        foreach($files as $file) {
            if (file_exists($file)) {
                $phppath = $file;
            }
        }
        return $phppath;
    } else {
        if (is_callable("shell_exec"))
        $phppath = @exec('which php');
        if (!$phppath) {
            $phppath = '/usr/local/bin/php';
        }
    }
    return $phppath;
}
?>
