<?php
$page = "AdminLevelsEdit";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['level_id'])) { $level_id = $_POST['level_id']; } elseif(isset($_GET['level_id'])) { $level_id = $_GET['level_id']; } else { $level_id = 0; }

// VALIDATE LEVEL ID
$level = $database->database_query("SELECT * FROM phps_levels WHERE level_id='$level_id'");
if($database->database_num_rows($level) != 1) { 
  header("Location: AdminLevels.php");
  exit();
}
$level_info = $database->database_fetch_assoc($level);

// SET ERROR VARIABLES
$is_error = 0;
$result = 0;
$error_message = "";
$level_name = $level_info[level_name];
$level_desc = $level_info[level_desc];


// CREATE USER LEVEL
if($task == "editlevel") {
  $level_name = $_POST['level_name'];
  $level_desc = $_POST['level_desc'];

  // MAKE SURE USER LEVEL HAS A NAME
  if(str_replace(" ", "", $level_name) == "") {
    $is_error = 1;
    $error_message = $admin_levels_edit[7];
  }

  // CREATE USER LEVEL IF NO ERROR
  if($is_error == 0) {
    $database->database_query("UPDATE phps_levels SET level_name='$level_name',	level_desc='$level_desc' WHERE level_id='$level_id'");
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT level_id FROM phps_levels WHERE level_id='$level_id'"));
    $result = 1;
  }

}

// ASSIGN VARIABLES AND SHOW ADMIN ADD USER LEVEL PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_name);
$smarty->assign('level_desc', $level_desc);
$smarty->display("$page.tpl");
exit();
?>