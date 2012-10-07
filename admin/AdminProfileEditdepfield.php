<?php
$page = "AdminProfileEditdepfield";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['o'])) { $o = $_GET['o']; } elseif(isset($_POST['o'])) { $o = $_POST['o']; } else { $o = "0"; }
if(isset($_POST['field_id'])) { $field_id = $_POST['field_id']; } elseif(isset($_GET['field_id'])) { $field_id = $_GET['field_id']; } else { $field_id = 0; }

// VALIDATE DEPENDENT FIELD ID AND GET DEPENDENT FIELD INFO
$dep_field = $database->database_query("SELECT * FROM phps_fields WHERE field_id='$field_id' AND field_dependency <> '0'");
if($database->database_num_rows($dep_field) != 1) {
  header("Location: AdminProfile.php?o=$o");
  exit();
}
$dep_field_info = $database->database_fetch_assoc($dep_field);

// VALIDATE PARENT FIELD ID AND GET PARENT FIELD INFO
$field = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_id='$dep_field_info[field_dependency]'");
if($database->database_num_rows($field) != 1) {
  header("Location: AdminProfile.php?o=$o");
  exit();
}
$field_info = $database->database_fetch_assoc($field);




// CANCEL EDIT FIELD
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();







} elseif($task == "editdepfield") {

  $field_title = $_POST['field_title'];
  $field_style = $_POST['field_style'];
  $field_required = $_POST['field_required'];
  $field_browsable = $_POST['field_browsable'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_link = $_POST['field_link'];
  $field_regex = $_POST['field_regex'];

  $database->database_query("UPDATE phps_fields SET field_title='$field_title', field_style='$field_style', field_browsable='$field_browsable', field_maxlength='$field_maxlength', field_link='$field_link', field_required='$field_required', field_regex='$field_regex' WHERE field_id='$dep_field_info[field_id]'");
  header("Location: AdminProfile.php?o=$o");
  exit();

} else {

  $field_parent_id = $field_info[field_id];
  $field_parent_title = $field_info[field_title];
  $field_title = $dep_field_info[field_title];
  $field_style = $dep_field_info[field_style];
  $field_required = $dep_field_info[field_required];
  $field_browsable = $dep_field_info[field_browsable];
  $field_maxlength = $dep_field_info[field_maxlength];
  $field_link = $dep_field_info[field_link];
  $field_regex = $dep_field_info[field_regex];
  $dep_field_id = $dep_field_info[field_id];

}







// ASSIGN VARIABLES AND SHOW EDIT DEPENDENT FIELD PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('field_parent_id', $field_parent_id);
$smarty->assign('field_parent_title', $field_parent_title);
$smarty->assign('field_id', $dep_field_id);
$smarty->assign('field_title', $field_title);
$smarty->assign('field_style', $field_style);
$smarty->assign('field_regex', $field_regex);
$smarty->assign('field_browsable', $field_browsable);
$smarty->assign('field_required', $field_required);
$smarty->assign('field_maxlength', $field_maxlength);
$smarty->assign('field_link', $field_link);
$smarty->assign('o', $o);
$smarty->display("$page.tpl");
exit();
?>