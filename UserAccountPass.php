<?php
$page = "UserAccountPass";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

$is_error = 0;
$error_message = "";
$result = 0;


// save new password
if($task == "dosave") {
  $password_old = $_POST['password_old'];
  $password_new = $_POST['password_new'];
  $password_new2 = $_POST['password_new2'];

  $user->user_password($password_old, $password_new, $password_new2);
  $is_error = $user->is_error;
  $error_message = $user->error_message;

  // save changes if no error
  if($is_error == 0) {

    $password_new_crypt = crypt($password_new, $user->user_salt);

    $database->database_query("UPDATE phps_users SET user_password='$password_new_crypt' WHERE user_id='".$user->user_info[user_id]."' LIMIT 1");
    $user = new PHPS_User(array($user->user_info[user_id]));

    // update cookies
    $user->user_setcookies(); 

    
    $result = 1;

  }
}

$smarty->assign('page', $page);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
include "Footer.php";
?>