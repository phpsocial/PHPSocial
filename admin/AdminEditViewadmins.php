<?php
$page = "AdminViewadminsEdit";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_POST['admin_id'])) { $admin_id = $_POST['admin_id']; } elseif(isset($_GET['admin_id'])) { $admin_id = $_GET['admin_id']; } else { $admin_id = 0; }

// GET ADMIN IF ONE IS SPECIFIED
$diff_admin = new PHPS_Admin($admin_id);
if($diff_admin->admin_exists == 0) {
  header("Location: AdminViewadmins.php");
  exit();
}


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";
$admin_username = $diff_admin->admin_info[admin_username];
$admin_name = $diff_admin->admin_info[admin_name];
$admin_email = $diff_admin->admin_info[admin_email];



// CANCEL EDIT ADMIN
if($task == "cancel") {
  header("Location: AdminViewadmins.php");
  exit();




// TRY TO EDIT ADMIN
} elseif($task == "editadmin") {

  // GET POST VARIABLES
  $admin_username = strtolower($_POST['admin_username']);
  $admin_name = $_POST['admin_name'];
  $admin_email = $_POST['admin_email'];
  $admin_old_password = $_POST['admin_old_password'];
  $admin_password = $_POST['admin_password'];
  $admin_password_confirm = $_POST['admin_password_confirm'];

  $diff_admin->admin_account($admin_username, $admin_old_password, $admin_password, $admin_password_confirm, $admin_name, $admin_email);
  $is_error = $diff_admin->is_error;
  if ($admin_id == 1) $is_error == 1;
  $error_message = $diff_admin->error_message;

  // EDIT ADMIN IN DATABASE
  if($is_error == 0) {
    $diff_admin->admin_edit($admin_username, $admin_password, $admin_name, $admin_email);
    cheader("AdminViewadmins.php");
    exit();
  }

}

// ASSIGN VARIABLES AND SHOW ADD ADMIN PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('error_message', $error_message);
$smarty->assign('admin_id', $diff_admin->admin_info[admin_id]);
$smarty->assign('admin_username', $admin_username);
$smarty->assign('admin_name', $admin_name);
$smarty->assign('admin_email', $admin_email);
$smarty->display("$page.tpl");
exit();
?>
