<?php
$page = "UserAccount";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// SET RESULT VARIABLES
$result = "";
$is_error = 0;
$error_message = "";

// SAVE ACCOUNT SETTINGS
if($task == "dosave") {
  $user_email = $_POST['user_email'];
  $user_username = $_POST['user_username'];
  $user_timezone = $_POST['user_timezone'];


  // VALIDATE ACCOUNT INFO
  $user->user_account($user_email, $user_username);
  $is_error = $user->is_error;
  $error_message = $user->error_message;

  // GET BLOCKED LIST
  $num_blocked = $_POST['num_blocked'];
  if($user->level_info[level_profile_block] != 0 & is_numeric($num_blocked) === TRUE) {

    $block_list = "";
    for($b=0;$b<$num_blocked;$b++) {
      $var = "blocked".$b;
      if(str_replace(" ", "", $_POST[$var]) != "" AND $_POST[$var] != $user->user_info[user_username]) {
        $blocked_user = new PHPS_User(Array(0, $_POST[$var]), Array('user_id'));
        if($blocked_user->user_exists != 0) {
  	  $block_list .= $blocked_user->user_info[user_id].",";
          $user->user_friend_remove($blocked_user->user_info[user_id]);
	}
      }
    }
    // REMOVE DUPLICATES
    $block_list = implode(",", array_unique(explode(",", $block_list)));
  }

  // SAVE NEW ACCOUNT SETTINGS IF THERE WAS NO ERROR
  if($is_error == 0) {

    // SET SUBNETWORK
    $subnet_changed = "";
    $subnet_changed_verify = "";
    $subnet_id = $user->user_info[user_subnet_id];
    if($user_email != $user->user_info[user_email] & ($setting[setting_subnet_field1_id] == 0 | $setting[setting_subnet_field2_id] == 0)) { 
      $new_subnet = $user->user_subnet_select($user_email, $user->profile_info);
      $new_subnet_id = $new_subnet[0];
      $subnet_changed = "<br>".$new_subnet[2];
      $subnet_changed_verify = "<br>".$new_subnet[3];
    }

    // USER DOESN'T NEED TO VERIFY THEIR EMAIL
    if($setting[setting_signup_verify] == 0) {
      $user_email = $user_email;
      $user_newemail = $user_email;
      $subnet_id = $new_subnet_id;

    // USER MUST VERIFY THEIR EMAIL
    } else {
      $user_newemail = $user_email;
      $user_email = $user->user_info[user_email];
      $subnet_id = $user->user_info[user_subnet_id];
    }

    // MAKE SURE LANG FILE EXISTS
    if($setting[setting_lang_allow] == 1) {
      $user_lang = strtolower($_POST['user_lang']);
      if(!file_exists("./lang/lang.".$user_lang.".php")) {
	//$user_lang = $setting[setting_lang_default];
	$user_lang = $user_lang;
      }
    } else {
      $user_lang = $setting[setting_lang_default];
    }

    // DETERMINE WHICH ACTION TYPES ARE ALLOWED
    $actiontypes_max_id = $_POST['actiontypes_max_id'];
    $actiontypes_allowed = "";
    $count = 0;
    for($c = 1; $c <= $actiontypes_max_id; $c++) {
      $var = "actiontype_id_$c";
      if(isset($_POST[$var])) {
        $count++;
        $actiontype_id = $_POST[$var];
	if($count > 1) { $actiontypes_allowed .= ","; }
	$actiontypes_allowed .= $actiontype_id;
      }
    }
    // NOW GET THE REST OF THE ACTION TYPES
    $actiontypes_disallowed_query = $database->database_query("SELECT actiontype_id FROM phps_actiontypes WHERE actiontype_id NOT IN ($actiontypes_allowed)");
    $actiontypes_disallowed = "";
    $count = 0;
    while($actiontype_disallowed = $database->database_fetch_assoc($actiontypes_disallowed_query)) {
      $count++;
      if($count > 1) { $actiontypes_disallowed .= ","; }
      $actiontypes_disallowed .= "$actiontype_disallowed[actiontype_id]";
    }
    // SAVE DISALLOWED ACTION TYPES IN THE USER SETTINGS TABLE
    $database->database_query("UPDATE phps_usersettings SET usersetting_actions_dontpublish='$actiontypes_disallowed' WHERE usersetting_user_id='".$user->user_info[user_id]."' LIMIT 1");

    // UPDATE DATABASE
    $database->database_query("UPDATE phps_users SET user_subnet_id='$subnet_id', user_email='$user_email', user_newemail='$user_newemail', user_username='$user_username', user_timezone='$user_timezone', user_lang='$user_lang', user_blocklist='$block_list' WHERE user_id='".$user->user_info[user_id]."'");

    // IF USERNAME HAS CHANGED, DELETE OLD RECENT ACTIVITY
    if($user->user_info[user_username] != $user_username) { $database->database_query("DELETE FROM phps_actions WHERE action_user_id='".$user->user_info[user_id]."'"); }

    // RESET USER INFO
    $user = new PHPS_User(Array($user->user_info[user_id]));

    // UPDATE COOKIES
    $user->user_setcookies(); 

    // SEND VERIFICATION EMAIL IF NECESSARY AND SET RESULT
    if($user->user_info[user_newemail] != $user->user_info[user_email]) {
      send_verification($user->user_info);
      $result = $user_account[10].$subnet_changed_verify;
    } else {
      $result = $user_account[11].$subnet_changed;
    }
  }
}


