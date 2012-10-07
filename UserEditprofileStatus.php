<?php
$page = "UserEditprofileStatus";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['return_url'])) { $return_url = $_POST['return_url']; } elseif(isset($_GET['return_url'])) { $return_url = $_GET['return_url']; } else { $return_url = ""; }
if(isset($_POST['is_ajax'])) { $is_ajax = $_POST['is_ajax']; } elseif(isset($_GET['is_ajax'])) { $is_ajax = $_GET['is_ajax']; } else { $is_ajax = ""; }


$result = 0;

// check status feature
if($user->level_info[level_profile_status] != 1) {
  header("Location: UserEditprofile.php");
  exit();
}

// output blank page for ajax use
if($task == "blank") {
  echo "<html><head></head><body></body></html>";
  exit;
}

// save new status
if($task == "dosave") {
  $status_new = censor($_POST['status_new']);
  $database->database_query("UPDATE phps_users SET user_status='$status_new' WHERE user_id='".$user->user_info[user_id]."' LIMIT 1");
  $user->user_lastupdate();
  $user->user_info[user_status] = $status_new;

  // insert action if status is not empty
  if(str_replace(" ", "", $status_new) != "") {
    $actions->add($user, "editstatus", Array('[username]', '[status]'), Array($user->user_info[user_username], str_replace("&", "&amp;", $status_new)), 600);
  }

  $result = 1;

  // if this is being used by ajax - output blank page
  if($is_ajax == 1) { echo "<html><head></head><body></body></html>"; exit; }

  // if return url - go there
  if($return_url != "") { header("Location: $return_url"); exit; }
}


$uri_page = preg_replace('/\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// get tabs for top menu
$user->user_fields(1);
$tab_array = $user->profile_tabs;


$smarty->assign('tabs', $tab_array);
$smarty->assign('result', $result);
$smarty->assign('return_url', $return_url);
include "Footer.php";
?>