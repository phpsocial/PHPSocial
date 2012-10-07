<?php
$page = "AdminViewadmins";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['admin_id'])) { $admin_id = $_POST['admin_id']; } elseif(isset($_GET['admin_id'])) { $admin_id = $_GET['admin_id']; } else { $admin_id = 0; }

// GET ADMIN IF ONE IS SPECIFIED
$diff_admin = new PHPS_Admin($admin_id);



// CANCEL
if($task == "cancel") {
  header("Location: AdminViewadmins.php");
  exit();





// DELETE ADMIN
} elseif($task == "deleteadmin") {

  // CHECK FOR VALIDITY OF ADMIN ID
  if($diff_admin->admin_exists == 0 | $diff_admin->admin_super == 1) {
    header("Location: AdminViewadmins.php");
    exit();
  }

  $diff_admin->admin_delete();

  header("Location: AdminViewadmins.php");
  exit();



// CONFIRM DELETION OF ADMIN
} elseif($task == "confirmdeleteadmin") {

  // CHECK FOR VALIDITY OF ADMIN ID
  if($diff_admin->admin_exists == 0 | $diff_admin->admin_super == 1) {
    header("Location: AdminViewadmins.php");
    exit();
  }


  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deleteadmin'),
			  Array('name' => 'admin_id', 'value' => $admin_id));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES

  $smarty->assign('cancel_submit', $Admin[986]);

  $smarty->assign('headline', $Admin[984]);
  $smarty->assign('confirm_form_action', 'AdminViewadmins.php');
  $smarty->assign('cancel_form_action', 'AdminViewadmins.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('instructions', $Admin[985]);
  $smarty->assign('confirm_submit', $Admin[984]);
  $smarty->assign('cancel_submit', $Admin[986]);

  $smarty->display("AdminConfirm.tpl");
  exit();  



// MAIN TASK
} else {

  // SELECT AND LOOP THROUGH ADMINS
  $num_admins = 0;
  $admin_array = Array();
  $admins = $database->database_query("SELECT * FROM phps_admins ORDER BY admin_id");
  while($admin_info = $database->database_fetch_assoc($admins)) {
    
    // SET ADMIN STATUS
    if($num_admins == "0") {
      $admin_status = "0";
    } else { 
      $admin_status = "1";
    }
  
    // SHORTEN ADMIN_USERNAME
    if(strlen($admin_info[admin_username]) > 30) { $admin_username = substr($admin_info[admin_username], 0, 27)."..."; } else { $admin_username = $admin_info[admin_username]; }

    // SHORTEN ADMIN_EMAIL
    if(strlen($admin_info[admin_email]) > 30) { $admin_email = substr($admin_info[admin_email], 0, 27)."..."; } else { $admin_email = $admin_info[admin_email]; }

    // SET ADMIN ARRAY
    $admin_array[$num_admins] = Array('admin_id' => $admin_info[admin_id],
				      'admin_username' => $admin_username,
				      'admin_name' => $admin_info[admin_name],
				      'admin_email' => $admin_email,
				      'admin_status' => $admin_status);
  
    $num_admins++;
  }

}







// ASSIGN VARIABLES AND SHOW VIEW ADMINS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('admins', $admin_array);
$smarty->display("$page.tpl");
exit();
?>