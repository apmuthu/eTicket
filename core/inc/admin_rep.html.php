<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<div class="admin" id="rep">
<form action="<?php echo $form_action; ?>" method="post">
  <input type="hidden" name="a" value="rep">
  <input type="hidden" name="r_id" value="<?php echo $vars['r_id'] ?>">
  <table border="0" cellspacing="0" cellpadding="0">
  	<tr>
  		<td>
  			<select name="r_id">
  				<option value=""></option>
  				<?php echo $vars['reps']; ?>
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
  	<tr>
  		<td class="TableHeaderText" width="120"><?php echo LANG_TITLE_REP; ?></td>
  		<td>&nbsp;</td>
  	</tr>
  
  	<tr>
  		<td class="mainTable"><b><?php echo LANG_USER; ?>:</b></td>
  		<td class="mainTableAlt">
  			<input type="hidden" name="old_username" value="<?php echo $vars['username']; ?>">
  			<input type="text" name="username" value="<?php echo $vars['username']; ?>">
  			<?php echo LANG_LOCKED; ?>? 
  			<input type="checkbox" name="locked"<?php echo $vars['locked']; ?>>
  		</td>
  	</tr>
  	<tr>
  		<td class="mainTable"><b><?php echo LANG_NAME; ?>:</b></td>
  		<td class="mainTableAlt">
  			<input type="hidden" name="old_name" value="<?php echo $vars['name']; ?>">
  			<input type="text" name="name" value="<?php echo $vars['name']; ?>">
  		</td>
  	</tr>
  	<tr>
  		<td class="mainTable"><b><?php echo LANG_EMAIL; ?>:</b></td>
  		<td class="mainTableAlt">
  			<input type="hidden" name="old_email" value="<?php echo $vars['email']; ?>">
  			<input type="text" name="email" value="<?php echo $vars['email']; ?>">
  			<?php echo LANG_NOMAIL; ?>? 
  			<input type="checkbox" name="nomail"<?php echo $vars['nomail']; ?>>
  		</td>
  	</tr>
  	<tr>
  		<td class="mainTable"><?php echo $vars['submit_type'] ? LANG_PASS : '<b>' . LANG_PASS . '</b>'; ?>:</td>
  		<td class="mainTableAlt">
  			<input type="hidden" name="password_hash" value="<?php echo $vars['password']; ?>">
  			<input type="password" name="password">
  		</td>
  	</tr>
  	<tr>
  		<td class="mainTable"><b><?php echo LANG_GROUP; ?>:</b></td>
  		<td class="mainTableAlt">
  			<select name="group">
  				<?php echo $vars['groups']; ?>
  			</select>
  		</td>
  	</tr>
  	<tr>
  		<td class="mainTable"><?php echo LANG_SIGNATURE; ?>:</td>
  		<td class="mainTableAlt">
  			<textarea name="sig" cols="30" rows="5"><?php echo $vars['signature']; ?></textarea>
  		</td>
  	</tr>
  </table>
  <br>
  <input class="inputsubmit" type="submit" name="<?php echo $vars['submit_name']; ?>" value="<?php echo $vars['submit_value']; ?>">
</form>
</div>
