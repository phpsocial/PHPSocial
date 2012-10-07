<?php
$page = "AdminLevelsUsersettings";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_POST['level_id'])) { $level_id = $_POST['level_id']; } elseif(isset($_GET['level_id'])) { $level_id = $_GET['level_id']; } else { $level_id = 0; }

// VALIDATE LEVEL ID
$level = $database->database_query("SELECT * FROM phps_levels WHERE level_id='$level_id'");
if($database->database_num_rows($level) != 1) { 
  header("Location: AdminLevels.php");
  exit();
}
$level_info = $database->database_fetch_assoc($level);

// SET RESULT AND ERROR VARS
$result = 0;
$is_error = 0;
$error_message = "";



// SAVE CHANGES
if($task == "dosave") {
  $photo_allow = $_POST['photo_allow'];
  $photo_width = $_POST['photo_width'];
  $photo_height = $_POST['photo_height'];
  $photo_exts = $_POST['photo_exts'];
  $profile_style = $_POST['profile_style'];
  $profile_status = $_POST['profile_status'];
  $level_profile_block = $_POST['level_profile_block'];
  $level_profile_search = $_POST['profile_search'];

  $profile_privacy_0 = $_POST['profile_privacy_0'];
  $profile_privacy_1 = $_POST['profile_privacy_1'];
  $profile_privacy_2 = $_POST['profile_privacy_2'];
  $profile_privacy_3 = $_POST['profile_privacy_3'];
  $profile_privacy_4 = $_POST['profile_privacy_4'];
  $profile_privacy_5 = $_POST['profile_privacy_5'];
  $level_profile_privacy = $profile_privacy_0.$profile_privacy_1.$profile_privacy_2.$profile_privacy_3.$profile_privacy_4.$profile_privacy_5;
  $profile_comments_0 = $_POST['profile_comments_0'];
  $profile_comments_1 = $_POST['profile_comments_1'];
  $profile_comments_2 = $_POST['profile_comments_2'];
  $profile_comments_3 = $_POST['profile_comments_3'];
  $profile_comments_4 = $_POST['profile_comments_4'];
  $profile_comments_5 = $_POST['profile_comments_5'];
  $profile_comments_6 = $_POST['profile_comments_6'];
  $level_profile_comments = $profile_comments_0.$profile_comments_1.$profile_comments_2.$profile_comments_3.$profile_comments_4.$profile_comments_5.$profile_comments_6;

  // LOOP THROUGH EXTENSIONS AND CHECK FOR INVALID FILE TYPES
  $extensions = explode(",", str_replace(" ", "", $photo_exts));
  for($e=0;$e<count($extensions);$e++) {
    if($extensions[$e] != "" & $extensions[$e] != "jpg" & $extensions[$e] != "jpeg" & $extensions[$e] != "gif" & $extensions[$e] != "png") {
      $is_error = 1;
      $error_message = $admin_levels_usersettings[9];
    }
  }

  // CHECK THAT A NUMBER BETWEEN 1 AND 999 WAS ENTERED FOR WIDTH AND HEIGHT
  if(!is_numeric($photo_width) OR !is_numeric($photo_height) OR $photo_width < 1 OR $photo_height < 1 OR $photo_width > 999 OR $photo_height > 999) {
    $is_error = 1;
    $error_message = $admin_levels_usersettings[8];
  }

  // SAVE SETTINGS IF NO ERROR
  if($is_error == 0) {
    $database->database_query("UPDATE phps_levels SET 
			level_profile_search='$level_profile_search',
			level_profile_privacy='$level_profile_privacy',
			level_profile_block='$level_profile_block',
			level_profile_comments='$level_profile_comments',
			level_photo_allow='$photo_allow',
			level_photo_width='$photo_width',
			level_photo_height='$photo_height',
			level_photo_exts='$photo_exts',
			level_profile_style='$profile_style',
			level_profile_status='$profile_status' WHERE level_id='$level_id'");
    if($level_profile_search == 0) { $database->database_query("UPDATE phps_users SET user_privacy_search='1' WHERE user_level_id='$level_id'"); }
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_levels WHERE level_id='$level_id'"));

    $result = 1;
  }
}



// GET PREVIOUS PRIVACY SETTINGS
$count = 0;
while($count < 6) {
  if(user_privacy_levels($count) != "") {
    if(strpos($level_info[level_profile_privacy], "$count") !== FALSE) { $privacy_selected = 1; } else { $privacy_selected = 0; }
    $privacy_options[$count] = Array('privacy_name' => "profile_privacy_".$count,
				'privacy_value' => $count,
				'privacy_option' => user_privacy_levels($count),
				'privacy_selected' => $privacy_selected);
  }
  $count++;
}
$count = 0;
while($count < 10) {
  if(user_privacy_levels($count) != "") {
    if(strpos($level_info[level_profile_comments], "$count") !== FALSE) { $comment_selected = 1; } else { $comment_selected = 0; }
    $comment_options[$count] = Array('comment_name' => "profile_comments_".$count,
				'comment_value' => $count,
				'comment_option' => user_privacy_levels($count),
				'comment_selected' => $comment_selected);
  }
  $count++;
}



// ASSIGN VARIABLES AND SHOW GENERAL USER SETTINGS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('error_message', $error_message);
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('photo_allow', $level_info[level_photo_allow]);
$smarty->assign('photo_width', $level_info[level_photo_width]);
$smarty->assign('photo_height', $level_info[level_photo_height]);
$smarty->assign('photo_exts', $level_info[level_photo_exts]);
$smarty->assign('profile_style', $level_info[level_profile_style]);
$smarty->assign('profile_status', $level_info[level_profile_status]);
$smarty->assign('profile_block', $level_info[level_profile_block]);
$smarty->assign('profile_search', $level_info[level_profile_search]);
$smarty->assign('profile_privacy', $privacy_options);
$smarty->assign('profile_comments', $comment_options);
$smarty->display("$page.tpl");
exit();
?>