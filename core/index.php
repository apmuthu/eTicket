<?php
require_once ('init.php');
$include = $site_header;
if (file_exists($include)) {
    include_once ($include);
}
if (function_exists('DisplayErrWarn')) {
    DisplayErrWarn();
}
if (file_exists('core.js')) {
    echo $html['core.js'];
}
?>
<div class="welcome">
<h2><?php echo LANG_WELCOME; ?></h2>
<p><?php echo LANG_LOGIN_TIP; ?></p>
</div>
<div class="openBox">
<hr>
<h2><?php echo LANG_OPEN_TICKET; ?></h2>
<?php include_once ('open_raw.php'); ?>
</div>
<div class="loginBox">
<hr>
<h2><?php echo LANG_VIEW_STATUS; ?></h2>
<form action="view.php" method="post">
<table cellspacing="0" cellpadding="3" border="0" class="loginBox">
    <tr> 
      <td><b><?php echo LANG_YOUR_EMAIL; ?>:</b></td>
      <td><input class="inputform" type="text" name="login_email" size="25" value="<?php echo $e; ?>"></td>
      <td><b><?php echo LANG_TICKET_ID; ?>:</b></td>
      <td><input class="inputform" type="text" name="login_ticket" size="10" value="<?php echo $t; ?>"></td>
      <td><input class="inputsubmit" type="submit" value="<?php echo LANG_VIEW_STATUS; ?>"></td>
    </tr>
</table>
</form>
</div>
<?php $include = $site_footer;
if (file_exists($include)) {
    include_once ($include);
} ?>
