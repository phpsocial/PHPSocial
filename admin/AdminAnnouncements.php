<?php
$page = "AdminAnnouncements";
$category_main = 'other';
include "AdminHeader.php";

if(isset($_GET['task'])) { $task = $_GET['task']; } elseif(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['type'])) { $type = $_GET['type']; } elseif(isset($_POST['type'])) { $type = $_POST['type']; } else { $task = "main"; }
if(isset($_GET['announcement_id'])) { $announcement_id = $_GET['announcement_id']; } elseif(isset($_POST['announcement_id'])) { $announcement_id = $_POST['announcement_id']; } else { $announcement_id = 0; }

// SET EMPTY VARS
$totalinset = 0;
$emails_at_a_time = 0;
$start1 = 0;
$finish1 = 0;
$is_error = 0;
$error_msg = "";
$task_old = "";

// CHECK THAT ANNOUNCEMENT EXISTS IF ID IS GIVEN
if($announcement_id != 0) {
  $announcement = $database->database_query("SELECT * FROM phps_announcements WHERE announcement_id='$announcement_id' LIMIT 1");
  if($database->database_num_rows($announcement) == 0) { header("Location: AdminAnnouncements.php"); exit; }
  $item_info = $database->database_fetch_assoc($announcement);
}







// SEND EMAIL ANNOUNCEMENT
if($task == "dosend" AND $type == "email") {

  $em_from = $_POST['from'];
  $em_sub = $_POST['subject'];
  $em_mess = $_POST['message'];
  $emails_at_a_time = $_POST['emails_at_a_time'];
  $levels = $_POST['levels'];
  $subnets = $_POST['subnets'];
  $total = $_POST['total'];

  // CHECK FOR EMPTY FIELDS
  if($em_mess == "") {
    $is_error = 1;
    $error_msg = $admin_announcements[36];
  } elseif(empty($levels) && empty($subnets)) {
    $is_error = 1;
    $error_msg = $admin_announcements[37];
  }

  $levels   = ( !empty($levels)  ? ( is_string($levels)   ? explode(",", $levels)   : (array) $levels  ) : NULL );
  $subnets  = ( !empty($subnets) ? ( is_string($subnets)  ? explode(",", $subnets)  : (array) $subnets ) : NULL ); 

  if($is_error == 1) {

    $task_old = "dopost";
    $task = "post";
    $type = "email";

  } else {

    // START BUILDING QUERY
    $emailquery = "SELECT user_email FROM phps_users ";

    if( !empty($levels) || !empty($subnets) ) $emailquery .= 'WHERE ';

    // SET USER LEVELS AUDIENCE
    if(!empty($levels)) { $emailquery .= "(user_level_id='" . join("' OR user_level_id='", $levels) . "') "; }

    // SET SUBNETS AUDIENCE
    if(!empty($subnets)) {
      if(!empty($levels)) $emailquery .= "OR ";
      $emailquery .= "(user_level_id='" . join("' OR user_subnet_id='", $subnets) . "') ";
    } 
 

    if(!isset($_POST['start']) OR $_POST['start'] == "") {
      $start = 0;
    } else {
      $start = $_POST['start'];
    }

    $finish = $start + $emails_at_a_time;
    $limit = "$start,$emails_at_a_time";

    // GET TOTAL USERS IF NOT YET SET
    if($total == "") {
      $total = $database->database_num_rows($database->database_query($emailquery));
    }

    // ADD LIMITS
    $emailquery .= " ORDER BY user_id LIMIT $limit";

    $users = $database->database_query($emailquery);
    $totalinset = $database->database_num_rows($users);

    while($user = $database->database_fetch_assoc($users)) {
      send_announcement($user[user_email], $em_from, $em_sub, $em_mess);
    }

    $start1 = $start + 1;
    $finish1 = $finish + 1;

    // IMPLODE LEVELS AND SUBNETWORKS
    if(is_array($levels) OR is_array($subnets)) {
      $levels = (!empty($levels))? implode(",", $levels) : array();
      $subnets = (!empty($subnets))? implode(",", $subnets) : array();
    }

  }

}





// POST NEWS ITEM
if($task == "dopost" AND $type == "news") {
  $date = strip_tags($_POST['date']);
  $subject = strip_tags($_POST['subject']);
  $body = $_POST['body'];

  // IF NEW ITEM
  if($announcement_id == 0) {

    // DETERMINE ORDER ID
    $order_id = $database->database_fetch_assoc($database->database_query("SELECT MAX(announcement_order) AS announcement_order FROM phps_announcements"));
    $order_id[announcement_order]++;
    $database->database_query("INSERT INTO phps_announcements (announcement_order, announcement_date, announcement_subject, announcement_body) VALUES ('$order_id[announcement_order]', '$date', '$subject', '$body')");

  // IF EDITING OLD ITEM
  } else {
    $database->database_query("UPDATE phps_announcements SET announcement_date='$date', announcement_subject='$subject', announcement_body='$body' WHERE announcement_id='$announcement_id' LIMIT 1");
  }

  $task = "main";
}





// DELETE ITEM
if($task == "dodelete" AND $type == "news") {
  $database->database_query("DELETE FROM phps_announcements WHERE announcement_id='$announcement_id'");
  $task = "main";
}




