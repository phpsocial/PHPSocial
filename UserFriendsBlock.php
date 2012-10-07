<?php
$page = "UserFriendsBlock";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['confirm'])) { $confirm = $_POST['confirm']; } elseif(isset($_GET['confirm'])) { $confirm = $_GET['confirm']; } else { $confirm = 0; }

// ENSURE BLOCKING IS ALLOWED FOR THIS USER
if($user->level_info[level_profile_block] == 0) { header("Location: Home.php"); exit(); }

// CANCEL
if($task == "cancel") { header("Location: ".$url->url_create("profile", $owner->user_info[user_username])); exit(); }

// INITIALIZE VARS
$result = "";
$is_error = 0;

// BLOCK USER
if($task == "block") {

  // CHECK IF USER TO BE BLOCKED IS ALREADY BLOCKED
  if($user->user_blocked($owner->user_info[user_id])) { $result = $user_friends_block[3]; $confirm = 0; $is_error = 1; }

  // CHECK IF USER IS TRYING TO BLOCK THEMSELVES
  if($owner->user_info[user_id] == $user->user_info[user_id]) { $result = $user_friends_block[2]; $confirm = 0; $is_error = 1; }

  // DISPLAY ERROR PAGE IF NO OWNER
  if($owner->user_exists == 0) { $result = $user_friends_block[1]; $confirm = 0; $is_error = 1; }


  // DISPLAY ERROR IF NECESSARY
  if($is_error == 1) {
    $page = "error";
    $smarty->assign('error_header', $user_friends_block[4]);
    $smarty->assign('error_message', $result);
    $smarty->assign('error_submit', $user_friends_block[21]);
    include "Footer.php";
  }

  // BLOCK USER IF NO ERROR
  if($confirm == 1) {
    $new_blocklist = $user->user_info[user_blocklist].$owner->user_info[user_id].",";
    $database->database_query("UPDATE phps_users SET user_blocklist='$new_blocklist' WHERE user_id='".$user->user_info[user_id]."'");

    $user->user_friend_remove($owner->user_info[user_id]);

    $result = $user_friends_block[5]." ".$owner->user_info[user_username].".";
    $confirm = 0;

  // SHOW CONFIRMATION PAGE
  } else {
    $confirm = 1;
  }
}



// UNBLOCK USER
if($task == "unblock") {

  // CHECK IF USER TO BE UNBLOCKED IS NOT ALREADY BLOCKED
  if($user->user_blocked($owner->user_info[user_id]) == FALSE) { $result = $user_friends_block[13]; $confirm = 0; $is_error = 1; }

  // CHECK IF USER IS TRYING TO UNBLOCK THEMSELVES
  if($owner->user_info[user_id] == $user->user_info[user_id]) { $result = $user_friends_block[14]; $confirm = 0; $is_error = 1; }

  // DISPLAY ERROR PAGE IF NO OWNER
  if($owner->user_exists == 0) { $result = $user_friends_block[15]; $confirm = 0; $is_error = 1; }


  // DISPLAY ERROR IF NECESSARY
  if($is_error == 1) {
    $page = "error";
    $smarty->assign('error_header', $user_friends_block[4]);
    $smarty->assign('error_message', $result);
    $smarty->assign('error_submit', $user_friends_block[21]);
    include "Footer.php";
  }

  // UNBLOCK USER IF NO ERROR
  if($confirm == 1) {

    $blocklist = explode(",", $user->user_info[user_blocklist]);
    $user_key = array_search($owner->user_info[user_id], $blocklist);
    $blocklist[$user_key] = "";
    $user->user_info[user_blocklist] = implode(",", $blocklist);
    $database->database_query("UPDATE phps_users SET user_blocklist='".$user->user_info[user_blocklist]."' WHERE user_id='".$user->user_info[user_id]."'");

    $result = $user_friends_block[16]." ".$owner->user_info[user_username].".";
    $confirm = 0;

  // SHOW CONFIRMATION PAGE
  } else {
    $confirm = 1;
  }
}





// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('result', $result);
$smarty->assign('confirm', $confirm);
$smarty->assign('task', $task);
include "Footer.php";
?>