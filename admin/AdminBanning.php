<?php
$page = "AdminBanning";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  // GET VALUES AND REMOVE SPACES
  $banned_ips = str_replace(", ", ",", $_POST['banned_ips']);
  $banned_emails = str_replace(", ", ",", $_POST['banned_emails']);
  $banned_usernames = str_replace(", ", ",", $_POST['banned_usernames']);
  $banned_words = str_replace(", ", ",", $_POST['banned_words']);
  $comment_code = $_POST['comment_code'];
  $invite_code = $_POST['invite_code'];

  $database->database_query("UPDATE phps_settings SET 
			setting_banned_ips='$banned_ips', 
			setting_banned_emails='$banned_emails', 
			setting_banned_usernames='$banned_usernames',
			setting_banned_words='$banned_words',
			setting_comment_code='$comment_code',
			setting_invite_code='$invite_code'");
  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = 1;
}



// PUT SPACES BACK IN FOR PRESENTATION
$banned_ips = str_replace(",", ", ", $setting[setting_banned_ips]);
$banned_emails = str_replace(",", ", ", $setting[setting_banned_emails]);
$banned_usernames = str_replace(",", ", ", $setting[setting_banned_usernames]);
$banned_words = str_replace(",", ", ", $setting[setting_banned_words]);

$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);


// ASSIGN VARIABLES AND SHOW BANNING PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('setting_banned_ips', $banned_ips);
$smarty->assign('setting_banned_emails', $banned_emails);
$smarty->assign('setting_banned_usernames', $banned_usernames);
$smarty->assign('setting_banned_words', $banned_words);
$smarty->assign('setting_comment_code', $setting[setting_comment_code]);
$smarty->assign('setting_invite_code', $setting[setting_invite_code]);
$smarty->display("$page.tpl");
exit();
?>