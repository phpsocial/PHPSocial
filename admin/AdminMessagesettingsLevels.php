<?php
$page = "AdminLevelsMessagesettings";
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_POST['level_id'])) { $level_id = $_POST['level_id']; } elseif(isset($_GET['level_id'])) { $level_id = $_GET['level_id']; } else { $level_id = 0; }

// VALIDATE LEVEL ID
$level = $database->database_query("SELECT * FROM phps_levels WHERE level_id='$level_id'");
if($database->database_num_rows($level) != 1) { 
  header("Location: AdminLevels.php");
  exit();
}
$level_info = $database->database_fetch_assoc($level);

// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $level_message_allow = $_POST['level_message_allow'];
  $level_message_inbox = $_POST['level_message_inbox'];
  $level_message_outbox = $_POST['level_message_outbox'];

  $database->database_query("UPDATE phps_levels SET 
			level_message_allow='$level_message_allow', 
			level_message_inbox='$level_message_inbox', 
			level_message_outbox='$level_message_outbox' WHERE level_id='$level_id'");

  $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_levels WHERE level_id='$level_id'"));
  $result = 1;
}


// ASSIGN VARIABLES AND SHOW MESSAGE PAGE
$smarty->assign('result', $result);
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('message_allow', $level_info[level_message_allow]);
$smarty->assign('message_inbox', $level_info[level_message_inbox]);
$smarty->assign('message_outbox', $level_info[level_message_outbox]);
$smarty->display("$page.tpl");
exit();
?>