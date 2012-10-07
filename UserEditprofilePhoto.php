<?php
$page = "UserEditprofilePhoto";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

if($user->level_info[level_photo_allow] == 0) { header("Location: Profile.php"); exit(); }


$is_error = 0;
$error_message = "";

if($task == "remove") { $user->user_photo_delete(); $user->user_lastupdate(); }

if($task == "upload") {
  $user->user_photo_upload("photo");
  $is_error = $user->is_error;
  $error_message = $user->error_message;
  if($is_error == 0) { 

    // save last update date
    $user->user_lastupdate(); 

    // size of thumbnails to show
    $photo_width = $misc->photo_size($user->user_photo(), "100", "100", "w");
    $photo_height = $misc->photo_size($user->user_photo(), "100", "100", "h");

 
    $actions->add($user, "editphoto", Array('[username]', '[photo]', '[width]', '[height]'), Array($user->user_info[user_username], $user->user_photo(), $photo_width, $photo_height), 999999999);

  }
}

$user->user_fields(1);
$tab_array = $user->profile_tabs;

$uri_page = preg_replace('/\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('tabs', $tab_array);
include "Footer.php";
?>