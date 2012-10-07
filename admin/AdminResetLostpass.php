<?php
$page = "AdminLostpassReset";
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['r'])) { $r = $_POST['r']; } elseif(isset($_GET['r'])) { $r = $_GET['r']; } else { $r = ""; }
if(isset($_POST['admin_id'])) { $admin_id = $_POST['admin_id']; } elseif(isset($_GET['admin_id'])) { $admin_id = $_GET['admin_id']; } else { $admin_id = ""; }

// DISPLAY PASSWORD REQUEST FORM
$submitted = 0;
$valid = 0;
$is_error = 0;
$error_message = "";

// ASSIGN USER SETTINGS
$owner = new PHPS_Admin($admin_id);

// CHECK VALIDITY OF OWNER
if($owner->admin_exists == 0) {
  $is_error = 1;
} elseif($owner->admin_info[admin_lostpassword_code] != $r | str_replace(" ", "", $owner->admin_info[admin_lostpassword_code]) == "") {
  $is_error = 1;
} elseif($owner->admin_info[admin_lostpassword_time] < (time()-86400)) {
  $is_error = 1;
} else {
  $valid = 1;
}


if($task == "reset" & $valid == 1) {

  $admin_password = $_POST['admin_password'];
  $admin_password2 = $_POST['admin_password2'];
  $submitted = 1;

  // CHECK FOR BLANK FIELDS
  if(str_replace(" ", "", $admin_password) == "" OR str_replace(" ", "", $admin_password2) == "") {
    $is_error = 1;
    $error_message = $admin_lostpass_reset[1];
  }

  // CHECK FOR INVALID PASSWORD
  if(preg_match("/[^a-zA-Z0-9]/", $admin_password)) { 
    $is_error = 1;
    $error_message = $admin_lostpass_reset[2]; 
  }

  // CHECK FOR PASSWORD LENGTH
  if(str_replace(" ", "", $admin_password) != "" & strlen($admin_password) < 6) { 
    $is_error = 1;
    $error_message = $admin_lostpass_reset[3]; 
  }
	
  // CHECK FOR PASSWORD MATCH
  if(str_replace(" ", "", $admin_password) != "" & $admin_password != $admin_password2) { 
    $is_error = 1;
    $error_message = $admin_lostpass_reset[4]; 
  }

  // IF THERE WAS NO ERROR, SAVE CHANGES
  if($is_error == 0) {

    // ENCRYPT NEW PASSWORD WITH MD5
    $password_new_crypt = crypt($admin_password, $owner->admin_salt);

    // SAVE NEW PASSWORD
    $database->database_query("UPDATE phps_admins SET admin_password='$password_new_crypt', admin_lostpassword_code='', admin_lostpassword_time='' WHERE admin_id='".$owner->admin_info[admin_id]."' LIMIT 1");

  } else {
    $submitted = 0;
  }



}




// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('submitted', $submitted);
$smarty->assign('valid', $valid);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('r', $r);
$smarty->assign('admin_id', $admin_id);
$smarty->display("$page.tpl");
?>