<?php
$page = "AdminViewusersEdit";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['f_user'])) { $f_user = $_POST['f_user']; } elseif(isset($_GET['f_user'])) { $f_user = $_GET['f_user']; } else { $f_user = ""; }
if(isset($_POST['f_email'])) { $f_email = $_POST['f_email']; } elseif(isset($_GET['f_email'])) { $f_email = $_GET['f_email']; } else { $f_email = ""; }
if(isset($_POST['f_level'])) { $f_level = $_POST['f_level']; } elseif(isset($_GET['f_level'])) { $f_level = $_GET['f_level']; } else { $f_level = ""; }
if(isset($_POST['f_enabled'])) { $f_enabled = $_POST['f_enabled']; } elseif(isset($_GET['f_enabled'])) { $f_enabled = $_GET['f_enabled']; } else { $f_enabled = ""; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } elseif(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = 0; }

// VALIDATE USER ID OR RETURN TO VIEW USERS
$user = new PHPS_User(Array($user_id));
if($user->user_exists == 0) { header("Location: AdminViewusers.php?s=$s&p=$p&f_user=$f_user&f_email=$f_email&f_level=$f_level&f_enabled=$f_enabled"); exit(); }


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";
$result = "";



// CANCEL
if($task == "cancel") {
  header("Location: AdminViewusers.php?s=$s&p=$p&f_user=$f_user&f_email=$f_email&f_level=$f_level&f_enabled=$f_enabled");
  exit();


// RESEND EMAIL VERIFICATION
} elseif($task == "resend") {

  send_verification($user->user_info);
  $result = $admin_viewusers_edit[29];

// MANUALLY VERIFY USER
} elseif($task == "verify") {

  $database->database_query("UPDATE phps_users SET user_verified='1' WHERE user_id='".$user->user_info[user_id]."'");
  $result = $admin_viewusers_edit[30];
  $user->user_info[user_verified] = 1;

// EDIT USER
} elseif($task == "edituser") {

  // GET POST VARIABLES
  $user_email = $_POST['user_email'];
  $user_username = $_POST['user_username'];
  $user_password = $_POST['user_password'];
  $user_enabled = $_POST['user_enabled'];
  $user_level_id = $_POST['user_level_id'];
  $user_invitesleft = $_POST['user_invitesleft'];

  // VERIFY USER DETAILS
  $user->user_account($user_email, $user_username);
  $is_error = $user->is_error;
  $error_message = $user->error_message;

  // VERIFY USER PASSWORD (MUST CREATE NEW USER OBJECT SINCE NO OLD PASSWORD IS SPECIFIED)
  if($user_password == "") { $password = "temporary"; } else { $password = $user_password; }
  $new_user = new PHPS_User();
  $new_user->user_password('', $password, $password, 0);
  if($is_error == 0) { $is_error = $new_user->is_error; $error_message = $new_user->error_message; }


  // CHECK THAT INVITES LEFT IS BETWEEN 0 AND 999
  if(!is_numeric($user_invitesleft) OR $user_invitesleft > 999) { $is_error = 1; $error_message = $admin_viewusers_edit[26]; }

  // SAVE CHANGES IF NO ERROR
  if($is_error == 0) {

    // SET SUBNETWORK
    $user_subnet_id = $user->user_info[user_subnet_id];
    if($user_email != $user->user_info[user_email] & ($setting[setting_subnet_field1_id] == 0 | $setting[setting_subnet_field2_id] == 0)) { 
      $new_subnet = $user->user_subnet_select($user_email, $user->profile_info);
      $user_subnet_id = $new_subnet[0];
    }
  
    // ENCRYPT NEW PASSWORD IF CHANGED
    if($user_password != "") { $user_password = crypt($user_password, $user->user_salt); } else { $user_password = $user->user_info[user_password]; }

    // EDIT USER AND RETURN TO VIEW USERS
    $database->database_query("UPDATE phps_users SET user_level_id='$user_level_id', user_subnet_id='$user_subnet_id', user_email='$user_email', user_newemail='$user_email', user_username='$user_username', user_password='$user_password', user_enabled='$user_enabled', user_invitesleft='$user_invitesleft' WHERE user_id='".$user->user_info[user_id]."'");
    header("Location: AdminViewusers.php?s=$s&p=$p&f_user=$f_user&f_email=$f_email&f_level=$f_level&f_enabled=$f_enabled");
    exit();

  }

}





// SET USER STATS
$total_friends = $database->database_num_rows($database->database_query("SELECT friend_id FROM phps_friends WHERE friend_user_id1='".$user->user_info[user_id]."'"));
$total_logins = $user->user_info[user_logins];
$total_messages = $database->database_num_rows($database->database_query("SELECT pm_id FROM phps_pms WHERE pm_user_id='".$user->user_info[user_id]."'"));

// GET TOTAL COMMENTS
$total_profilecomments = $database->database_num_rows($database->database_query("SELECT profilecomment_id FROM phps_profilecomments WHERE profilecomment_authoruser_id='".$user->user_info[user_id]."'"));

if($user->user_info[user_lastlogindate] == "0") {
  $last_login = $admin_viewusers_edit[14];
} else {
  $last_login = $datetime->cdate($setting[setting_dateformat].", ".$setting[setting_timeformat], $datetime->timezone($user->user_info[user_lastlogindate], $setting[setting_timezone]));
}


// GET USER LEVEL ARRAY
$levels = $database->database_query("SELECT level_id, level_name FROM phps_levels ORDER BY level_name");
$level_count = 0;
$level_array = Array();

// LOOP OVER USER LEVELS
while($level_info = $database->database_fetch_assoc($levels)) {

  // SET LEVEL ARRAY AND INCREMENT LEVEL COUNT
  $level_array[$level_count] = Array('level_id' => $level_info[level_id],
					'level_name' => $level_info[level_name]);
  $level_count++;
}


// ASSIGN VARIABLES AND SHOW EDIT USERS PAGE

$smarty->assign('category_main', $category_main);
$smarty->assign('error_message', $error_message);
$smarty->assign('result', $result);
$smarty->assign('user_id', $user_id);
$smarty->assign('user_username', $user->user_info[user_username]);
$smarty->assign('user_email', $user->user_info[user_email]);
$smarty->assign('user_enabled', $user->user_info[user_enabled]);
$smarty->assign('user_verified', $user->user_info[user_verified]);
$smarty->assign('user_level_id', $user->user_info[user_level_id]);
$smarty->assign('user_invitesleft', $user->user_info[user_invitesleft]);
$smarty->assign('verification_on', $setting[setting_signup_verify]);
$smarty->assign('total_friends', $total_friends);
$smarty->assign('total_logins', $total_logins);
$smarty->assign('total_messages', $total_messages);
$smarty->assign('last_login', $last_login);
$smarty->assign('total_profilecomments', $total_profilecomments);
$smarty->assign('levels', $level_array);
$smarty->assign('s', $s);
$smarty->assign('p', $p);
$smarty->assign('f_user', $f_user);
$smarty->assign('f_email', $f_email);
$smarty->assign('f_level', $f_level);
$smarty->assign('f_enabled', $f_enabled);
$smarty->display("$page.tpl");
exit();
?>