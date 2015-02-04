<?php
// Operational settings stored in settings.php instead of the settings table in the database
// This file provides default settings in case this is a first time install and we have no settings.
// DO NOT EDIT THIS FILE

if (!isset($db_settings['theme'])) {
    $settings['theme'] = 'eticket';
}

if (!isset($db_settings['site_title'])) {
    $settings['site_title'] = $_POST['site_title'];
}
if (!isset($db_settings['charset'])) {
    $settings['charset'] = 'UTF-8';
}
if (!isset($db_settings['presig'])) {
    $settings['presig'] = "\n\n";
}
if (!isset($db_settings['short_date_format'])) {
    $settings['short_date_format'] = 'm/d/Y';
}
if (!isset($db_settings['answer_subj'])) {
    $settings['answer_subj'] = "[#%ticket] %subject";
}
if (!isset($db_settings['answer_msg'])) {
    $settings['answer_msg'] = "%answer";
}
if (!isset($db_settings['pri'])) {
    $settings['pri'] = array(1, 2, 3);
}
if (!isset($db_settings['pri_text'])) {
    $settings['pri_text'] = array('Low', 'Normal', 'High');
}
if (!isset($db_settings['pri_style'])) {
    $settings['pri_style'] = array('class="priLow"', 'class="priNormal"', 'class="priHigh"');
}
if (!isset($db_settings['rep_trans_response'])) {
    $settings['rep_trans_response'] = 1;
}
if (!isset($db_settings['rep_trans_subj'])) {
    $settings['rep_trans_subj'] = '[#%ticket] Representative Transfer';
}
if (!isset($db_settings['rep_trans_msg'])) {
    $settings['rep_trans_msg'] = 'Ticket was transferred to representative %rep_name.';
}
if (!isset($db_settings['nosubject'])) {
    $settings['nosubject'] = '[No Subject]';
}
if (!isset($db_settings['ticket_format'])) {
    $settings['ticket_format'] = '\\\[#([0-9]{6})\\\]';
}
if (!isset($db_settings['subject_re'])) {
    $settings['subject_re'] = 'Re|Antw';
}
if (!isset($db_settings['spamword'])) {
    $settings['spamword'] = '[SPAM]';
}
if (!isset($db_settings['flood_msg_rate'])) {
    $settings['flood_msg_rate'] = 10;
}
if (!isset($db_settings['antispam_magicword'])) {
    $settings['antispam_magicword'] = 'ANTI_SPAM_MAGICWORD';
}
if (!isset($db_settings['antispam_subj'])) {
    $settings['antispam_subj'] = 'Ticked Rejected: Mail detected as SPAM';
}
if (!isset($db_settings['antispam_msg'])) {
    $settings['antispam_msg'] = 'Your email was detected as spam and has been rejected. If your email was not spam, please re-send your email, including the word "{MAGICWORD}" in the body of the email.';
}
if (!isset($db_settings['antispam_email'])) {
    $settings['antispam_email'] = $_POST['no_return'];
}
if (!isset($db_settings['accept_attachments'])) {
    $settings['accept_attachments'] = 0;
}
if (!isset($db_settings['attachment_size'])) {
    $settings['attachment_size'] = '1048576';
}
if (!isset($db_settings['attachment_dir'])) {
    $settings['attachment_dir'] = $_POST['attachment_dir'];
}
if (!isset($db_settings['attachment_url'])) {
    $settings['attachment_url'] = 'attachments.php';
}
if (!isset($db_settings['search_disp'])) {
    $settings['search_disp'] = 1;
}
if (!isset($db_settings['save_headers'])) {
    $settings['save_headers'] = 1;
}
if (!isset($db_settings['time_format'])) {
    $settings['time_format'] = 'l, F j Y g:ia';
}
if (!isset($db_settings['min_interval'])) {
    $settings['min_interval'] = 60;
}
if (!isset($db_settings['ticket_max'])) {
    $settings['ticket_max'] = 10;
}
if (!isset($db_settings['remove_original'])) {
    $settings['remove_original'] = 1;
}
if (!isset($db_settings['remove_tag'])) {
    $settings['remove_tag'] = '--please do not reply below this line--';
}
if (!isset($db_settings['ticket_response'])) {
    $settings['ticket_response'] = 1;
}
if (!isset($db_settings['ticket_msg'])) {
    $settings['ticket_msg'] = 'A support ticket has been created (#%ticket) and a representative will get back to you shortly.\r\n\r\nYou can view this ticket progress online here: %url/view.php?e=%email&t=%ticket\r\n\r\nNOTE: If you wish to send additional information regarding this ticket, please do not send another email. Instead, reply to this ticket.';
}
if (!isset($db_settings['ticket_subj'])) {
    $settings['ticket_subj'] = '[#%ticket] Support Ticket Opened';
}
if (!isset($db_settings['limit_reponse'])) {
    $settings['limit_response'] = 1;
}
if (!isset($db_settings['limit_email'])) {
    $settings['limit_email'] = $_POST['no_return'];
}
if (!isset($db_settings['limit_subj'])) {
    $settings['limit_subj'] = 'Ticket Denied';
}
if (!isset($db_settings['limit_msg'])) {
    $settings['limit_msg'] = 'Ticket was not created for the email sent to %local_email from %user_email because there is a limit of %ticket_max open tickets per email address at any one time.\r\n\r\nTo be able to open another ticket, you must close one of your previous tickets first here:\r\n%url/view.php';
}
if (!isset($db_settings['alert_new'])) {
    $settings['alert_new'] = 1;
}
if (!isset($db_settings['alert_email'])) {
    $settings['alert_email'] = $_POST['no_return'];
}
if (!isset($db_settings['alert_user'])) {
    $settings['alert_user'] = $_POST['admin_email'];
}
if (!isset($db_settings['alert_subj'])) {
    $settings['alert_subj'] = '[#%ticket] New Message Alert';
}
if (!isset($db_settings['alert_msg'])) {
    $settings['alert_msg'] = 'There is a new message for ticket %ticket\n\nFrom: %email\n\n%url/admin.php?a=view&id=%ticket';
}
if (!isset($db_settings['message_response'])) {
    $settings['message_response'] = 1;
}
if (!isset($db_settings['message_subj'])) {
    $settings['message_subj'] = '[#%ticket] Message Added';
}
if (!isset($db_settings['message_msg'])) {
    $settings['message_msg'] = 'Your reply to support ticket #%ticket has been noted.\r\n\r\nYou can view this ticket progress online here: %url/view.php?e=%email&t=%ticket';
}
if (!isset($db_settings['trans_response'])) {
    $settings['trans_response'] = 1;
}
if (!isset($db_settings['trans_subj'])) {
    $settings['trans_subj'] = '[#%ticket] Department Transfer';
}
if (!isset($db_settings['trans_msg'])) {
    $settings['trans_msg'] = 'Your ticket was transferred to the %cat_name department for further review.\n\n%trans_msg';
}
if (!isset($db_settings['timezone'])) {
    $settings['timezone'] = 0;
}
if (!isset($db_settings['tickets_per_page'])) {
    $settings['tickets_per_page'] = 10;
}
if (!isset($db_settings['root_url'])) {
    $settings['root_url'] = remove_trailing_slash($_POST[root_url]);
}
if (!isset($db_settings['filetypes'])) {
    $settings['filetypes'] = '.jpg;.gif;.png;.pdf;.xls;.txt;.doc;.eml;.zip;.mp3;';
}
if (!isset($db_settings['captcha_file'])) {
    $settings['captcha_file'] = 'captcha.php';
}
if (!isset($db_settings['accept_captcha'])) {
    $settings['accept_captcha'] = 0;
}
if (!isset($db_settings['force_category'])) {
    $settings['force_category'] = 0;
}
if (!isset($db_settings['default_category'])) {
    $settings['default_category'] = 1;
}
if (!isset($db_settings['mail_method'])) {
    $settings['mail_method'] = 'local';
}
if (!isset($db_settings['smtp_host'])) {
    $settings['smtp_host'] = 'localhost';
}
if (!isset($db_settings['smtp_port'])) {
    $settings['smtp_port'] = '25';
}
if (!isset($db_settings['smtp_auth'])) {
    $settings['smtp_auth'] = 0;
}
if (!isset($db_settings['smtp_user'])) {
    $settings['smtp_user'] = 'user';
}
if (!isset($db_settings['smtp_pass'])) {
    $settings['smtp_pass'] = 'pass';
}
if (!isset($db_settings['show_badge'])) {
    $settings['show_badge'] = 1;
}
if (!isset($db_settings['upgrade_check'])) {
    $settings['upgrade_check'] = 0;
}
if (!isset($db_settings['last_check'])) {
    $settings['last_check'] = '';
}
if (!isset($db_settings['last_result'])) {
    $settings['last_result'] = '';
}
if (!isset($db_settings['activation_key'])) {
    $settings['activation_key'] = '';
}
if (!isset($db_settings['sendmail_path'])) {
    $settings['sendmail_path'] = '/usr/sbin/sendmail';
}
?>