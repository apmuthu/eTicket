<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<div class="admin" id="user_group">
<form action="<?php echo $form_action; ?>" method="post">
	<input type="hidden" name="a" value="user_group">
	<input type="hidden" name="g_id" value="<?php echo $vars['g_id']; ?>">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<select name="g_id">
				<?php echo $vars['groups']; ?>
			</select>
		</td>
		<td>&nbsp;</td>
		<td>
			<input type="submit" name="select" value="<?php echo LANG_SELECT; ?>" class="inputsubmit"> 
			<input type="submit" name="delete" value="<?php echo LANG_DELETE; ?>" class="inputsubmit">
			<input type="submit" name="submit_new" value="<?php echo LANG_ADD_NEW; ?>" class="inputsubmit">
		</td>
	</tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
	<tr>
		<td width="120" class="TableHeaderText"><?php echo LANG_GROUP_ACCESS; ?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="mainTable"><b><?php echo LANG_NAME; ?>:</b></td>
		<td class="mainTableAlt">
			<input type="hidden" name="old_name" value="<?php echo $vars['name']; ?>">
			<input type="text" name="name" value="<?php echo $vars['name'] ?>">
		</td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_GROUPS; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="group"<?php echo $vars['user_group'] ? ' CHECKED' : ''; ?>></td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_REP; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="rep"<?php echo $vars['rep'] ? ' CHECKED' : ''; ?>></td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_CAT; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="cat"<?php echo $vars['cat'] ? ' CHECKED' : ''; ?>></td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_PREF; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="pref"<?php echo $vars['pref'] ? ' CHECKED' : ''; ?>></td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_MAIL; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="mail"<?php echo $vars['mail'] ? ' CHECKED' : ''; ?>></td>
	</tr>
	<tr>
		<td class="mainTable"><?php echo LANG_TITLE_BANLIST; ?>:</td>
		<td class="mainTableAlt"><input type="checkbox" name="banlist"<?php echo $vars['banlist'] ? ' CHECKED' : ''; ?>></td>
	</tr>
    <tr>
        <td class="mainTable"><?php echo LANG_TITLE_DB; ?>:</td>
        <td class="mainTableAlt"><input type="checkbox" name="db"<?php echo $vars['db'] ? ' CHECKED' : ''; ?>></td>
    </tr>
	<tr>
		<td class="mainTable"><?php echo LANG_CAT; ?>:</td>
		<td class="mainTableAlt">
			<?php echo $vars['cats']; ?>
		</td>
	</tr>
</table>
<br>
<input class="inputsubmit" type="submit" name="<?php echo $vars['submit_name']; ?>" value="<?php echo $vars['submit_value']; ?>">
</form>
</div>
