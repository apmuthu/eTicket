<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
?>

<!-- ticket details start -->
<table align="center" class="msgBorderInfo" cellspacing="1" cellpadding="3" width="100%" border="0">
	<tr>
		<td width="100" class="mainTable"><b><?php echo LANG_TICKET_ID; ?>:</b></td>
		<td class="mainTable"><?php echo $ticket->id ?></td>
	</tr>
	<tr>
		<td width="100" class="mainTable"><b><?php echo LANG_STATUS; ?>:</b></td>
		<td class="mainTable"><?php echo get_real_status_name($ticket->status); ?></td>
	</tr>
	<tr>
		<td width="100" class="mainTable"><b><?php echo LANG_DATE; ?>:</b></td>
		<td class="mainTable"><?php echo $ticket->short_time; ?></td>
	</tr>
	<tr>
		<td class="mainTable"><b><?php echo LANG_SUBJECT; ?>:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars(stripslashes($ticket->subject)); ?></td>
	</tr>
	<?php if ($ticket->name !== $ticket->email): ?>
	<tr>
		<td class="mainTable"><b><?php echo LANG_NAME; ?>:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars(stripslashes($ticket->name)); ?></td>
	</tr>
	<?php
endif; ?>
    <tr>
		<td class="mainTable"><b><?php echo LANG_EMAIL; ?>:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars($ticket->email); ?> [<a href="open.php?email=<?php echo htmlspecialchars($ticket->email); ?>"><?php echo LANG_NEW_TICKET; ?></a>]</td>
	</tr>
	<?php if ($ticket->ip): ?>
	<tr>
		<td class="mainTable"><b><?php echo LANG_IP; ?>:</b></td>
		<td class="mainTable"><a href="http://whoisx.co.uk/<?php echo $ticket->ip; ?>"><?php echo $ticket->ip; ?></a></td>
	</tr>	
	<?php
endif; ?>
	<?php if ($ticket->phone): ?>
	<tr>
		<td class="mainTable"><b><?php echo LANG_PHONE; ?>:</b></td>
		<td class="mainTable"><?php echo $ticket->phone; ?></td>
	</tr>
	<?php
endif; ?>
	<?php if ($pri): ?>
	<tr>
		<td class="mainTable"><b><?php echo LANG_PRIORITY; ?>:</b></td>
		<td class="mainTable"><?php echo $pri; ?></td>
	</tr>
	<?php
endif; ?>
   <tr>
   <td class="mainTable"><b><?php echo LANG_REP; ?>:</b></td>
   <td class="mainTable">
    <?php
if ($vars['reps']) {
?>
     <form name="rep" action="<?php echo $form_action; ?>" method="POST">
     <input type="hidden" name="a" value="transfer_rep">
       <input type="hidden" name="tid" value="<?php echo $ticket->id; ?>">
         <select name="rid">
             <option value="0"></option>
             <?php echo $vars['reps']; ?>
         </select>
         <input type="checkbox" title="<?php echo LANG_SEND_ALERT; ?>" name="trans_alert" checked>
         <input type="submit" name="submit_rep" value="<?php echo LANG_TRANSFER; ?>" class="inputsubmit">
     </form>
     <?php
} else {
    echo $rep_row['name'];
}
?>
     </td>
  </tr>
</table>
<!-- ticket details end -->

<!-- ticket category start -->
<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border="0">
	<tr>
		<td width="100" class="mainTable"><b><?php echo LANG_CAT; ?>:</b></td>
		<td class="mainTable">
			<?php if ($vars['cats']) { ?>
		  <form name="transfer" action="<?php echo $form_action; ?>" method="POST">
			<input type="hidden" name="a" value="transfer">
			<input type="hidden" name="tid" value="<?php echo $ticket->id; ?>">
      <table cellspacing="0" cellpadding="0" border="0">
      	<tr>
      		<td>
	          <select name="cid">
	    	    <?php echo $vars['cats']; ?>
	    	    </select>
    	    </td>
    	    <td>&nbsp;</td>
    	    <td><?php echo LANG_OPT_MSG; ?>:</td>
					<td><input type="text" size="20" name="add_msg"></td>
					<td><?php echo LANG_SEND_ALERT; ?>:</td>
					<td><input type="checkbox" title="<?php echo LANG_SEND_ALERT; ?>" name="trans_alert" checked></td>
					<td><input type="submit" name="transfer" value="<?php echo LANG_TRANSFER; ?>" class="inputsubmit"></td>
      	</tr>
      </table>
			</form>
			<?php
} else {
    echo $cat_row['name'];
}
?>
		</td>
	</tr>
</table>
<!-- ticket category end -->

<!-- transfer start -->
<?php
if ($ticket_row['trans_msg']): ?>
	<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
			<td width="100" class="mainTable"><b><?php echo LANG_TRANS_NOTE; ?>:</b></td>
			<td class="mainTable"><?php echo $ticket_row['trans_msg']; ?></td>
		</tr>
	</table>
