<?php
$page = "AdminEmails";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $setting_email_fromname = $_POST['setting_email_fromname'];
  $setting_email_fromemail = $_POST['setting_email_fromemail'];
  $setting_email_invitecode_subject = $_POST['setting_email_invitecode_subject'];
  $setting_email_invitecode_message = $_POST['setting_email_invitecode_message'];
  $setting_email_invite_subject = $_POST['setting_email_invite_subject'];
  $setting_email_invite_message = $_POST['setting_email_invite_message'];
  $setting_email_verify_subject = $_POST['setting_email_verify_subject'];
  $setting_email_verify_message = $_POST['setting_email_verify_message'];
  $setting_email_newpass_subject = $_POST['setting_email_newpass_subject'];
  $setting_email_newpass_message = $_POST['setting_email_newpass_message'];
  $setting_email_welcome_subject = $_POST['setting_email_welcome_subject'];
  $setting_email_welcome_message = $_POST['setting_email_welcome_message'];
  $setting_email_lostpassword_subject = $_POST['setting_email_lostpassword_subject'];
  $setting_email_lostpassword_message = $_POST['setting_email_lostpassword_message'];
  $setting_email_friendrequest_subject = $_POST['setting_email_friendrequest_subject'];
  $setting_email_friendrequest_message = $_POST['setting_email_friendrequest_message'];
  $setting_email_message_subject = $_POST['setting_email_message_subject'];
  $setting_email_message_message = $_POST['setting_email_message_message'];
  $setting_email_profilecomment_subject = $_POST['setting_email_profilecomment_subject'];
  $setting_email_profilecomment_message = $_POST['setting_email_profilecomment_message'];

  $database->database_query("UPDATE phps_settings SET 
			setting_email_fromname='$setting_email_fromname',
			setting_email_fromemail='$setting_email_fromemail',
			setting_email_invitecode_subject='$setting_email_invitecode_subject',
			setting_email_invitecode_message='$setting_email_invitecode_message',
			setting_email_invite_subject='$setting_email_invite_subject',
			setting_email_invite_message='$setting_email_invite_message',
			setting_email_verify_subject='$setting_email_verify_subject',
			setting_email_verify_message='$setting_email_verify_message',
			setting_email_newpass_subject='$setting_email_newpass_subject',
			setting_email_newpass_message='$setting_email_newpass_message',
			setting_email_welcome_subject='$setting_email_welcome_subject',
			setting_email_welcome_message='$setting_email_welcome_message',
			setting_email_lostpassword_subject='$setting_email_lostpassword_subject',
			setting_email_lostpassword_message='$setting_email_lostpassword_message',
			setting_email_friendrequest_subject='$setting_email_friendrequest_subject',
			setting_email_friendrequest_message='$setting_email_friendrequest_message',
			setting_email_message_subject='$setting_email_message_subject',
			setting_email_message_message='$setting_email_message_message',
			setting_email_profilecomment_subject='$setting_email_profilecomment_subject',
			setting_email_profilecomment_message='$setting_email_profilecomment_message'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = 1;
}

$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('setting_email_fromname', $setting[setting_email_fromname]);
$smarty->assign('setting_email_fromemail', $setting[setting_email_fromemail]);
$smarty->assign('setting_email_invitecode_subject', $setting[setting_email_invitecode_subject]);
$smarty->assign('setting_email_invitecode_message', $setting[setting_email_invitecode_message]);
$smarty->assign('setting_email_invite_subject', $setting[setting_email_invite_subject]);
$smarty->assign('setting_email_invite_message', $setting[setting_email_invite_message]);
$smarty->assign('setting_email_verify_subject', $setting[setting_email_verify_subject]);
$smarty->assign('setting_email_verify_message', $setting[setting_email_verify_message]);
$smarty->assign('setting_email_newpass_subject', $setting[setting_email_newpass_subject]);
$smarty->assign('setting_email_newpass_message', $setting[setting_email_newpass_message]);
$smarty->assign('setting_email_welcome_subject', $setting[setting_email_welcome_subject]);
$smarty->assign('setting_email_welcome_message', $setting[setting_email_welcome_message]);
$smarty->assign('setting_email_lostpassword_subject', $setting[setting_email_lostpassword_subject]);
$smarty->assign('setting_email_lostpassword_message', $setting[setting_email_lostpassword_message]);
$smarty->assign('setting_email_friendrequest_subject', $setting[setting_email_friendrequest_subject]);
$smarty->assign('setting_email_friendrequest_message', $setting[setting_email_friendrequest_message]);
$smarty->assign('setting_email_message_subject', $setting[setting_email_message_subject]);
$smarty->assign('setting_email_message_message', $setting[setting_email_message_message]);
$smarty->assign('setting_email_profilecomment_subject', $setting[setting_email_profilecomment_subject]);
$smarty->assign('setting_email_profilecomment_message', $setting[setting_email_profilecomment_message]);
$smarty->display("$page.tpl");
exit();
?>