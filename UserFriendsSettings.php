<?php
$page = "UserFriendsSettings";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// ensure that connection are allowed for this user
if($setting[setting_connection_allow] == 0) { header("Location: Profile.php"); exit(); }

$result = 0;

// save new settings
if($task == "dosave") {
  $usersetting_notify_friendrequest = $_POST['usersetting_notify_friendrequest'];

  $database->database_query("UPDATE phps_usersettings SET usersetting_notify_friendrequest='$usersetting_notify_friendrequest' WHERE usersetting_user_id='".$user->user_info[user_id]."'");
  $user->user_lastupdate();
  $user = new PHPS_User(Array($user->user_info[user_id]));
  $result = 1;
}

$user->user_settings();

$uri_page = preg_replace('/\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

$smarty->assign('result', $result);
include "Footer.php";
?>