<?php
$page = "UserEditprofileSettings";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// SET VARS
$result = 0;


// SAVE NEW SETTINGS
if($task == "dosave") {
  $style_profile = addslashes(str_replace("-moz-binding", "", strip_tags(htmlspecialchars_decode($_POST['style_profile'], ENT_QUOTES))));
  $privacy_profile = $_POST['privacy_profile'];
  $comments_profile = $_POST['comments_profile'];
  $search_profile = $_POST['search_profile'];
  $usersetting_notify_profilecomment = $_POST['usersetting_notify_profilecomment'];

  // SET STYLE TO NOTHING IF NOT ALLOWED
  if($user->level_info[level_profile_style] != 1) { $style_profile = ""; }

  // MAKE SURE SUBMITTED PRIVACY OPTIONS ARE ALLOWED, IF NOT, SET TO EVERYONE
  if(!strstr($user->level_info[level_profile_privacy], $privacy_profile)) { $privacy_profile = 0; }
  if(!strstr($user->level_info[level_profile_comments], $comments_profile)) { $comments_profile = 0; }

  // UPDATE DATABASE
  $database->database_query("UPDATE phps_users SET user_privacy_profile='$privacy_profile', user_privacy_comments='$comments_profile', user_privacy_search='$search_profile' WHERE user_id='".$user->user_info[user_id]."'");
  $database->database_query("UPDATE phps_usersettings SET usersetting_notify_profilecomment='$usersetting_notify_profilecomment' WHERE usersetting_user_id='".$user->user_info[user_id]."'");
  $database->database_query("UPDATE phps_profilestyles SET profilestyle_css='$style_profile' WHERE profilestyle_user_id='".$user->user_info[user_id]."'");
  $user->user_lastupdate();
  $user = new PHPS_User(Array($user->user_info[user_id]));
  $result = 1;
}



// GET TABS TO DISPLAY ON TOP MENU
$user->user_fields(1);
$tab_array = $user->profile_tabs;

// GET THIS USER'S PROFILE CSS
$style_query = $database->database_query("SELECT profilestyle_css FROM phps_profilestyles WHERE profilestyle_user_id='".$user->user_info[user_id]."' LIMIT 1");
if($database->database_num_rows($style_query) == 1) { 
  $style_info = $database->database_fetch_assoc($style_query); 
} else {
  $database->database_query("INSERT INTO phps_profilestyles (profilestyle_user_id, profilestyle_css) VALUES ('".$user->user_info[user_id]."', '')");
  $style_info = $database->database_fetch_assoc($database->database_query("SELECT profilestyle_css FROM phps_profilestyles WHERE profilestyle_user_id='".$user->user_info[user_id]."' LIMIT 1")); 
}


// GET AVAILABLE PROFILE PRIVACY OPTIONS
$privacy_count = 0;
$privacy_profile_options = Array();
for($p=0;$p<strlen($user->level_info[level_profile_privacy]);$p++) {
  $privacy_level = substr($user->level_info[level_profile_privacy], $p, 1);
  if(user_privacy_levels($privacy_level) != "") {
    $privacy_profile_options[$privacy_count] = Array('privacy_id' => "privacy_profile".$privacy_level,
					    	     'privacy_value' => $privacy_level,
					   	     'privacy_option' => user_privacy_levels($privacy_level));
    $privacy_count++;
  }
}


// GET AVAILABLE PROFILE COMMENTS OPTIONS
$privacy_count = 0;
$comments_profile_options = Array();
for($p=0;$p<strlen($user->level_info[level_profile_comments]);$p++) {
  $privacy_level = substr($user->level_info[level_profile_comments], $p, 1);
  if(user_privacy_levels($privacy_level) != "") {
    $comments_profile_options[$privacy_count] = Array('privacy_id' => "comments_profile".$privacy_level,
					    	      'privacy_value' => $privacy_level,
					   	      'privacy_option' => user_privacy_levels($privacy_level));
    $privacy_count++;
  }
}

// ASSIGN USER SETTINGS
$user->user_settings();


$uri_page = preg_replace('/\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN SMARTY VARIABLES AND INCLUDE FOOTER
$smarty->assign('result', $result);
$smarty->assign('tabs', $tab_array);
$smarty->assign('style_profile', htmlspecialchars($style_info[profilestyle_css], ENT_QUOTES, 'UTF-8'));
$smarty->assign('privacy_profile', true_privacy($user->user_info[user_privacy_profile], $user->level_info[level_profile_privacy]));
$smarty->assign('comments_profile', true_privacy($user->user_info[user_privacy_comments], $user->level_info[level_profile_comments]));
$smarty->assign('privacy_profile_options', $privacy_profile_options);
$smarty->assign('comments_profile_options', $comments_profile_options);
include "Footer.php";
?>