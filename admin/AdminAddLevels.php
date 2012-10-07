<?php
$page = "AdminLevelsAdd";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

$is_error = 0;
$error_message = "";
$level_name = "";
$level_desc = "";


// create user level
if($task == "createlevel") {
  $level_name = $_POST['level_name'];
  $level_desc = $_POST['level_desc'];

  // make sure that user level has a name
  if(str_replace(" ", "", $level_name) == "") {
    $is_error = 1;
    $error_message = $admin_levels_add[7];
  }

  // CREATE USER LEVEL IF NO ERROR
  if($is_error == 0) {
    $database->database_query("INSERT INTO phps_levels (level_name,
					level_desc,
					level_signup,
					level_message_allow,
					level_message_inbox,
					level_message_outbox,
					level_profile_style,
					level_profile_block,
					level_profile_search,
					level_profile_privacy,
					level_profile_comments,
					level_profile_status,
					level_photo_allow,
					level_photo_width,
					level_photo_height,
					level_photo_exts
					) VALUES(
					'$level_name',
					'$level_desc',
					'0',
					'2',
					'10',
					'20',
					'1',
					'1',
					'1',
					'012345',
					'0123456',
					'1',
					'1',
					'200',
					'200',
					'jpg,jpeg,gif,png')");
    $level_id = $database->database_insert_id();
    header("Location: AdminEditLevels.php?level_id=$level_id");
    exit();
  }

}



// ASSIGN VARIABLES AND SHOW ADMIN ADD USER LEVEL PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('level_name', $level_name);
$smarty->assign('level_desc', $level_desc);
$smarty->display("$page.tpl");
exit();
?>