<?php
endif; // $ticket_row['trans_msg']

?>
<!-- transfer end -->

<!-- private messages start -->
<?php
if ($_SESSION['user']['type'] == 'admin'):
    if ($vars['privmsg']):
?>
  <table class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr class="mainTable">
			<td valign="top" width="100"><b><?php echo LANG_PRIV_MSGS; ?></b></td>
			<td>
				<table id="privmsgs" cellspacing="1" cellpadding="3" width="100%" border="0">
				<?php echo $vars['privmsg']; ?>
  			</table>
			</td>
		</tr>
  </table>
<?php
    endif; // $vars['privmsg']
    
?>
	<p class="privmsgs_form">
		<form name="privmsgs" action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="a" value="post">
			<input type="hidden" name="tid" value="<?php echo $ticket->id; ?>">
			<input type="text" name="priv" id="priv" size="42">
			<input class="inputsubmit" type="submit" name="submit" value="<?php echo LANG_ADD; ?> <?php echo LANG_PRIV_MSG; ?>">
			<input type="file" name="attachment" id="attachment">
		</form>
	</p>
<?php
endif; //is admin

?>
<!-- private messages end -->

<!-- messages start -->
<?php echo $vars['messages'] ?>
<!-- messages end -->

<!-- replyform start -->
<div style="margin: auto">
  <form name="replyForm" action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="a" value="post">
	<input type="hidden" name="id" value="<?php echo $lastid; ?>">
		<table border="0" cellspacing="0" cellpadding="5">
			<tr> 
				<td valign="top">
					<div style="text-align: right" class="resizer">
						<a href="javascript:resizer(1,'d')" id="bigger"><?php echo LANG_BIGGER; ?></a>
						<a href="javascript:resizer(-1,'d')" id="smaller"><?php echo LANG_SMALLER; ?></a>
					</div>
					<textarea name="message" id="d" cols="60" rows="8" wrap="soft"></textarea>
					<input type="hidden" id="textarea_next_time" name="textarea_next_time" value="8">
	      </td>
	      <td valign="top">
<?php
//Predefined answer responses
if ($vars['predef']):
?>
<!-- predef start -->
<script language="javascript" type="text/javascript">
	function setMessage() {
		var newmessage = document.replyForm.responses.value;
		document.replyForm.message.value += newmessage;
		document.replyForm.message.focus();
	}
</script>
	<br>
	<select name="responses" onChange="setMessage()">
  	<option value="">[<?php echo LANG_PREDEFINED; ?>]</option>
  	<?php echo $vars['predef']; ?>
	</select>
<!-- predef end -->
<?php
endif; //Predefined answer responses

?>

<?php
if ($db_settings['accept_attachments']):
?>
<!-- attachments start -->
<br>
	<input type="file" name="attachment" id="attachment" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" />
	<div id="moreUploads"></div>
	<div id="moreUploadsLink" style="display:none;"><a href="javascript:addFileInput('moreUploads');">Attach another File</a></div>
<!-- attachments end -->
<?php
endif;
?>
<!-- reply buttons start -->
<table>
<?php
if ($_SESSION['user']['type'] === 'admin'):
?>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				<?php echo LANG_NEWSTATUS; ?> <select size="1" name="newstatus">
                <option value="awaitingcustomer"><?php echo LANG_AWAITINGCUSTOMER; ?></option>
                <option value="onhold"><?php echo LANG_ONHOLD; ?></option>
                <option value="closed"><?php echo LANG_CLOSED; ?></option>
                </select>
			</td>
		</tr>
		<tr>
            <td>
                <input class="inputsubmit" type="submit" name="change_status" value="<?php echo LANG_CHANGE_TICKET_STATUS; ?>">
            </td>
        </tr>
<?php
endif; // user admin

?>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				<input class="inputsubmit" type="submit" name="submit" value="<?php echo LANG_REPLY_TO_MSG; ?>">
			</td>
		</tr>
<?php
if (($_SESSION['user']['type'] == 'admin') && ($login[$a] || $login['ID'] == ADMIN)):
?>
	<tr>
		<td>
			<br>
			<input class="inputsubmit" type="submit" name="delete" value="<?php echo LANG_DELETE; ?>" onClick='if(confirm("<?php echo LANG_DELETE_CONFIRM; ?>")) return; else return false;'>
		</td>
	</tr>
<?php
endif; // user admin and access
if ($_SESSION['user']['type'] == 'client' && get_real_status_name($ticket->status) == 'Closed'):
?>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				<input class="inputsubmit" type="submit" name="reopen" value="<?php echo LANG_REOPEN; ?>">
			</td>
		</tr>
<?php endif; ?>
</table>
<!-- reply buttons end -->

		</td>
	</tr>
</table>
</form>
<!-- replyform end -->
</div>
<div id="backtomain" style="margin: auto; text-align: center;"><a href="<?php echo $vars['backurl']; ?>"><?php echo LANG_BACK_TO_MAIN; ?></a></div>
<a name="end"></a>
