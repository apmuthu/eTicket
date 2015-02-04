<?php if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.''); ?>

<table width="100%" cellspacing="0" cellpadding="5" border="0" class="loginBox">
<?php if (isset($err)): ?>
  <tr><td class="error"><?php echo $err; ?></td></tr>
<?php
endif; ?>
	<tr><td><?php echo LANG_LOGIN_PLEASE; ?>:</td></tr>
	<tr>
    <td align="center">
		 <form action="<?php echo $form_action; ?>" method="post" name="admin_login">
			<table cellspacing="1" cellpadding="5" border="0" bgcolor="#000000">
					<tr>
			      <td bgcolor="#EEEEEE"><?php echo LANG_USER; ?>:</td>
			      <td bgcolor="#EEEEEE"><input class="inputform" type="text" name="login_user" size="20" value="<?php echo $em; ?>"></td>
			      <td bgcolor="#EEEEEE"><?php echo LANG_PASS; ?>:</td>
			      <td bgcolor="#EEEEEE"><input class="inputform" type="password" name="login_pass" size="10" value="<?php echo $tt; ?>"></td>
			      <td bgcolor="#EEEEEE"><input class="inputsubmit" type="submit" name="login" value="<?php echo LANG_LOGIN; ?>"></td>
					</tr>
			</table>
		 </form>
		</td>
	</tr>
</table>
