<?php
$page = "AdminProfileAddtab";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['o'])) { $o = $_GET['o']; } elseif(isset($_POST['o'])) { $o = $_POST['o']; } else { $o = "0"; }

// INITIALIZE ERROR VARS
$is_error = 0;

// CANCEL ADD TAB
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();

// TRY TO ADD TAB
} elseif($task == "addtab") {
  $tab_name = $_POST['tab_name'];

  // SHOW ERROR IF TAB NAME IS EMPTY
  if(str_replace(" ", "", $tab_name) == "") {
    $is_error = 1;

  // ADD TAB TO DATABASE
  } else {
    $tab_order_info = $database->database_fetch_assoc($database->database_query("SELECT max(tab_order) AS t_order FROM phps_tabs"));
    $tab_order = $tab_order_info[t_order]+1;
    $database->database_query("INSERT INTO phps_tabs (tab_name, tab_order) VALUES ('$tab_name', '$tab_order')");
    header("Location: AdminProfile.php?o=$o");
    exit();
  }

// ADD TAB FORM
} else {
  $tab_name = "";
}


// ASSIGN VARIABLES AND SHOW ADD TAB PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('tab_name', $tab_name);
$smarty->assign('is_error', $is_error);
$smarty->assign('o', $o);
$smarty->display("$page.tpl");
exit();
?>