// MOVE ITEM IN ITEM ORDER
if($task == "moveup" AND $type == "news") {

  // MOVE ITEM ABOVE DOWN
  $order_up = $item_info[announcement_order] - 1;
  $database->database_query("UPDATE phps_announcements SET announcement_order='$item_info[announcement_order]' WHERE announcement_order='$order_up' LIMIT 1");

  // MOVE THIS ITEM UP
  $database->database_query("UPDATE phps_announcements SET announcement_order='$order_up' WHERE announcement_id='$item_info[announcement_id]' LIMIT 1");

  header("Location: AdminAnnouncements.php"); 
  exit;
}



// GET ARRAY OF PAST NEWS ITEMS
$news = $database->database_query("SELECT * FROM phps_announcements ORDER BY announcement_order DESC");
$news_array = Array();
$news_count = 0;
while($item = $database->database_fetch_assoc($news)) {

  // DISABLE HTML ON THIS PAGE
  $item[announcement_body] = str_replace("<", "&lt;", $item[announcement_body]);
  $item[announcement_body] = str_replace(">", "&gt;", $item[announcement_body]);

  // ADD TO ARRAY OF NEWS ITEMS
  $news_array[$news_count] = Array('item_id' => $item[announcement_id],
				   'item_date' => $item[announcement_date],
				   'item_subject' => $item[announcement_subject],
				   'item_body' => $item[announcement_body]);
  $news_count++;
}







// PREPARE SEND EMAIL ANNOUNCEMENT FORM
if($task == "post" AND $type == "email") {





  // GET USER LEVELS
  if(isset($_POST['levels'])) { 
    $levels_old = $_POST['levels'];
  } else {
    $levels_old = Array();
  }

  $levels_query = $database->database_query("SELECT level_id, level_name, level_default FROM phps_levels");
  $levels = Array();
  $level_count = 0;
  while($level_info = $database->database_fetch_assoc($levels_query)) {

    if($task_old == "dopost") {
      if(in_array($level_info[level_id], $levels_old)) { 
        $level_selected = 1; 
      } else { 
        $level_selected = 0; 
      }
    } else {
      $level_selected = 1;
    }

    $levels[$level_count] = Array('level_id' => $level_info[level_id],
				       'level_name' => $level_info[level_name],
				       'level_default' => $level_info[level_default],
				       'level_selected' => $level_selected);
    $level_count++;
  }






  // GET SUBNETS
  if(isset($_POST['subnets'])) { 
    $subnets_old = $_POST['subnets'];
  } else {
    $subnets_old = Array();
  }

  $subnets_query = $database->database_query("SELECT subnet_id, subnet_name FROM phps_subnets");
  $subnets = Array();
  $subnet_count = 0;

  // ADD THE DEFAULT SUBNETWORK FIRST
  if(in_array("0", $subnets_old) OR $task_old == "") {
    $subnet_selected = 1;
  } else {
    $subnet_selected = 0;
  }

  $subnets[$subnet_count] = Array('subnet_id' => "0",
				       'subnet_name' => $admin_announcements[44],
				       'subnet_selected' => $subnet_selected);
  $subnet_count++;

  // NOW ADD THE REST
  while($subnet_info = $database->database_fetch_assoc($subnets_query)) {

    if($task_old == "dopost") {
      if(in_array($subnet_info[subnet_id], $subnets_old)) { 
        $subnet_selected = 1; 
      } else { 
        $subnet_selected = 0; 
      }
    } else {
      $subnet_selected = 1;
    }

    $subnets[$subnet_count] = Array('subnet_id' => $subnet_info[subnet_id],
				         'subnet_name' => $subnet_info[subnet_name],
				         'subnet_selected' => $subnet_selected);
    $subnet_count++;
  }

}




// SET DEFAULTS
if($em_from == "") {
  $em_from = $admin->admin_info[admin_name]." <".$admin->admin_info[admin_email].">";
}



// ASSIGN VARIABLES AND SHOW ADMIN ANNOUNCEMENTS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('task', $task);
$smarty->assign('type', $type);
$smarty->assign('announcement_id', $announcement_id);
$smarty->assign('news', $news_array);
$smarty->assign('news_total', $news_count);
$smarty->assign('item_date', $item_info[announcement_date]);
$smarty->assign('item_subject', $item_info[announcement_subject]);
$smarty->assign('item_body', $item_info[announcement_body]);
$smarty->assign('levels', $levels);
$smarty->assign('levels_total', $level_count);
$smarty->assign('subnets', $subnets);
$smarty->assign('subnets_total', $subnet_count);
$smarty->assign('totalinset', $totalinset);
$smarty->assign('emails_at_a_time', $emails_at_a_time);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_msg', $error_msg);
$smarty->assign('start', $start);
$smarty->assign('finish', $finish);
$smarty->assign('start1', $start1);
$smarty->assign('finish1', $finish1);
$smarty->assign('total', $total);
$smarty->assign('em_from', $em_from);
$smarty->assign('em_sub', $em_sub);
$smarty->assign('em_mess', $em_mess);
$smarty->display("$page.tpl");
exit();
?>