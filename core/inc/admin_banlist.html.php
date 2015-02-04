<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<script type="text/javascript">
function validateForm(form) {
	var isValid = true;
	// Check each field individually
	if(form.x_value.value.length == 0) {
		msg = "<?php echo LANG_ERROR_VALUE_EMPTY; ?>";
		isValid = false;
	}
	// Show the error message to the user
	if(!isValid) alert(msg);
	return isValid;
}
</script>

<!-- search form start -->
<form action="<?php echo $form_action; ?>" name="banlist">
<input type="hidden" name="a" value="banlist">
<table border="0" cellspacing="0" cellpadding="4" align="center">
	<tr>
		<td><?php echo LANG_QUICK_SEARCH; ?>:</td>
		<td><input type="text" name="psearch" size="20" value="<?php echo $vars['pSearch']; ?>"></td>
			<td>
      <input class="inputsubmit" type="submit" name="submit" value="<?php echo LANG_SUBMIT; ?>">
      <a href="admin.php?a=banlist&amp;cmd=reset"><?php echo LANG_SHOW_ALL; ?></a>
		</td>
	</tr>
		<tr>
      <td>&nbsp;</td>
      <td colspan="2">
        <?php echo $vars['psearchtype']; ?>
      </td>
    </tr>
</table>
</form>
<!-- search form end -->
<br>
<!-- add form start -->
<form name="banlist_add" action="<?php echo $form_action; ?>" method="post" onsubmit="return validateForm(this);">
  <input type="hidden" name="a" value="banlist">
  <input type="hidden" name="e" value="add">
  <input type="hidden" name="ab" value="A">
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
	  <tr> 
		<td class="TableHeaderText"><?php echo LANG_ADD_TO_BANLIST; ?></td>
		</tr>
		<tr>
			<td class="mainTable">
				<input type="text" id="x_value" name="x_value" size="98" maxlength="255" value="">
				<input class="inputsubmit" type="submit" name="Action" value="<?php echo LANG_ADD; ?>">
			</td>
		</tr>
	</table>
</form>
<!-- add form end -->
<br>

<!-- main table start -->
<form name="form" action="<?php echo $form_action; ?>" method="post">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
    <tr>
      <td width="100%" valign="top">
<?php
if ($vars['main_table_content']):
?>
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
    <tr> 
      <td class="TableHeaderText" colspan="4">
        <?php echo LANG_TITLE_BANLIST; ?>
        <a href="admin.php?a=banlist&amp;order=value"><?php echo $vars['orderby']; ?></a>
      </td>
    </tr>
    <?php echo $vars['main_table_content']; ?>
  </table>
<?php
endif; //$vars['main_table_content']

?>
<?php if ($recActual > 1): ?>
  <input class="inputsubmit2" type="button" onClick="checkAll(this.form['key[]'])" value="<?php echo LANG_SELECT_ALL; ?>"> 
  <input class="inputsubmit2" type="button" onClick="uncheckAll(this.form['key[]'])" value="<?php echo LANG_UNSELECT; ?>">
<?php
endif; ?>
<?php if ($recActual > 0): ?>
  <br>
  <input class="inputsubmit" type="button" name="btndelete" value="<?php echo LANG_DEL_SEL; ?>" onClick="this.form.action='admin.php?a=banlist&amp;e=delete&amp;';this.form.submit();">
<?php
endif; ?>
<!-- pagination start -->
<?php
// display page numbers
echo $vars['pagination'];
?>
<!-- pagination end -->
      </td>
    </tr>
  </table>
</form>
<!-- main table end -->
