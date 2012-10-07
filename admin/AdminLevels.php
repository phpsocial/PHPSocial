<?php
$page = "AdminLevels";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['level_id'])) { $level_id = $_POST['level_id']; } elseif(isset($_GET['level_id'])) { $level_id = $_GET['level_id']; } else { $level_id = 0; }

// SET RESULT VARIABLE
$result = 0;
$is_error = 0;


// MAKE SURE THERE IS NO PROBLEM WITH DELETING THE SPECIFIED LEVEL
if($task == "deletelevel" OR $task == "confirm") {

  // VALIDATE LEVEL ID
  if($database->database_num_rows($database->database_query("SELECT level_id FROM phps_levels WHERE level_id='$level_id'")) != 1) { 
    $task = "main";

  // MAKE SURE THE LEVEL BEING DELETED IS NOT THE DEFAULT
  } elseif($database->database_num_rows($database->database_query("SELECT level_id FROM phps_levels WHERE level_id='$level_id' AND level_default='1'")) == 1) {
    $is_error = 1;
    $task = "main";
  }
}




// SET DEFAULT USER LEVEL
if($task == "savechanges") {

  $default = $_GET['default'];
  if($database->database_num_rows($database->database_query("SELECT level_id FROM phps_levels WHERE level_id='$default'")) == 1) {
    $default_level = $database->database_fetch_assoc($database->database_query("SELECT level_id FROM phps_levels WHERE level_default='1' LIMIT 1"));
    $database->database_query("UPDATE phps_levels SET level_default='0' WHERE level_id='$default_level[level_id]'");
    $database->database_query("UPDATE phps_levels SET level_default='1' WHERE level_id='$default'");
  }


// DELETE USER LEVEL
} elseif($task == "deletelevel") {

  // DELETE USER LEVEL AND MOVE ALL USERS TO DEFAULT LEVEL
  $default_level = $database->database_fetch_assoc($database->database_query("SELECT level_id FROM phps_levels WHERE level_default='1' LIMIT 1"));
  $database->database_query("DELETE FROM phps_levels WHERE level_id='$level_id'");
  $database->database_query("UPDATE phps_users SET user_level_id='$default_level[level_id]' WHERE user_level_id='$level_id'");
  $result = 2;



// CONFIRM DELETION OF USER LEVEL
} elseif($task == "confirm") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletelevel'),
			  Array('name' => 'level_id', 'value' => $level_id),
			  Array('name' => 's', 'value' => $s));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'AdminLevels.php');
  $smarty->assign('cancel_form_action', 'AdminLevels.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_levels[10]);
  $smarty->assign('instructions', $admin_levels[11]);
  $smarty->assign('confirm_submit', $admin_levels[12]);
  $smarty->assign('cancel_submit', $admin_levels[13]);
  $smarty->display("AdminConfirm.tpl");
  exit();


}





// SET USER LEVEL SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // LEVEL_ID
$n = "n";    // LEVEL_NAME
$u = "ud";    // NUMBER OF USERS

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "level_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "level_id DESC";
  $i = "i";
} elseif($s == "n") {
  $sort = "level_name";
  $n = "nd";
} elseif($s == "nd") {
  $sort = "level_name DESC";
  $n = "n";
} elseif($s == "u") {
  $sort = "users";
  $u = "ud";
} elseif($s == "ud") {
  $sort = "users DESC";
  $u = "u";
} else {
  $sort = "level_id DESC";
  $i = "i";
}



// GET USER LEVEL ARRAY
$levels = $database->database_query("SELECT phps_levels.*, count(phps_users.user_id) AS users FROM phps_levels LEFT JOIN phps_users ON phps_levels.level_id=phps_users.user_level_id GROUP BY phps_levels.level_id ORDER BY $sort");
$level_count = 0;
$level_array = Array();

// LOOP OVER USER LEVELS
while($level_info = $database->database_fetch_assoc($levels)) {

  // SET LEVEL ARRAY AND INCREMENT LEVEL COUNT
  $level_array[$level_count] = Array('level_id' => $level_info[level_id],
					'level_name' => $level_info[level_name],
					'level_default' => $level_info[level_default],
					'level_users' => $level_info[users]);
  $level_count++;
}




// ASSIGN VARIABLES AND SHOW ADMIN USER LEVELS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('s', $s);
$smarty->assign('i', $i);
$smarty->assign('n', $n);
$smarty->assign('u', $u);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('levels', $level_array);
$smarty->display("$page.tpl");
exit();
?>