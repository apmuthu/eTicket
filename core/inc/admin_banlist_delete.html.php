<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
?>

<form action="<?php echo $form_action; ?>" method="post">
<input type="hidden" name="a" value="<?php echo $a ? $a : 'banlist'; ?>">
<input type="hidden" name="e" value="<?php echo $e ? $e : 'delete'; ?>">
<p>
<input type="hidden" name="ab" value="D">
<?php
foreach($key as $reckey) {
?>
	<input type="hidden" name="key[]" value="<?php echo $reckey; ?>">
<?php
}
?>
<table border="0" cellspacing="1" cellpadding="4" class="TableMsg">
<tr>
<td class="TableHeaderText"><?php echo LANG_DELETE_BANNED; ?></td>
</tr>
<?php
foreach($items as $x_value) {
?>
	<tr class="mainTableAlt"><td><?php echo $x_value; ?></td></tr>
<?php
}
?>
</table>
<br>
<input class="inputsubmit" type="submit" name="Action" value="<?php echo LANG_CONFIRM_DELETE; ?>">
</form>
<a href="admin.php?a=banlist"><?php echo LANG_BACK_TO_LIST; ?></a>
