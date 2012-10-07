<?php
$page = "SignupVerify";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['verify'])) { $verify = $_POST['verify']; } elseif(isset($_GET['verify'])) { $verify = $_GET['verify']; } else { $verify = ""; }
if(isset($_POST['u'])) { $u = $_POST['u']; } elseif(isset($_GET['u'])) { $u = $_GET['u']; } else { $u = 0; }

// SET ERROR VARS
$is_error = 0;
$resend = 0;
$is_resend_error = 0;
$error_message = "";


// IF VERIFICATIONS ARE TURNED OFF, RETURN TO HOME
if($setting[setting_signup_verify] == 0) { header("Location: Home.php"); exit(); }


// VALIDATE USER ID
$new_user = new PHPS_User(Array($u));
if($new_user->user_exists == 0) {
  $is_error = 1;
}



// ENSURE NEW EMAIL NOT ALREADY TAKEN
if($database->database_num_rows($database->database_query("SELECT user_id FROM phps_users WHERE user_email='".$new_user->user_info[user_newemail]."' AND user_id<>'".$new_user->user_info[user_id]."'")) != 0) {
  $resend = 1;
  $is_resend_error = 1;
  $is_error = 1;
  $error_message = $signup_verify[1];
}


// VALIDATE VERIFICATION CODE
if($is_error == 0 & md5($new_user->user_info[user_code]) === $verify) {

  // GET NEW SUBNETWORK ID IF NECESSARY
  $subnet_changed = "";
  $subnet_changed_verify = "";
  $subnet_id = $new_user->user_info[user_subnet_id];
  if($setting[setting_subnet_field1_id] == 0 | $setting[setting_subnet_field2_id] == 0) {
    $new_subnet = $new_user->user_subnet_select($new_user->user_info[user_newemail], $new_user->profile_info);
    $subnet_id = $new_subnet[0];
    if($subnet_id != $new_user->user_info[user_subnet_id]) { $subnet_changed = $new_subnet[2]; }
  }

  $database->database_query("UPDATE phps_users SET user_subnet_id='$subnet_id', user_verified='1', user_email='".$new_user->user_info[user_newemail]."' WHERE user_id='".$new_user->user_info[user_id]."'");
 
  // SEND WELCOME EMAIL IF USER JUST SIGNED UP
  if($new_user->user_info[user_verified] == 0) {
    send_welcome($new_user->user_info);
  }
} else {
  $is_error = 1;
}




if($task == "resend") {
  $resend = 1;
  $resend_email = $_POST['resend_email'];
  $user_query = $database->database_query("SELECT user_id, user_email, user_code, user_username, user_verified, user_newemail FROM phps_users WHERE user_newemail='$resend_email'");

  // VERIFY USER EXISTS
  if($database->database_num_rows($user_query) != 1) {
    $is_resend_error = 1;
    $error_message = $signup_verify[4];
    $user_info['user_code'] = "";
    $user_info['user_email'] = "";
    $user_info['user_newemail'] = "";
    $user_info['user_verified'] = "";
  } else {
    $user_info = $database->database_fetch_assoc($user_query);
  }

  // VERIFY USER IS NOT ALREADY VERIFIED  
  if($user_info[user_verified] == 1 & $user_info[user_email] == $user_info[user_newemail]) {
    $is_resend_error = 1;
    $error_message = $signup_verify[5];
  }

  // NO ERROR, RESEND EMAIL
  if($is_resend_error == 0) {
    send_verification($user_info);
  }
}



// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('is_error', $is_error);
$smarty->assign('is_resend_error', $is_resend_error);
$smarty->assign('resend', $resend);
$smarty->assign('error_message', $error_message);
$smarty->assign('subnet_changed', $subnet_changed);
include "Footer.php";
?>