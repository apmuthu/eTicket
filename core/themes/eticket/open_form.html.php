<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
?>

<form name="openForm" action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
<table cellpadding="3" cellspacing="0" class="formTable">
	<tr>
		<td align="left"><b><?php echo LANG_NAME; ?>:</b></td>
		<td><?php echo $vars['name_html']; ?></td>
	</tr>
	<tr>
		<td align="left"><b><?php echo LANG_EMAIL; ?>:</b></td>
		<td><?php echo $vars['email_html']; ?></td>
	</tr>
<?php if (!$login): ?>
	<tr>
		<td align="left"><b><?php echo LANG_EMAIL_CONFIRM; ?>:</b></td>
		<td><input type="text" name="email_confirm" id="email_confirm" size="25" value="<?php echo $vars['email_confirm']; ?>"></td>
	</tr>
<?php
endif; ?>
	<tr>
		<td align="left"><?php echo LANG_PHONE; ?>:</td>
		<td><input type="text" name="phone" id="phone" size="25" value="<?php echo $vars['phone']; ?>"></td>
	</tr>
	<!--
	<p>Note: This is an example of an "extra" field, the details will be added to the end of the message.</p>
	<tr>
		<td align="left"><?php echo LANG_USER; ?>:</td>
		<td><input type="text" name="e[user]" id="extra" size="25" value="<?php echo htmlspecialchars($_POST['e']['user']); ?>"></td>
	</tr>
	-->
<?php if ($db_settings['force_category']) { ?>
    <input type="hidden" name="cat" value="<?php echo $db_settings['default_category']; ?>">
    <?php
} else {
?>
	    <tr>
		<td align="left"><b><?php echo LANG_DEPT; ?>:</b></td>
		<td>
			<select name="cat">
			<?php echo $vars['cat_options']; ?>
			</select>
		</td>
	</tr>
<?php
} ?>
	<tr>
		<td align="left"><b><?php echo LANG_SUBJECT; ?>:</b></td>
		<td><input type="text" name="subject" id="subject" size="35" value="<?php echo $vars['subject']; ?>"></td>
	</tr>
	<tr>
		<td align="left" valign="top"><b><?php echo LANG_MSG; ?>:</b></td>
		<td>
			<textarea name="message" id="message" cols="30" rows="6"><?php echo $vars['message']; ?></textarea>
<?php if (file_exists('core.js') && !defined('NO_JS')): ?>
			<div style="text-align: right" class="resizer">
				<a href="javascript:resizer(1,'message')" id="bigger"><?php echo LANG_BIGGER; ?></a>
				<a href="javascript:resizer(-1,'message')" id="smaller"><?php echo LANG_SMALLER; ?></a>
			</div>
<?php
endif; ?>
		</td>
	</tr>
<?php
if ($login && $_SESSION['user']['type'] === 'admin'):
?>
	<tr>
		<td align="left" valign="top"><b><?php echo LANG_ANSWER; ?>:</b></td>
		<td>
			<textarea name="answer" id="answer" cols="30" rows="6"><?php echo $vars['answer']; ?></textarea>
<?php if (file_exists('core.js') && !defined('NO_JS')): ?>
			<div style="text-align: right" class="resizer">
				<a href="javascript:resizer(1,'answer')" id="bigger"><?php echo LANG_BIGGER; ?></a>
				<a href="javascript:resizer(-1,'answer')" id="smaller"><?php echo LANG_SMALLER; ?></a>
			</div>
<?php
    endif; ?>

<?php
    //Predefined answer responses MOD START
    if ((!empty($db_table['answers'])) && ($_SESSION['user']['type'] === 'admin')):
?>
		<br>
		<select name="responses" onChange="setMessage()">
		<option value="">[<?php echo LANG_PREDEFINED; ?>]</option>
<?php echo $vars['response_options'] ?>
		</select>
<?php
    endif;
    //Predefined answer responses MOD END
    
?>

		</td>
	</tr>
