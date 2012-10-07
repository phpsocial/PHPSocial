<?php
$page = "UserMessagesSettings";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// check for admin allowance for message
if($user->level_info[level_message_allow] == 0) { header("Location: Profile.php"); exit(); }

$result = 0;

// save new settings
if($task == "dosave") {
  $usersetting_notify_message = $_POST['usersetting_notify_message'];

  $database->database_query("UPDATE phps_usersettings SET usersetting_notify_message='$usersetting_notify_message' WHERE usersetting_user_id='".$user->user_info[user_id]."' LIMIT 1");
  $user->user_lastupdate();
  $user = new PHPS_User(Array($user->user_info[user_id]));
  $result = 1;
}

// assign user settings
$user->user_settings();

if ($_GET['ajax_call']) {
    $smarty->assign('ajax_call', 1);
}
$smarty->assign('page', $page);
$smarty->assign('result', $result);
include "Footer.php";
?>