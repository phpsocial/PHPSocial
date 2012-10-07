<?php
$page = "AdminProfileTaborder";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['o'])) { $o = $_POST['o']; } elseif(isset($_GET['o'])) { $o = $_GET['o']; } else { $o = "0"; }


// SET TAB ARRAY VARIABLE
$tab_array = Array();



// CANCEL TAB REORDER
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();





// REORDER TABS
} elseif($task == "reorder") {
  $tab_id = $_GET['tab_id'];

  // SELECT TAB TO BE MOVED DOWN
  $tab_down = $database->database_query("SELECT tab_id, tab_order FROM phps_tabs WHERE tab_id='$tab_id'");
  if($database->database_num_rows($tab_down) != 1) {
    header("Location: AdminProfileTaborder.php?o=$o");
    exit();
  }

  $tab_down_info = $database->database_fetch_assoc($tab_down);

  // MAKE SURE TAB IS NOT LAST
  $max = $database->database_fetch_assoc($database->database_query("SELECT max(tab_order) as tab_order FROM phps_tabs"));
  if($tab_down_info[tab_order] == $max[tab_order]) {
    header("Location: AdminProfileTaborder.php?o=$o");
    exit();
  }

  // SELECT TAB TO BE MOVED UP
  $new = $database->database_fetch_assoc($database->database_query("SELECT tab_order FROM phps_tabs WHERE tab_order > '$tab_down_info[tab_order]' ORDER BY tab_order LIMIT 1"));
  $tab_up_info = $database->database_fetch_assoc($database->database_query("SELECT tab_id, tab_order FROM phps_tabs WHERE tab_order='$new[tab_order]' LIMIT 1"));

  // SWAP TAB ORDERS
  $database->database_query("UPDATE phps_tabs SET tab_order='$tab_down_info[tab_order]' WHERE tab_id='$tab_up_info[tab_id]'");
  $database->database_query("UPDATE phps_tabs SET tab_order='$tab_up_info[tab_order]' WHERE tab_id='$tab_down_info[tab_id]'");

  header("Location: AdminProfileTaborder.php?o=$o");
  exit();





// ORDER TAB FORM
} else {

  // GET TABS
  $tabs = $database->database_query("SELECT tab_id, tab_name FROM phps_tabs ORDER BY tab_order");
  $num_tabs = $database->database_num_rows($tabs);
  $tab_prev = 0;
  $tab_count = 0;
    
  // LOOP OVER TABS
  while($tab_info = $database->database_fetch_assoc($tabs)) {

    // SET TAB VARS
    if($tab_count+1 == $num_tabs) {
      $tab_order = "last";
    } elseif($tab_count == 0) {
      $tab_order = "first";
    } else {
      $tab_order = "middle";
    }

    // SET TAB ARRAY AND INCREMENT TAB COUNT
    $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id], 
				   'tab_name' => $tab_info[tab_name], 
				   'tab_order' => $tab_order,
				   'tab_prev' => $tab_prev);
    $tab_count++;
    $tab_prev = $tab_info[tab_id];
  } 

}




// ASSIGN VARIABLES AND SHOW ADMIN PROFILE PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('o', $o);
$smarty->assign('tabs', $tab_array);
$smarty->display("$page.tpl");
exit();
?>