<?php
endif;
?>
	<tr>
		<td align="left"><?php echo LANG_PRIORITY; ?>:</td>
		<td>
			<select name="pri" id="pri">
			<?php echo $vars['pri_options']; ?>
			</select>
		</td>
	</tr>

<?php
//CAPTCHA MOD - START
if ((file_exists('captcha/' . $db_settings['captcha_file'])) && ($_SESSION['user']['type'] != 'admin') && $db_settings['accept_captcha'] == 1):
?>
	<tr valign="middle">		
	<?php if ($db_settings['captcha_file'] == 'captcha.php') { ?>
		<td align="left" nowrap><b><?php echo LANG_CAPTCHA_TITLE; ?>:</b></td>
		<td>
			<img src="captcha/<?php echo $db_settings['captcha_file']; ?>" alt="<?php echo LANG_CAPTCHA_TITLE; ?>">
			<input id="captcha_input" name="captcha_input" type="text" value="" size="8" maxlength="6" onClick="document.forms[0].captcha_input.value='';"/>
		</td>
	<?php
    } elseif ($db_settings['captcha_file'] == 'mathguard/ClassMathGuard.php') { ?>
		<td align="left" nowrap><b><?php echo LANG_CAPTCHA_QUESTION_TITLE; ?>:</b></td>
		<td>
			<?php require ("captcha/" . $db_settings['captcha_file']);
        MathGuard::insertQuestion(); ?>
		<input id="captcha_input" name="captcha_input" type="text" value="" size="8" maxlength="6" onClick="document.forms[0].captcha_input.value='';"/>
		</td>			 
	<?php
    } elseif ($db_settings['captcha_file'] == 'securimage/securimage_show.php') {
?>
		<td align="left" nowrap><b><?php echo LANG_CAPTCHA_TITLE; ?>:</b></td>
		<td>
			<img src="captcha/<?php echo $db_settings['captcha_file']; ?>?sid=<?php echo md5(uniqid(time())); ?>" alt="<?php echo LANG_CAPTCHA_TITLE; ?>">
			<input id="captcha_input" name="captcha_input" type="text" value="" size="8" maxlength="6" onClick="document.forms[0].captcha_input.value='';"/>
		</td>
	<?
    } elseif ($db_settings['captcha_file'] == 'questcha/questcha.php') { ?>
		<td align="left" nowrap><b><?php echo LANG_CAPTCHA_QUESTION_TITLE ?>:</b></td>
		<td>
			<?php require ("captcha/" . $db_settings['captcha_file']); ?>
			<input id="captcha_input" name="captcha_input" type="text" value="" size="10" maxlength="50" onClick="document.forms[0].captcha_input.value='';"/>
		</td>			 
	<?php

	} elseif ($db_settings['captcha_file'] == 'securityimages/captchasecurityimages.php') { ?>
		<td align="left" nowrap><b><?php echo LANG_CAPTCHA_TITLE; ?>:</b></td>
		<td>
			<img src="captcha/<?php echo $db_settings['captcha_file']; ?>?width=100&height=40&characters=5" /><br />			
			<input id="captcha_input" name="captcha_input" type="text" value="" size="8" maxlength="6" onClick="document.forms[0].captcha_input.value='';"/>
		</td>			 
	<?php
    }
?>		
	</tr>
<?php
endif;
//CAPTCHA MOD - END

?>

<?php if ($db_settings['accept_attachments']): ?>
	<tr>
		<td><?php echo LANG_ATTACHMENT; ?>:</td>
		<td>
			<input type="file" name="attachment" id="attachment" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" />
			<div id="moreUploads"></div>
			<div id="moreUploadsLink" style="display:none;"><a href="javascript:addFileInput('moreUploads');">Attach another File</a></div>
		</td>
	</tr>
<?php
endif; // end accept attachments

?>

	<tr>
		<td>&nbsp;</td>
		<td>
			<input class="inputsubmit" type="submit" name="submit_x" value="<?php echo LANG_OPEN_TICKET; ?>">
			<input class="inputsubmit" type="reset" value="<?php echo LANG_RESET; ?>">
		</td>
	</tr>
</table>
</form>
