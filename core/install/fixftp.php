<?php
if (!isset($step)) {
    header('Location: install.php');
    die();
}
//Fix ftp permissions
// Get the setting file version the make it so we can evaulate it
$setting_version = str_replace(".", "", $version);
if ($setting_version <= "159") {
    $select159 = "SELECTED";
}  else {
    $select170 = "SELECTED";
}
// We use $error instead of $errors because we know about them already!
if (isset($perms)) {
    $conn_id = @ftp_connect($_POST['ftp_server']);
    if (@ftp_login($conn_id, $_POST['ftp_login'], $_POST['ftp_pass'])) {
        foreach($perms as $perm) {
            if (!@ftp_chmod($conn_id, 0666, $_POST['ftp_dir'] . $perm)) {
                $error[] = "Couldn't chmod '$_POST[ftp_dir]$perm'";
            }
        }
        if (isset($oldfile)) {
            foreach($oldfile as $file) {
                if (!@ftp_delete($conn_id, $_POST['ftp_dir'].$file)) {
                    $error[] = "Couldn't remove '$_POST[ftp_dir]$file'";
                }
            }
        }
        if (isset($fixsettings)) {
            if (!@ftp_rename($conn_id, $_POST['ftp_dir'].'settings.default.php' , $_POST['ftp_dir'].'settings.php')) {
                $error[] = "Couldn't rename '$_POST[ftp_dir].settings.default.php' to 'settings.php'";
            }
        }
        if ($setting_version == "159") {
            if (!@ftp_delete($conn_id, $_POST['ftp_dir'].'settings.php')) {
                $error[] = "Couldn't remove '$_POST[ftp_dir]settings.php'";
            }
            if (!@ftp_rename($conn_id, $_POST['ftp_dir'].'settings.default.php' , $_POST['ftp_dir'].'settings.php')) {
                $error[] = "Couldn't rename '$_POST[ftp_dir].settings.default.php' to 'settings.php'";
            }
            if (!@ftp_chmod($conn_id, 0666, $_POST['ftp_dir'].'settings.php')) {
                $error[] = "Couldn't chmod 'settings.php'";
            }
        }    
    } else {
        $error[] = "Couldn't connect as '$_POST[ftp_login]'";
    }
}
if (!isset($error)) {
    $db_table_prefix = $db_table_prefix ? $db_table_prefix : 'ticket_';
    $db_table_tickets = $db_table_tickets ? $db_table_tickets : 'tickets';
    $output = '<p>Enter your database settings:</p>
    <table>
    <form id="database" name="database" method="post">
    <tr>
    <td><label>Database Type</label></td>
    <td>
        <select name="db_type">
            <option value="mysql">MySQL</option>
        </select>
    </td>
    </tr>

    <tr>
    <td><label>Database Server</label></td>
    <td><input name="db_host" type="text" value="' . $db_host . '" /></td>
    </tr>
    
    <tr>
    <td><label>Database Name</label></td>
    <td><input name="db_name" type="text" value="' . $db_name . '" /></td>
    </tr>

    <tr>
    <td><label>Database Username</label></td>
    <td><input name="db_user" type="text" value="' . $db_user . '" /></td>
    </tr>
    <tr>
    <td><label>Database Password</label></td>
    <td><input name="db_pass" type="password" value="" /></td>
    </tr>

    <tr>
    <td><label>Table Prefix*</label></td>
    <td><input name="db_table_prefix" type="text" value="' . $db_table_prefix . '" /></td>
    </tr>
    <tr>
    <td colspan=2>(ie: "ticket_" makes the tables for config become "ticket_config")</td>
    </tr>
    
    <tr>
    <td><label>Tickets Table*</label></td>
    <td><input name="db_table_tickets" type="text" value="' . $db_table_tickets . '" /></td>
    </tr>
    <tr>
    <td colspan=2>(ie: "tickets") we need this as in the past this table didn\'t have a prefix.</td>
    </tr>

    <tr>
    <td><label></label></td>
    <td><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <input type="hidden" name="enable_ftp" value="checked" />
    <input type="hidden" name="ftp_server" value="' . $_POST['ftp_server'] . '" />
    <input type="hidden" name="ftp_login" value="' . $_POST['ftp_login'] . '" />
    <input type="hidden" name="ftp_pass" value="' . $_POST['ftp_pass'] . '" />
    <input type="hidden" name="ftp_dir" value="' . $_POST['ftp_dir'] . '" />
    <input type="hidden" name="step" value="3" />
    </form>
    </table>
    <p>* If unsure, please leave it as is.</p>
    ';
}
if (isset($error)) {
    $output = DisplayErrors($error);
}
echo $output;
?>
