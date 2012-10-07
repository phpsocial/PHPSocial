<?php
$page = "UserEditprofile";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['tab_id'])) { $tab_id = $_POST['tab_id']; } elseif(isset($_GET['tab_id'])) { $tab_id = $_GET['tab_id']; } else { $tab = $database->database_fetch_assoc($database->database_query("SELECT tab_id FROM phps_tabs ORDER BY tab_order LIMIT 1")); $tab_id = $tab[tab_id]; }

// VALIDATE TAB ID
$tab_num_fields = 0;
$chosen_tabs = $database->database_query("SELECT * FROM phps_tabs WHERE tab_id='$tab_id'");
if($database->database_num_rows($chosen_tabs) == 1) { 
  $chosen_tab = $database->database_fetch_assoc($chosen_tabs);
  $tab_num_fields = $database->database_num_rows($database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$tab_id' AND field_dependency='0'"));
} else {
  header("Location: UserEditProfile.php");
  exit();
}


// INITIALIZE VARIABLES
$result = "";
$is_error = 0;
$error_message = "";


// GET TABS TO DISPLAY ON TOP MENU
$user->user_fields(1);
$tab_array = $user->profile_tabs;





if($task == "dosave") { $validate = 1; } else { $validate = 0; }
$user->user_fields(0, $tab_id, $validate);
if($validate == 1) { $is_error = $user->is_error; $error_message = $user->error_message; }










// SAVE PROFILE FIELDS
if($task == "dosave" & $is_error == 0) {

  $profile_query = "UPDATE phps_profiles SET ".$user->profile_field_query." WHERE profile_user_id='".$user->user_info[user_id]."'";
  $database->database_query($profile_query);
  $user->profile_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_profiles WHERE profile_user_id='".$user->user_info[user_id]."'"));

  // SET SUBNETWORK
  $subnet_changed = "";
  $subnet_changed_verify = "";
  $new_subnet = $user->user_subnet_select($user->user_info[user_email], $user->profile_info);
  $subnet_id = $new_subnet[0];
  if($subnet_id != $user->user_info[user_subnet_id]) { 
    $database->database_query("UPDATE phps_users SET user_subnet_id='$subnet_id' WHERE user_id='".$user->user_info[user_id]."'");
    $subnet_changed = "<br>".$new_subnet[2];
    $user->subnet_info[subnet_id] = $subnet_id;
    $user->subnet_info[subnet_name] = $new_subnet[1];
  }

  $user->user_lastupdate();

  // INSERT ACTION
  $actions->add($user, "editprofile", Array('[username]'), Array($user->user_info[user_username]), 1800);

  $result = $user_editprofile[5].$subnet_changed;
}







$uri_page = preg_replace('/(.*)=/', '', $_SERVER['REQUEST_URI']);
if($uri_page=='/UserEditprofile.php'){
    $uri_page = $tab_id;
}
if ($tab_id==3 || $uri_page==3){
    $page_name = 'Contact Information';
}

if ($tab_id==2 || $uri_page==2){
    $page_name = 'Contact Information';
}
if ($tab_id==1 || $uri_page==1){
    $page_name = 'Personal Information';
}

$smarty->assign('uri_page', $uri_page);


// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('page_name', $page_name);
$smarty->assign('tab_id', $tab_id);
$smarty->assign('tab_num_fields', $tab_num_fields);
$smarty->assign('tabs', $tab_array);
$smarty->assign('fields', $user->profile_fields);
$smarty->assign('result', $result);
$smarty->assign('error_message', $error_message);
include "Footer.php";
?>