<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<div class="admin" id="cat">
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post"> 
	<input type="hidden" name="a" value="cat"> 
	<input type="hidden" name="c_id" value="<?php echo $_POST['c_id']; ?>">
	
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<select name="c_id">
		<option value=""></option>
		<?php
if ((isset($_POST['c_id'])) && ($_POST['c_id'] != '')) {
    $c_id = $_POST['c_id'];
}
if ((isset($_POST['submit_new'])) && ($_POST['submit_new'] != '')) {
    $submit_new = $_POST['submit_new'];
}
$cats = mysql_query("SELECT * FROM " . $db_table['categories']);
while ($cat = mysql_fetch_array($cats)) {
    $selected = ($cat['ID'] == $c_id) ? ' SELECTED' : '';
    $cat['name'] = $cat['hidden'] ? "$cat[name]*" : $cat['name'];
?>
			<option value="<?php echo $cat['ID']; ?>"<?php echo $selected; ?>><?php echo $cat['name']; ?></option> 
		<?php
} ?>
		</select>
		</td>
		<td>&nbsp;</td>
		<td>
		<input type="submit" name="select" value="<?php echo LANG_SELECT; ?>" class="inputsubmit"> 
		<input class="inputsubmit" type="submit" name="delete" value="<?php echo LANG_DELETE; ?>">
		<input type="submit" name="submit_new" value="<?php echo LANG_ADD_NEW; ?>" class="inputsubmit">
		</td>
		</tr>
		</table>
		<br> 
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
		<tr><td class="TableHeaderText" width="120">&nbsp;<?php echo LANG_TITLE_CAT; ?></td><td>&nbsp;</td></tr>
		<?php
if ((!$submit_new) && ($c_id)) {
    $cat = mysql_fetch_array(mysql_query("SELECT * FROM " . $db_table['categories'] . " WHERE ID=" . $c_id)); ?>
			<input type="hidden" name="old_name" value="<?php echo $cat['name']; ?>"> 
			<tr><td class="mainTable">&nbsp;<b><?php echo LANG_NAME; ?>:</b></td>
			<td class="mainTableAlt"><input type="text" name="name" value="<?php echo $cat['name']; ?>"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_HOST; ?>:</td>
			<td class="mainTableAlt"><input type="text" name="pophost" value="<?php echo $cat['pophost']; ?>"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_USER; ?>:</td>
			<td class="mainTableAlt"><input type="text" name="popuser" value="<?php echo $cat['popuser']; ?>"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_PASS; ?>:</td>
			<td class="mainTableAlt"><input type="password" name="poppass" value="<?php echo $cat['poppass']; ?>"></td></tr> 
			<tr><td class="mainTable">&nbsp;<b><?php echo LANG_EMAIL; ?>:</b></td>
			<td class="mainTableAlt"><input type="text" name="email" value="<?php echo $cat['email']; ?>"></td></tr> 
			<tr><td class="mainTable">&nbsp;<?php echo LANG_SIGNATURE; ?>:</td>
			<td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"><?php echo $cat['signature']; ?></textarea></td></tr> 
			<tr><td class="mainTable">&nbsp;<?php echo LANG_HIDDEN; ?>:</td>
			<td class="mainTableAlt"><input type="checkbox" name="hidden" <?php echo $cat['hidden'] ? ' CHECKED' : ''; ?>></td></tr>
			<tr><td class="mainTable">&nbsp;Reply Method:</td>
			<td class="mainTableAlt"><select name="reply_method">
				<option value="url" <?php echo $cat['reply_method'] == 'url' ? ' SELECTED' : ''; ?>>Send URL to load ticket</option>
				<option value="message" <?php echo $cat['reply_method'] == 'message' ? ' SELECTED' : ''; ?>>Show message in email</option>
			</select></td></tr>
			</table>
			<br>
			<input class="inputsubmit" type="submit" name="submit" value="<?php echo LANG_SAVE_CHANGES; ?>">
		<?php
} else { //add new
    
?>
			<tr><td class="mainTable">&nbsp;<b><?php echo LANG_NAME; ?>:</b></td>
			<td class="mainTableAlt"><input type="text" name="name"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_HOST; ?>:</td>
			<td class="mainTableAlt"><input type="text" name="pophost"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_USER; ?>:</td>
			<td class="mainTableAlt"><input type="text" name="popuser"></td></tr> 
			<tr><td class="mainTable">&nbsp;POP3&nbsp;<?php echo LANG_PASS; ?>:</td>
			<td class="mainTableAlt"><input type="password" name="poppass"></td></tr> 
			<tr><td class="mainTable">&nbsp;<b><?php echo LANG_EMAIL; ?>:</b></td>
			<td class="mainTableAlt"><input type="text" name="email"></td></tr> 
			<tr><td class="mainTable">&nbsp;<?php echo LANG_SIGNATURE; ?>:</td>
			<td class="mainTableAlt"><textarea name="sig" cols="30" rows="5"></textarea></td></tr>  
			<tr><td class="mainTable">&nbsp;<?php echo LANG_HIDDEN; ?>:</td>
			<td class="mainTableAlt"><input type="checkbox" name="hidden"></td></tr>
            <tr><td class="mainTable">&nbsp;Reply Method:</td>
			<td class="mainTableAlt">
			<select name="reply_method">
				<option value="url" SELECTED>Send URL to load ticket</option>
				<option value="message">Show message in email</option>
			</select>
			</td></tr>
            </table>
			<br>
			<input class="inputsubmit" type="submit" name="add" value="<?php echo LANG_CREATE_CAT; ?>">
		<?php
} ?>
</form>
</div>
