<?php
$page = "AdminViewadminsAdd";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }

// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";
$admin_username = "";
$admin_name = "";
$admin_email = "";


// CANCEL ADD ADMIN
if($task == "cancel") {
  header("Location: AdminViewadmins.php");
  exit();

// TRY TO ADD ADMIN
} elseif($task == "addadmin") {

  // GET POST VARIABLES
  $admin_username = strtolower($_POST['admin_username']);
  $admin_password = $_POST['admin_password'];
  $admin_password_confirm = $_POST['admin_password_confirm'];
  $admin_name = $_POST['admin_name'];
  $admin_email = $_POST['admin_email'];

  $diff_admin = new PHPS_Admin();
  $diff_admin->admin_account($admin_username, "", $admin_password, $admin_password_confirm, $admin_name, $admin_email);
  $is_error = $diff_admin->is_error;
  $error_message = $diff_admin->error_message;

  // ADD NEW ADMIN TO DATABASE IF NO ERROR
  if($is_error == 0) {
    $diff_admin->admin_create($admin_username, $admin_password, $admin_name, $admin_email);
    header("Location: AdminViewadmins.php");
    exit();
  }

}


// ASSIGN VARIABLES AND SHOW ADD ADMIN PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('error_message', $error_message);
$smarty->assign('admin_username', $admin_username);
$smarty->assign('admin_name', $admin_name);
$smarty->assign('admin_email', $admin_email);
$smarty->display("$page.tpl");
exit();
?>