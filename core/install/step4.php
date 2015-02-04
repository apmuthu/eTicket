<?php
if (!isset($step)) {
    header('Location: ./install.php');
    die();
}
//step3: write db info to files, update config/rep/cat tables, and load settings into settings table
if (!isset($errors)) {
    $conn = @mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);
    if (empty($conn)) {
        $errors[] = 'Could not connect to database.';
    }
    $db_selected = @mysql_select_db($_POST['db_name'], $conn);
    if (empty($db_selected)) {
        $errors[] = 'Could not select database.';
    }
}
if (empty($_POST['admin_name'])) {
    $errors[] = 'Admin name must NOT be blank!';
}
if (empty($_POST['admin_email'])) {
    $errors[] = 'Admin email must NOT be blank!';
}
if (empty($_POST['admin_pass'])) {
    $errors[] = 'Admin password must NOT be blank!';
}
if (empty($_POST['cat_name'])) {
    $errors[] = 'Default category name must NOT be blank!';
}
if (empty($_POST['cat_email'])) {
    $errors[] = 'Default category email must NOT be blank!';
}
if (!isset($errors)) {
    //update the pipe.php file according to the new settings
    $file = '..' . '/' . 'pipe.php';
    $str = file_get_contents($file);
    if ($handle = fopen($file, 'w')) {
        $str = preg_replace('/^(.*)/', '#!' . trim($_POST['phppath']), $str);
        if (fwrite($handle, $str)) {
            echo "<p>'$file' was updated successfully.</p>\n";
            fclose($handle);
        } else {
            $errors[] = "Could not write to '$file' file.";
        }
    } else {
        $errors[] = "Could not open '$file' file for writing.";
    }
    unset($str);
    //fields to look for when replacing
    $fields = array('db_type', 'db_host', 'db_name', 'db_user', 'db_pass', 'db_table_prefix', 'db_table_tickets');
    //update the settings.pl file according to the new database settings
    echo "<p>Updating settings...</p>\n";
    $file = '..' . '/' . 'settings.php';
    $str = file_get_contents($file);
    if ($handle = fopen($file, 'w')) {
        $str = str_replace('$installed = 0;', '$installed = 1;', $str);
        $str = preg_replace("/(version = ')(.*)(';)/", '${1}' . LANG_VERSION . '$3', $str);
        $str = preg_replace("/(rootpath_dir = ')(.*)(';)/", '${1}' . $_POST[rootpath_dir] . '$3', $str);
        foreach($fields as $field) {
            if ($field == 'db_table_prefix') {
                $db_table_prefix = $_POST[$field];
            }
            $str = preg_replace("/($field)( = ')(.*)(';)/", '${1}${2}' . $_POST[$field] . '${4}', $str);
        }
        if (fwrite($handle, $str)) {
            echo "<p>'$file' was updated successfully.</p>\n";
            fclose($handle);
        } else {
            $errors[] = "Could not write to '$file' file.";
        }
    } else {
        $errors[] = "<b>Could not open '$file' file for writing.";
    }
    unset($str);
}
if ($type == "install") {
    echo '<p>Updating database...</p>';
    $queries = array();
    $queries[] = "INSERT INTO `" . $db_table_prefix . "reps` VALUES (1, '" . mysql_real_escape_string($_POST[admin_name]) . "', '" . mysql_real_escape_string($_POST[admin_email]) . "', 'admin', '" . md5($_POST[admin_pass]) . "', '', '1')";
    $queries[] = "INSERT INTO `" . $db_table_prefix . "categories` VALUES (1, '" . mysql_real_escape_string($_POST[cat_name]) . "', '', '', '', '" . mysql_real_escape_string($_POST[cat_email]) . "', '', 0, 'url');";
    foreach($queries as $query) {
        mysql_query($query);
        if (mysql_error()) {
            $errors[] = 'Error: ' . $query . ' : ' . mysql_error();
        }
    }
}
if (!isset($errors)) {
    echo '<p>Loading settings...</p>';
    $db_settings = array();
    $query = @mysql_query('SELECT * FROM ' . $db_table_prefix . 'settings');
    while ($setting = mysql_fetch_array($query)) {
        $db_settings['settings'][$setting['id']] = $setting['value'];
        if (!empty($setting['group'])) {
            $db_settings[$setting['group']][$setting['key']] = $setting['value'];
        } else {
            $db_settings[$setting['key']] = $setting['value'];
        }
    }
    include_once ('default_settings.php');
    $queries = array();
    foreach($settings as $key => $value) {
        if (is_array($value)) {
            $group = $key;
            foreach($value as $key => $val) {
                if (empty($db_settings[$group])) {
                    $queries[] = "INSERT INTO `" . $db_table_prefix . "settings` VALUES (NULL, '$group', '$key', '$val')";
                }
            }
        } elseif (empty($db_settings[$key])) {
            $queries[] = "INSERT INTO `" . $db_table_prefix . "settings` VALUES (NULL, NULL, '$key', '$value')";
        }
    }
    foreach($queries as $query) {
        mysql_query($query);
        if (mysql_error()) {
            $errors[] = 'Error: ' . $query . ' : ' . mysql_error();
        }
    }
}
if (isset($_POST['enable_ftp']) && !isset($errors)) {
    $conn_id = @ftp_connect($_POST['ftp_server']);
    if (@ftp_login($conn_id, $_POST['ftp_login'], $_POST['ftp_pass'])) {
        if (!@ftp_chmod($conn_id, 0644, $_POST['ftp_dir'] . 'settings.php')) {
            $errors[] = "Couldn't chmod '$_POST[ftp_dir]settings.php";
        }
        if (!@ftp_chmod($conn_id, 0755, $_POST['ftp_dir'] . 'pipe.php')) {
            $errors[] = "Couldn't chmod '$_POST[ftp_dir]pipe.php";
        }
        if (!@ftp_chmod($conn_id, 0777, $_POST['ftp_dir'] . 'attachments/')) {
            $errors[] = "Couldn't chmod '$_POST[ftp_dir]attachments/";
        }
        foreach($install_files as $file) {
            if (!@ftp_delete($conn_id, $_POST['ftp_dir'] . 'install/' . $file)) {
                $errors[] = "Couldn't delete '$_POST[ftp_dir]install/$file'";
            }
        }
        if (!@ftp_rmdir($conn_id, $_POST['ftp_dir'] . 'install/')) {
            $errors[] = "Couldn't delete '$_POST[ftp_dir]install/'";
        }
        echo "<p>Changing permissions on settings.php and pipe.php...</p>";
        echo "<p>Removing installation directory...</p>";
    } else {
        $errors[] = "Couldn't connect as '$_POST[ftp_login]'";
    }
    $output = '<p><a href="../">eTicket</a> appears to have installed successfully!</p>
    <p>Things to do next:</p>
    <ul>
    <li>Review the contents of "settings.php", ensure settings meet your requirements</li>
    <li>Login to the <a href="../admin.php">admin area to configure the helpdesk</a></li>
    <li>Setup email handling using the piping or pop3 method</li>
    </ul>';
} else {
    $output = '<p><a href="../">eTicket</a> appears to have installed successfully!</p>
    <p>Things to do next:</p>
    <ul>
    <li>Review the contents of "settings.php", ensure settings meet your requirements</li>
    <li>chmod "settings.php" to 644, no further editing is required</li>
    <li>chmod "pipe.php" to 755, must be executable</li>
    <li>If you want attachments enabled you MUST chmod 777 your attachments directory</li>
    <li>REMOVE the "install" directory from your server before you continue</li>
    <li>Login to the <a href="../admin.php">admin area to configure the helpdesk</a></li>
    <li>Setup email handling using the piping or pop3 method</li>
    </ul>';
}
if (isset($errors)) {
    $output = DisplayErrors($errors);
    $output.= '<p>Please fix the above error(s), install halted!</p>';
}
echo $output;
?>
