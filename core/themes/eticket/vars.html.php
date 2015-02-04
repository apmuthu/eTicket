<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
$html = array();
$html['option'] = '<option value="%s"%s>%s</option>';
$html['input'] = '<input type="%s" name="%s" value="%s"%s> %s';
$html['error'] = '<span id="err">%s</span>';
$html['end'] = '<a name="end"></a>';
$html['open']['submitmsg'] = '
<h3>' . LANG_OPENED_TICKET_SUBJECT . '</h3>
<p>' . nl2br(LANG_OPENED_TICKET_MSG) . '</p>
<p><a href="%s">%s</a></p>
';
$html['core.js'] = '<script language="JavaScript" type="text/javascript" src="core.js"></script>';
$html['open_form']['name'] = '<input type="%s" name="name" id="name" size="25" value="%s">';
$html['open_form']['email'] = '<input type="%s" name="email" id="email" size="25" value="%s">';
$html['open_form']['options'] = '<option value="%s"%s>%s</option>';
$html['open_form']['predef_js'] = '
			<script language="javascript" type="text/javascript">
			function setMessage() {
			var newmessage = document.openForm.responses.value;
			document.openForm.answer.value += newmessage;
			document.openForm.answer.focus();
			}
			</script>';
$html['banlist']['input'] = '<input type="%s" name="%s" value="%s"%s>%s';
$html['banlist']['main_table_content'] = '
    <tr class="mainTableAlt"> 
      <td width="20" align="center"><input type="checkbox" name="key[]" value="%s"></td>
      <td width="30" align="center"><a href="%s">' . LANG_EDIT . '</a></td>
      <td width="30" align="center"><a href="%s">' . LANG_COPY . '</a></td>
      <td>%s</td>
    </tr>';
$html['banlist']['prev'] = '<a href="admin.php?a=banlist&amp;start=%s"><b>' . LANG_PREV . '</b></a>';
$html['banlist']['next'] = '<a href="admin.php?a=banlist&amp;start=%s"><b>' . LANG_NEXT . '</b></a>';
$html['banlist']['b'] = '<strong>%s</strong>';
$html['banlist']['ab'] = '<a href="admin.php?a=banlist&amp;start=%s"><b>%s</b></a>';
$html['main_table'] = '
<table border="0" cellspacing="1" cellpadding="2" class="TableMsg" width="100%" align="center">
	  <tr>
	    <td>&nbsp;</td>
	    <td class="TableHeaderText" title="' . LANG_TIP_TICKET . '"><a href="?s=advanced&sort=ID&status=%status&way=%way">' . LANG_TICKET . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_DATE . '"><a href="?s=advanced&sort=timestamp&status=%status&way=%way">' . LANG_DATE . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_SUBJECT . '"><a href="?s=advanced&sort=subject&status=%status&way=%way">' . LANG_SUBJECT . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_CAT . '"><a href="?s=advanced&sort=cat&status=%status&way=%way">' . LANG_CAT . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_REP . '"><a href="?s=advanced&sort=rep&status=%status&way=%way">' . LANG_REP . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_PRIORITY . '"><a href="?s=advanced&sort=priority&status=%status&way=%way">' . LANG_PRIORITY . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_FROM . '"><a href="?s=advanced&sort=name&status=%status&way=%way">' . LANG_FROM . '</a></td>
	    <td class="TableHeaderText" title="Status"><a href="?s=advanced&sort=status&way=%way">Status</a></td>
	  </tr>
	  %content
</table>
';
$html['main_table_content'] = '
		  <tr class="{class}" onmouseover="this.className=\'mainTableOn\';" onmouseout="this.className=\'{class}\';">
		   <td align="center" class="checkbox">{checkbox}</td>
		   <td align="center" class="ticket"><a href="{page}?a=view&amp;id={id}">{id}</a></td>
		   <td align="center" class="date">{short_time}</td>
		   <td class="subject"><a href="{page}?a=view&amp;id={id}">{subject}</a></td>
		   <td class="cat">{cat_name}</td>
		   <td class="rep">{rep_name}</td>
		   <td {pri_style}>{pri_text}</td>
		   <td class="from"><a onClick="document.search.email.value=\'{email}\';" title="{email}">{name}</a></td>
		   <td align="center" class="ticket">{status}</td>
			</tr>
';
$html['main']['currentpage'] = '<span id="currentpage">%s</span>';
$html['main']['page'] = '<a href="%s">%s</a>';
$html['main']['no_tickets'] = '<p style="text-align: center;" id="no_tickets">' . LANG_NO_TICKETS . '</p>';
$html['main']['input'] = '<input type="%s" name="%s" class="%s">';
$html['viewticket']['pri_form'] = '<form name="pri" action="%s" method="POST">
				<input type="hidden" name="a" value="priority">
				<input type="hidden" name="tid" value="%s">
				<select name="pri">
				%s
				</select>
				<input type="submit" name="submit_pri" value="' . LANG_SUBMIT . '" class="inputsubmit">
				</form>';
$html['viewticket']['input_delete'] = '<input class="inputsubmit" type="submit" id="delete" name="delete" value="' . LANG_DELETE . '" onClick=\'if(confirm("' . LANG_DELETE_CONFIRM . '")) return; else return false;\'>';
$html['viewticket']['privmsgs'] = '
					<form name="privmsg" action="%s" method="POST">
					<input type="hidden" name="a" value="post">
					<input type="hidden" name="tid" value="%s">
					<input type="hidden" name="privid" value="%s">
					<tr class="mainTable">
						<td>
							<b>%s</b> <span class="datetime">(%s)</span>
							%s
							%s
							<p class="privmsg">%s</p>
						</td>
					</tr>
					</form>';
$html['viewticket']['attach'] = '<span class="msgAttachments"><a href="%s">%s</a> %s</span>';
$html['href'] = '<a href="%s">%s</a> %s';
$html['viewticket']['msgreceived'] = '
<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%%" border="0">
		<tr class="msgReceived">
			<td class="msgReceived"><span class="datetime">%s</span></td>
		</tr>
    %s
		<tr class="msgBox">
			<td align="left">
				%s
			</td>
		</tr>
</table>';
$html['viewticket']['msgattach'] = '
	 <tr class="msgAttachments">
	 	<td class="msgAttachments">%s</td>
	 </tr>';
$html['viewticket']['attachment'] = '<span class="attachments">' . LANG_ATTACHMENT . ': %s</span>';
$html['viewticket']['headers'] = '<span class="headers"><a href="admin.php?a=headers&amp;msg=%s" target="_new">[' . LANG_HEADERS . ']</a></span>';
$html['viewticket']['msganswered'] = '
<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%%" border="0">
			<tr class="msgAnswered">
				<td class="msgAnswered">
					<b>%s</b> <span class="datetime">(%s)</span>
				</td>
			</tr>
			%s
			<tr class="msgBox">
				<td align="left">
				  %s
				</td>
			</tr>
</table>';
$html['claim'] = '
<div id="claim-ticket">
	    <form name="claim" action="$form_action" method="POST">
	    	<input type="hidden" name="a" value="transfer_rep">
	    	<input type="hidden" name="tid" value="$ticketid">
	    	<input type="hidden" name="rid" value="$myuid">
	    	<p>$text <input type="submit" value="$submit_text"></p>
	    </form>
</div>';
$html['button'] = '
            <form action="admin.php?a=%s" method="POST" style="display: inline;">
         			<input class="inputsubmit" type="submit" id="%s" name="%s" value="%s">
         		</form>';
$html['buttons'] = '<div class="buttons">%s</div><br>';
?>
