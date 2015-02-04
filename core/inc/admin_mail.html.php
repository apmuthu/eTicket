<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
if ($_SESSION['user']['type'] !== 'admin') {
    die(LANG_ERROR_DENIED);
}
load_buttons();
?>

<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
<input type="hidden" name="a" value="mail">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_NEW_TICKET_REPLY; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_NEW_TICKET_REPLY_INFO; ?></td>
			</tr>
		</table>
		</td>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
				<tr>
					<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
					<td class="mainTableAlt">
						<input type="checkbox" name="ticket_response"<?php echo htmlspecialchars($db_settings['ticket_response']) ? ' checked' : ''; ?>>
					</td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
					<td class="mainTableAlt"><input type="text" name="ticket_subj" value="<?php echo htmlspecialchars($db_settings['ticket_subj']); ?>" size="45"></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
					<td class="mainTableAlt"><textarea rows="7" cols="45" name="ticket_msg"><?php echo htmlspecialchars($db_settings['ticket_msg']); ?></textarea></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
					<td class="mainTableAlt">
						%ticket: <?php echo LANG_TICKET_ID; ?><br>
						%subject: <?php echo LANG_VAR_SUBJECT; ?><br>
						%message: <?php echo LANG_VAR_MESSAGE; ?><br>
						%name: <?php echo LANG_VAR_NAME; ?><br>
						%email: <?php echo LANG_VAR_EMAIL; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_NEW_MSG_REPLY; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_NEW_MSG_REPLY_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
				<tr>
					<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
					<td class="mainTableAlt"><input type="checkbox" name="message_response"<?php echo htmlspecialchars($db_settings['message_response']) ? ' checked' : ''; ?>></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
					<td class="mainTableAlt"><input type="text" name="message_subj" value="<?php echo htmlspecialchars($db_settings['message_subj']); ?>" size="45"></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
					<td class="mainTableAlt"><textarea rows="7" cols="45" name="message_msg"><?php echo htmlspecialchars($db_settings['message_msg']); ?></textarea></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
					<td class="mainTableAlt">
						%ticket: <?php echo LANG_TICKET_ID; ?><br>
						%subject: <?php echo LANG_VAR_SUBJECT; ?><br>
						%name: <?php echo LANG_VAR_NAME; ?><br>
						%email: <?php echo LANG_VAR_EMAIL; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?><br>
                        %status: <?php echo LANG_TICKET_STATUS;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_TICKET_LIMIT_REPLY; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_TICKET_LIMIT_REPLY_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
				<tr>
					<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
					<td class="mainTableAlt">
						<input type="checkbox" name="limit_response"<?php echo htmlspecialchars($db_settings['limit_response']) ? 'checked' : ''; ?>>
					</td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_EMAIL; ?>:</td>
					<td class="mainTableAlt">
						<input type="text" name="limit_email" value="<?php echo htmlspecialchars($db_settings['limit_email']); ?>" size="45">
					</td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
					<td class="mainTableAlt"><input type="text" name="limit_subj" value="<?php echo htmlspecialchars($db_settings['limit_subj']); ?>" size="45"></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
					<td class="mainTableAlt"><textarea rows="7" cols="45" name="limit_msg"><?php echo htmlspecialchars($db_settings['limit_msg']); ?></textarea></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
					<td class="mainTableAlt">
						%ticket_max: <?php echo LANG_TICKET_MAX_VAR; ?><br>
						%user_email: <?php echo LANG_FROM_EMAIL; ?><br>
						%local_email: <?php echo LANG_VAR_EMAIL; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_CAT_TRANS_NOTICE; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_CAT_TRANS_NOTICE_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
				<tr>
					<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
					<td class="mainTableAlt"><input type="checkbox" name="trans_response" <?php echo htmlspecialchars($db_settings['trans_response']) ? 'checked' : ''; ?>></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
					<td class="mainTableAlt"><input type="text" name="trans_subj" value="<?php echo htmlspecialchars($db_settings['trans_subj']); ?>" size="45"></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
					<td class="mainTableAlt"><textarea rows="7" cols="45" name="trans_msg"><?php echo htmlspecialchars($db_settings['trans_msg']); ?></textarea></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
					<td class="mainTableAlt">
						%ticket: <?php echo LANG_TICKET_ID; ?><br>
						%category: <?php echo LANG_CAT_NAME_VAR; ?><br>
						%trans_msg: <?php echo LANG_TRANS_MSG_VAR; ?><br>
						%subject: <?php echo LANG_VAR_SUBJECT; ?><br>
						%name: <?php echo LANG_VAR_NAME; ?><br>
						%email: <?php echo LANG_VAR_EMAIL; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?><br>
                        %status: <?php echo LANG_TICKET_STATUS;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_EMAIL_ALERT; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_EMAIL_ALERT_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
			<tr>
				<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
				<td class="mainTableAlt"><input type="checkbox" name="alert_new"<?php echo htmlspecialchars($db_settings['alert_new']) ? ' checked' : ''; ?>></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_ADDR_TO_EMAIL; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="alert_user" value="<?php echo htmlspecialchars($db_settings['alert_user']); ?>" size="55"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_FROM_EMAIL; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="alert_email" value="<?php echo htmlspecialchars($db_settings['alert_email']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="alert_subj" value="<?php echo htmlspecialchars($db_settings['alert_subj']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
				<td class="mainTableAlt"><textarea rows="7" cols="45" name="alert_msg"><?php echo htmlspecialchars($db_settings['alert_msg']); ?></textarea></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
				<td class="mainTableAlt">
					%ticket: <?php echo LANG_TICKET_ID; ?><br>
					%email: <?php echo LANG_VAR_EMAIL; ?><br>
					%message: <?php echo LANG_MSG_VAR; ?><br>
					%url: <?php echo LANG_ROOT_URL; ?><br>
					%name: <?php echo LANG_VAR_NAME; ?><br>
					%datetime: <?php echo LANG_VAR_DATETIME; ?><br>
					%subject: <?php echo LANG_SUBJECT; ?><br>
					%category: <?php echo LANG_CAT; ?><br>
                    %status: <?php echo LANG_TICKET_STATUS;?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_ANSWER_MSG; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_ANSWER_MSG_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
				<tr>
					<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
					<td class="mainTableAlt"><input type="text" name="answer_subj" value="<?php echo htmlspecialchars($db_settings['answer_subj']); ?>" size="45"></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
					<td class="mainTableAlt"><textarea rows="7" cols="45" name="answer_msg"><?php echo htmlspecialchars($db_settings['answer_msg']); ?></textarea></td>
				</tr>
				<tr>
					<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
					<td class="mainTableAlt">
						%ticket: <?php echo LANG_TICKET_ID; ?><br>
						%category: <?php echo LANG_CAT_NAME_VAR; ?><br>
						%trans_msg: <?php echo LANG_TRANS_MSG_VAR; ?><br>
						%subject: <?php echo LANG_VAR_SUBJECT; ?><br>
						%name: <?php echo LANG_VAR_NAME; ?><br>
						%email: <?php echo LANG_VAR_EMAIL; ?><br>
						%answer: <?php echo LANG_ANSWER_MSG; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?><br>
                        %status: <?php echo LANG_TICKET_STATUS;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_REP_TRANS_NOTICE; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_REP_TRANS_NOTICE_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
			<tr>
				<td class="mainTable" width="120"><?php echo LANG_ENABLE; ?>:</td>
				<td class="mainTableAlt"><input type="checkbox" name="rep_trans_response"<?php echo htmlspecialchars($db_settings['rep_trans_response']) ? ' checked' : ''; ?>></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="rep_trans_subj" value="<?php echo htmlspecialchars($db_settings['rep_trans_subj']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
				<td class="mainTableAlt"><textarea rows="7" cols="45" name="rep_trans_msg"><?php echo htmlspecialchars($db_settings['rep_trans_msg']); ?></textarea></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
				<td class="mainTableAlt">
						%ticket: <?php echo LANG_TICKET_ID; ?><br>
						%subject: <?php echo LANG_VAR_SUBJECT; ?><br>
						%name: <?php echo LANG_VAR_NAME; ?><br>
						%email: <?php echo LANG_VAR_EMAIL; ?><br>
						%url: <?php echo LANG_ROOT_URL; ?><br>
						%rep_name: <?php echo LANG_REP_NAME_VAR; ?><br>
                        %status: <?php echo LANG_TICKET_STATUS;?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="TableMsg" width="100%">
				<td class="TableHeaderText" style="text-align: left; padding: 5px;" width="100%">
					<?php echo LANG_ANTISPAM; ?>
				</td>
			</tr>
			<tr>
				<td class="TableInfoText"><?php echo LANG_ANTISPAM_INFO; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" class="TableHeader">
			<tr>
				<td class="mainTable"><?php echo LANG_ANTISPAM_MAGICWORD; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="antispam_magicword" value="<?php echo htmlspecialchars($db_settings['antispam_magicword']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_SUBJECT; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="antispam_subject" value="<?php echo htmlspecialchars($db_settings['antispam_subject']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_MSG; ?>:</td>
				<td class="mainTableAlt"><textarea rows="7" cols="45" name="antispam_msg"><?php echo htmlspecialchars($db_settings['antispam_msg']); ?></textarea></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_FROM_EMAIL; ?>:</td>
				<td class="mainTableAlt"><input type="text" name="antispam_email" value="<?php echo htmlspecialchars($db_settings['antispam_email']); ?>" size="45"></td>
			</tr>
			<tr>
				<td class="mainTable"><?php echo LANG_VARS; ?>:</td>
				<td class="mainTableAlt">
					%ticket: <?php echo LANG_TICKET_ID; ?><br>
					%email: <?php echo LANG_VAR_EMAIL; ?><br>
					%message: <?php echo LANG_MSG_VAR; ?><br>
					%url: <?php echo LANG_ROOT_URL; ?><br>
					%name: <?php echo LANG_VAR_NAME; ?><br>
					%datetime: <?php echo LANG_VAR_DATETIME; ?><br>
					%subject: <?php echo LANG_SUBJECT; ?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<p><input class="inputsubmit" type="submit" name="submitmail" value="<?php echo LANG_SAVE_CHANGES; ?>"></p>
</form>