// GET LANGUAGE FILE OPTIONS
$lang_options = Array();
$lang_count = 0;
if($dh = opendir("./lang/")) {
  while(($file = readdir($dh)) !== false) {
    if($file != "." & $file != "..") {
      if(preg_match("/lang\.([^_]+)\.php/", $file, $matches)) {
        $lang_options[$lang_count] = ucfirst($matches[1]);
        $lang_count++;
      }
    }
  }
  closedir($dh);
}


// CREATE ARRAY OF ACTION TYPES
$user->user_settings();
$actiontypes_disallowed = explode(",", $user->usersetting_info[usersetting_actions_dontpublish]);
$actiontypes_query = $database->database_query("SELECT * FROM phps_actiontypes");
$actiontypes_array = Array();
$actiontypes_max_id = 0;

while($actiontype = $database->database_fetch_assoc($actiontypes_query)) {

  // MAKE THIS ACTION TYPE SELECTED IF ITS NOT DISALLOWED BY USER
  $actiontype_selected = 0;
  if(!in_array($actiontype[actiontype_id], $actiontypes_disallowed) AND $user->usersetting_info[usersetting_actions_dontpublish] != "") { 
    $actiontype_selected = 1; 
  } elseif($user->usersetting_info[usersetting_actions_dontpublish] == "") {
    $actiontype_selected = 1; 
  }
  $actiontypes_array[] = Array('actiontype_id' => $actiontype[actiontype_id],
			       'actiontype_selected' => $actiontype_selected,
			       'actiontype_desc' => $actiontype[actiontype_desc]);
  $actiontypes_max_id = $actiontype[actiontype_id];

}


// CREATE ARRAY OF BLOCKED USERS
$blocked_users = explode(",", $user->user_info[user_blocklist]);
$blocked_array = Array();
while(list($key, $blocked_user_id) = each($blocked_users)) {
  $blocked_user = new PHPS_User(Array($blocked_user_id), Array('user_username'));
  if($blocked_user->user_exists != 0) { $blocked_array[] = $blocked_user->user_info[user_username]; }
}
$blocked_array[] = "";


// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('page', $page);
$smarty->assign('result', $result);
$smarty->assign('error_message', $error_message);
$smarty->assign('lang_options', $lang_options);
$smarty->assign('actiontypes', $actiontypes_array);
$smarty->assign('actiontypes_max_id', $actiontypes_max_id);
$smarty->assign('blocked_users', $blocked_array);
$smarty->assign('num_blocked', count($blocked_array));
include "Footer.php";
?>