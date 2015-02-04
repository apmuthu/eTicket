<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<form name="pref" action="<?php echo $form_action; ?>" method="post">
  <input type="hidden" name="a" value="pref">
      <table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
        <tr>
          <td class="TableHeaderText" style="text-align: left;" width="100%"><a name="attach"></a><?php echo LANG_ATTACHMENTS; ?></td>
          <td></td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_ACC_ATTACH; ?>:</td>
          <td class="mainTableAlt">
            <input type="checkbox" name="accept_attachments" <?php echo htmlspecialchars($db_settings['accept_attachments']) ? ' checked' : ''; ?>>
            <b><?php echo LANG_WARNING; ?>:</b><?php echo LANG_ACC_ATTACH_TIP; ?></td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_MAX_FILE_SIZE; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="attachment_size" value="<?php echo htmlspecialchars($db_settings['attachment_size']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_ATTACH_URL_PATH; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" size="70" name="attachment_url" READONLY value="<?php echo htmlspecialchars($db_settings['attachment_url']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_ATTACH_DIR; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" size="70" name="attachment_dir" value="<?php echo htmlspecialchars($db_settings['attachment_dir']); ?>">
            <br><?php echo LANG_ATTACH_DIR_TIP; ?>
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_ACC_FILE_TYPES; ?>:</td>
          <td class="mainTableAlt"> 
            <table>
              <tr>
                <td> 
                  <select size="5" name="filetypes">
		              		<?php echo $vars['filetypes']; ?>
                  </select>
                </td>
                <td valign="top"> 
                  <input type="submit" name="remove_filetype" value="<?php echo LANG_REM_TYPE; ?>" class="inputsubmit" onClick='if(confirm("<?php echo LANG_DELETE_CONFIRM; ?>")) return; else return false;'>
                  <br>
                  <table>
                    <tr>
                      <td>
                        <input type="text" name="ext" size="4" maxlength="5">
                      </td>
                      <td>
                        <input type="submit" name="add_filetype" value="<?php echo LANG_ADD; ?>" class="inputsubmit">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
			<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
	<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
        <tr>
          <td class="TableHeaderText" style="text-align: left;" width="100%"><a name="captcha"></a><?php echo LANG_CAPTCHA; ?></td>
          <td></td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_ACC_CAPTCHA; ?>:</td>
          <td class="mainTableAlt">
            <input type="checkbox" name="accept_captcha" <?php echo htmlspecialchars($db_settings['accept_captcha']) ? ' checked' : ''; ?>>
           </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_CAPTCHA_TYPE ?>:</td>
          <td class="mainTableAlt">
             <select name="captcha_file">
		        <option value="captcha.php"<?php echo htmlspecialchars($db_settings['captcha_file']) == 'captcha.php' ? ' selected' : ''; ?>>Default</option>
                <option value="mathguard/ClassMathGuard.php" <?php echo htmlspecialchars($db_settings['captcha_file']) == 'mathguard/ClassMathGuard.php' ? ' selected' : ''; ?>>MathGuard</option>               
                <option value="securimage/securimage_show.php"<?php echo htmlspecialchars($db_settings['captcha_file']) == 'securimage/securimage_show.php' ? ' selected' : ''; ?>>Securimage</option>
                <option value="questcha/questcha.php"<?php echo htmlspecialchars($db_settings['captcha_file']) == 'questcha/questcha.php' ? ' selected' : ''; ?>>Questcha</option>
                <option value="securityimages/captchasecurityimages.php"<?php echo htmlspecialchars($db_settings['captcha_file']) == 'securityimages/captchasecurityimages.php' ? ' selected' : ''; ?>>SecurityImages</option>
             </select>
          </td>
        </tr>       
      </table>
			<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
      <table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
        <tr>
          <td class="TableHeaderText" style="text-align: left;" width="100%"><a name="mail"></a><?php echo LANG_MAIL; ?></td>
          <td></td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_MAIL_METHOD ?>:</td>
          <td class="mainTableAlt">
             <select name="mail_method">
                <option value="local"<?php echo htmlspecialchars($db_settings['mail_method']) == 'local' ? ' selected' : ''; ?>>Sendmail</option>
                <option value="smtp" <?php echo htmlspecialchars($db_settings['mail_method']) == 'smtp' ? ' selected' : ''; ?>>SMTP Server</option>
                <option value="mail" <?php echo htmlspecialchars($db_settings['mail_method']) == 'smtp' ? ' selected' : ''; ?>>PHP mail()</option>               
             </select>
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SENDMAIL_PATH; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="sendmail_path" value="<?php echo htmlspecialchars($db_settings['sendmail_path']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SMTP_HOST; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($db_settings['smtp_host']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SMTP_PORT; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="smtp_port" size="3" value="<?php echo htmlspecialchars($db_settings['smtp_port']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SMTP_AUTH; ?>:</td>
          <td class="mainTableAlt">
            <input type="checkbox" name="smtp_auth" <?php echo htmlspecialchars($db_settings['smtp_auth']) ? ' checked' : ''; ?>>
           </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SMTP_USER; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($db_settings['smtp_user']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SMTP_PASS; ?>:</td>
          <td class="mainTableAlt">
            <input type="password" name="smtp_pass" value="<?php echo htmlspecialchars($db_settings['smtp_pass']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_SAVE_EMAIL_HEADERS; ?>:</td>
          <td class="mainTableAlt">
            <input type="checkbox" name="save_headers"<?php echo htmlspecialchars($db_settings['save_headers']) ? ' checked' : ''; ?>>
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_MIN_EMAIL_INT; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="min_interval" value="<?php echo htmlspecialchars($db_settings['min_interval']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_MAX_OPEN_TICKETS; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="ticket_max" value="<?php echo htmlspecialchars($db_settings['ticket_max']); ?>">
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_REM_ORIGINAL_EMAIL; ?>:</td>
          <td class="mainTableAlt">
            <input type="checkbox" name="remove_original"<?php echo htmlspecialchars($db_settings['remove_original']) ? ' checked' : ''; ?>>
          </td>
        </tr>
        <tr>
          <td class="mainTable"><?php echo LANG_REM_TAG; ?>:</td>
          <td class="mainTableAlt">
            <input type="text" name="remove_tag" value="<?php echo htmlspecialchars($db_settings['remove_tag']); ?>">
          </td>
        </tr>
      </table>
			<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
			<tr>
				<td class="TableHeaderText" style="text-align: left;" width="100%"><a name="misc"></a><?php echo LANG_MISC; ?></td>
				<td></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_ROOT_URL; ?>:</td><td class="mainTableAlt">
					<input type="text" name="root_url" value="<?php echo htmlspecialchars($db_settings['root_url']); ?>">
				</td>
			</tr>
			<tr class="mainTable">
				<td><?php echo LANG_SEARCH_ON_MAIN; ?>:</td>
				<td class="mainTableAlt">
					<input type="checkbox" name="search_disp"<?php echo htmlspecialchars($db_settings['search_disp']) ? ' checked' : ''; ?>>
				</td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_PREF_TIMEZONE; ?>:</td>
				<td class="mainTableAlt">
					<select name="timezone">
                        <?php echo $vars['timezones']; ?>
					</select>
					<?php echo LANG_SYSTEM_TIMEZONE . ': ' . date('O'); ?>
				</td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_TICKETS_PP; ?>:</td>
				<td class="mainTableAlt">
					<select name="tickets_per_page">
                        <?php echo $vars['tickets_per_page']; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_TIME_FORMAT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="time_format" value="<?php echo htmlspecialchars($db_settings['time_format']); ?>"></td>
			</tr>
            <tr>
                <td class="mainTable"><?php echo LANG_SHOW_GRAPHIC; ?>:</td>
                <td class="mainTableAlt"><input type="checkbox" name="show_badge"<?php echo htmlspecialchars($db_settings['show_badge']) ? ' checked' : ''; ?>>  </td>
            </tr>
            <tr>
                <td class="mainTable"><?php echo LANG_UPGRADE_CHECK; ?>:</td>
                <td class="mainTableAlt">
                    <select name="upgrade_check">
                        <?php echo $vars['upgrade_check']; ?>
                    </select>
                </td>
            </tr>
		</table>
		<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
		
	<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
        <tr>
          	<td class="TableHeaderText" style="text-align: left;" width="100%"><a name="theme"></a><?php echo LANG_THEME; ?></td>
          	<td></td>
        </tr>
        <tr>
				<td class="mainTable"><?php echo LANG_CURRENT_THEME; ?>:</td>
				<td class="mainTableAlt">
					<select name="theme">
						<?php echo $vars['themes']; ?>
					</select>					
				</td>
			</tr>
      </table>
			<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
		
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
			<tr>
				<td class="TableHeaderText" style="text-align: left;" width="100%"><a name="settings"></a><?php echo LANG_SETTINGS; ?></td>
				<td></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SHORT_DATE_FORMAT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="short_date_format" value="<?php echo htmlspecialchars($db_settings['short_date_format']); ?>"></td>
			</tr>						
			<tr>
				<td class="mainTable"><?php echo LANG_CHARSET; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="charset" value="<?php echo htmlspecialchars($db_settings['charset']); ?>"></td>
			</tr>			
			<tr>
				<td class="mainTable"><?php echo LANG_PRESIG; ?>:</td>
				<td class="mainTableAlt">
					<textarea name="presig" id="presig" cols="56" rows="4" wrap="soft"><?php echo htmlspecialchars($db_settings['presig']); ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SITE_TITLE; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="site_title" value="<?php echo htmlspecialchars($db_settings['site_title']); ?>"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_NO_SUBJECT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="nosubject" value="<?php echo htmlspecialchars($db_settings['nosubject']); ?>"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_TICKET_FORMAT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="ticket_format" value="<?php echo htmlspecialchars($db_settings['ticket_format']); ?>"></td>
			</tr>
            <tr>
                <td class="mainTable"><?php echo LANG_FORCE_CATEGORY; ?>:</td>
                <td class="mainTableAlt"><input type="checkbox" name="force_category"<?php echo htmlspecialchars($db_settings['force_category']) ? ' checked' : ''; ?>>  </td>
            </tr>
            <tr>
                <td class="mainTable"><?php echo LANG_DEFAULT_CAT; ?>:</td>
                <td class="mainTableAlt">
                    <select name="default_category">
                    <?php echo $vars['default_category']; ?>
                    </select>
                </td>
            </td>
			<tr>
				<td class="mainTable"><?php echo LANG_SUBJECT_RE; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="subject_re" value="<?php echo htmlspecialchars($db_settings['subject_re']); ?>"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SPAM_WORD; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="spamword" value="<?php echo htmlspecialchars($db_settings['spamword']); ?>"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_FLOOD_MSG_RATE; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="flood_msg_rate" value="<?php echo htmlspecialchars($db_settings['flood_msg_rate']); ?>"></td>
			</tr>
		</table>
		<br><input class="inputsubmit" type="submit" name="submitpref" value="<?php echo LANG_SAVE_CHANGES; ?>"><br><br>
</form>

<br>
<form name="pref" action="<?php echo $form_action . '#predefined'; ?>" method="post">
  <input type="hidden" name="a" value="pref">
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
			<tr>
				<td class="TableHeaderText" style="text-align: left;" width="100%"><a name="predefined"></a><?php echo LANG_PREDEFINED; ?></td>
				<td></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_PREDEFINED; ?>:</td>
				<td class="mainTableAlt">
					<select name="answer">
						<?php echo $vars['predef_answers']; ?>
					</select>
					<input type="submit" name="answer_load" value="<?php echo LANG_LOAD; ?>" class="inputsubmit">
					<input type="submit" name="answer_remove" value="<?php echo LANG_REM; ?>" class="inputsubmit">
					<br>
					<input type="text" name="answer_key" value="<?php if ($_POST['answer']) {
    echo htmlspecialchars($_POST['answer']);
} ?>">
					<input type="submit" name="answer_add" id="answer_add" value="<?php echo LANG_ADD ?>" class="inputsubmit">
					<textarea name="answer_value" id="answer_value" cols="60" rows="6" wrap="soft"><?php if ($_POST['answer']) {
    echo htmlspecialchars($db_settings['predef_answers'][$_POST['answer']]);
} ?></textarea>
					<?php if ($_POST['answer']): ?>
					 <input type="submit" name="answer_save" value="<?php echo LANG_SAVE; ?>" class="inputsubmit">
					<?php
endif; ?>
				</td>
			</tr>
		</table>
</form>

<br>
<form name="pref" action="<?php echo $form_action . '#priority'; ?>" method="post">
  <input type="hidden" name="a" value="pref">
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableMsg">
			<tr>
				<td class="TableHeaderText" style="text-align: left;" width="100%"><a name="priority"></a><?php echo LANG_PRIORITY; ?></td>
				<td></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_PRIORITY; ?>:</td>
				<td class="mainTableAlt">
					<select name="pri">
						<?php echo $vars['pri']; ?>
					</select>
					<input type="submit" name="pri_load" value="<?php echo LANG_LOAD; ?>" class="inputsubmit">
					<input type="text" name="pri_text" value="<?php echo $vars['pri_text']; ?>">
					<input type="text" name="pri_style" value="<?php echo $vars['pri_style']; ?>">
					<?php if (isset($_POST['pri'])): ?>
					 <input type="submit" name="pri_save" value="<?php echo LANG_SAVE; ?>" class="inputsubmit">
					<?php
endif; ?>
				</td>
			</tr>
		</table>
</form>
