<?php
$page = "AdminProfileEdittab";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['o'])) { $o = $_POST['o']; } elseif(isset($_GET['o'])) { $o = $_GET['o']; } else { $o = "0"; }
if(isset($_POST['tab_id'])) { $tab_id = $_POST['tab_id']; } elseif(isset($_GET['tab_id'])) { $tab_id = $_GET['tab_id']; } else { $tab_id = 0; }

// CHECK FOR VALID TAB ID AND GET TAB INFO
$tab = $database->database_query("SELECT * FROM phps_tabs WHERE tab_id='$tab_id'");
if($database->database_num_rows($tab) != 1) {
  header("Location: AdminProfile.php?o=$o");
  exit();
} else {
  $tab_info = $database->database_fetch_assoc($tab);
}



// SET FIELD ARRAY AND ERROR VARIABLES
$field_array = Array();
$is_error = 0;



// CANCEL EDIT TAB
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();





// CONFIRM TAB DELETION
} elseif($task == "confirmdeletetab") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletetab'),
			  Array('name' => 'o', 'value' => $o),
			  Array('name' => 'tab_id', 'value' => $tab_id));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			  Array('name' => 'o', 'value' => $o),
			  Array('name' => 'tab_id', 'value' => $tab_id));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'AdminProfileEdittab.php');
  $smarty->assign('cancel_form_action', 'AdminProfileEdittab.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_profile_edittab[2]);
  $smarty->assign('instructions', $admin_profile_edittab[7]);
  $smarty->assign('confirm_submit', $admin_profile_edittab[6]);
  $smarty->assign('cancel_submit', $admin_profile_edittab[5]);
  $smarty->display("AdminConfirm.tpl");
  exit();  





// DELETE TAB
} elseif($task == "deletetab") {
  
  // DELETE ALL FIELD COLUMNS
  $fields = $database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$tab_id'");
  while($field_info = $database->database_fetch_assoc($fields)) {
    $column = "profile_".$field_info[field_id];
    $database->database_query("ALTER TABLE phps_profiles DROP COLUMN $column");
  }

  // DELETE ALL FIELDS WITHIN TAB
  $database->database_query("DELETE FROM phps_fields WHERE field_tab_id='$tab_id'");

  // DELETE TAB
  $database->database_query("DELETE FROM phps_tabs WHERE tab_id='$tab_id'");

  // RETURN TO ADMIN PROFILE
  header("Location: AdminProfile.php?o=$o");
  exit();





// TRY TO EDIT TAB
} elseif($task == "edittab") {
  $tab_name = $_POST['tab_name'];

  // SHOW ERROR IF TAB NAME IS EMPTY
  if(str_replace(" ", "", $tab_name) == "") {
    $is_error = 1;

  // EDIT TAB IN DATABASE
  } else {
    $database->database_query("UPDATE phps_tabs SET tab_name='$tab_name' WHERE tab_id='$tab_id'");
    header("Location: AdminProfile.php?o=$o");
    exit();
  }





// REORDER FIELDS
} elseif($task == "reorder") {
  $field_id = $_GET['field_id'];
  $tab_id = $_GET['tab_id'];

  // SELECT FIELD TO BE MOVED DOWN
  $field_down = $database->database_query("SELECT field_id, field_order FROM phps_fields WHERE field_tab_id='$tab_id' AND field_id='$field_id'");
  if($database->database_num_rows($field_down) != 1) {
    header("Location: AdminProfileEdittab.php?tab_id=$tab_id&o=$o");
    exit();
  }

  $field_down_info = $database->database_fetch_assoc($field_down);

  // MAKE SURE FIELD IS NOT LAST
  $max = $database->database_fetch_assoc($database->database_query("SELECT max(field_order) as field_order FROM phps_fields WHERE field_tab_id='$tab_id' AND field_dependency='0'"));
  if($field_down_info[field_order] == $max[field_order]) {
    header("Location: AdminProfileEdittab.php?tab_id=$tab_id&o=$o");
    exit();
  }

  // SELECT FIELD TO BE MOVED UP
  $new = $database->database_fetch_assoc($database->database_query("SELECT field_order FROM phps_fields WHERE field_order > '$field_down_info[field_order]' AND field_tab_id='$tab_id' AND field_dependency='0' ORDER BY field_order LIMIT 1"));
  $field_up_info = $database->database_fetch_assoc($database->database_query("SELECT field_id, field_order FROM phps_fields WHERE field_order='$new[field_order]' AND field_tab_id='$tab_id' AND field_dependency='0' LIMIT 1"));

  // SWAP FIELD ORDERS
  $database->database_query("UPDATE phps_fields SET field_order='$field_down_info[field_order]' WHERE field_id='$field_up_info[field_id]'");
  $database->database_query("UPDATE phps_fields SET field_order='$field_up_info[field_order]' WHERE field_id='$field_down_info[field_id]'");

  header("Location: AdminProfileEdittab.php?tab_id=$tab_id&o=$o");
  exit();





// EDIT TAB FORM
} else {
  $tab_name = $tab_info[tab_name];
}



// GET FIELDS IN TAB
$fields = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='0' ORDER BY field_order");
$num_fields = $database->database_num_rows($fields);
$field_prev = 0;
$field_count = 0;
    
// LOOP OVER FIELDS IN TAB
while($field_info = $database->database_fetch_assoc($fields)) {

  // SET FIELD VARS
  if($field_count+1 == $num_fields) {
    $field_order = "last";
  } elseif($field_count == 0) {
    $field_order = "first";
  } else {
    $field_order = "middle";
  }

  // SET FIELD ARRAY AND INCREMENT FIELD COUNT
  $field_array[$field_count] = Array('field_id' => $field_info[field_id], 
				     'field_title' => $field_info[field_title], 
				     'field_order' => $field_order,
				     'field_prev' => $field_prev);
  $field_count++;
  $field_prev = $field_info[field_id];
} 




// ASSIGN VARIABLES AND SHOW ADMIN PROFILE PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('tab_id', $tab_id);
$smarty->assign('tab_name', $tab_name);
$smarty->assign('is_error', $is_error);
$smarty->assign('o', $o);
$smarty->assign('fields', $field_array);
$smarty->display("$page.tpl");
exit();
?>