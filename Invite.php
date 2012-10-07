<?php
$page = "Invite";
include "Header.php";

// display error page if user not logged in and admin settings is: required registration
if($user->user_exists == 0 || $setting[setting_permission_invite] == 0) {
  $page = "Error";
  $smarty->assign('error_header', $Application[151]);
  $smarty->assign('error_message', $Application[152]);
  $smarty->assign('error_submit', $Application[21]);
  include "Footer.php";
}

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


$is_error = "";
$result = "";

// check if invite codes set to admin only
if($setting[setting_signup_invite] == 1) {
  header("Location: Profile.php");
  exit();
}

// retrive and check the code
if($task != "main" && $setting[setting_invite_code] != 0) {
  session_start();
  $code = $_SESSION['code'];
  if($code == "") { $code = randomcode(); }
  $invite_secure = $_POST['invite_secure'];
  if($invite_secure != $code) {
    $is_error = 1;
    $error_message = $Application[168];
 }
}


// send invitation
if($task == "doinvite" AND $is_error != 1) {
  $invite_emails = $_POST['invite_emails'];
  $invite_message = $_POST['invite_message'];

  if($invite_emails == "") {
    $is_error = 1;
    $error_message = $Application[169];
  } else {
    if($setting[setting_signup_invite] == 0) {
      send_invitation($user->user_info, $invite_emails, $invite_message);
    } else {
      send_invitecode($user->user_info, $invite_emails, $invite_message);
    }
    $result = $Application[153];
  }
}


$smarty->assign('result', $result);
$smarty->assign('error_message', $error_message);
include "Footer.php";
?>