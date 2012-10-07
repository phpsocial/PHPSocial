<?php
$page = "LostpassReset";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['r'])) { $r = $_POST['r']; } elseif(isset($_GET['r'])) { $r = $_GET['r']; } else { $r = ""; }


// password request form
$submitted = 0;
$valid = 0;
$is_error = 0;
$error_message = "";

// assign user settings
$owner->user_settings();

// check validity of owner
if($owner->user_exists == 0) {
  $is_error = 1;
} elseif($owner->usersetting_info[usersetting_lostpassword_code] != $r | str_replace(" ", "", $owner->usersetting_info[usersetting_lostpassword_code]) == "") {
  $is_error = 1;
} elseif($owner->usersetting_info[usersetting_lostpassword_time] < (time()-86400)) {
  $is_error = 1;
} else {
  $valid = 1;
}


if($task == "reset" & $valid == 1) {

  $user_password = $_POST['user_password'];
  $user_password2 = $_POST['user_password2'];
  $submitted = 1;
  
  // check password
  $owner->user_password('', $user_password, $user_password, 0);
  $is_error = $owner->is_error;
  $error_message = $owner->error_message;

  
  // if no error - save changes
  if($is_error == 0) {

    // encrypt new password
    $password_new_crypt = crypt($user_password, $owner->user_salt);

    // save new password
    $database->database_query("UPDATE phps_users SET user_password='$password_new_crypt' WHERE user_id='".$owner->user_info[user_id]."' LIMIT 1");
    $database->database_query("UPDATE phps_usersettings SET usersetting_lostpassword_code='', usersetting_lostpassword_time='0' WHERE usersetting_user_id='".$owner->user_info[user_id]."' LIMIT 1");

  } else {
    $submitted = 0;
  }



}

$smarty->assign('submitted', $submitted);
$smarty->assign('valid', $valid);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('r', $r);
include "Footer.php";
?>