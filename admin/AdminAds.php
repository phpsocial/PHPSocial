<?php
$page = "AdminAds";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['ad_id'])) { $ad_id = $_POST['ad_id']; } elseif(isset($_GET['ad_id'])) { $ad_id = $_GET['ad_id']; } else { $ad_id = 0; }
if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }




// PAUSE AN AD CAMPAIGN
if($task == "pause") {

  // CHECK IF AD CAMPAIGN EXISTS
  $ad_query = $database->database_query("SELECT ad_id FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
  if($database->database_num_rows($ad_query) != 1) {
    header("Location: AdminAds.php"); 
    exit;
  }

  // PAUSE CAMPAIGN
  $pause_query = $database->database_query("UPDATE phps_ads SET ad_paused='1' WHERE ad_id='$ad_id' LIMIT 1");
  header("Location: AdminAds.php"); 
  exit;
}







// UNPAUSE AN AD CAMPAIGN
if($task == "unpause") {

  // CHECK IF AD CAMPAIGN EXISTS
  $ad_query = $database->database_query("SELECT ad_id FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
  if($database->database_num_rows($ad_query) != 1) {
    header("Location: AdminAds.php"); 
    exit;
  }

  // UNPAUSE CAMPAIGN
  $pause_query = $database->database_query("UPDATE phps_ads SET ad_paused='0' WHERE ad_id='$ad_id' LIMIT 1");
  header("Location: AdminAds.php"); 
  exit;
}








// CONFIRM THE DELETION OF A SINGLE AD CAMPAIGN
if($task == "confirm") {

  // CHECK IF AD CAMPAIGN EXISTS
  $ad_query = $database->database_query("SELECT ad_id FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
  if($database->database_num_rows($ad_query) != 1) {
    header("Location: AdminAds.php"); 
    exit;
  }

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletead'),
			  Array('name' => 'ad_id', 'value' => $ad_id),
			  Array('name' => 's', 'value' => $s));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'AdminAds.php');
  $smarty->assign('cancel_form_action', 'AdminAds.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', "$admin_ads[18]");
  $smarty->assign('instructions', "$admin_ads[19]");
  $smarty->assign('confirm_submit', "$admin_ads[20]");
  $smarty->assign('cancel_submit', "$admin_ads[21]");
  $smarty->display("AdminConfirm.tpl");
  exit();

}



// DELETE A SINGLE AD CAMPAIGN
if($task == "deletead") {

  $ad_query = $database->database_query("SELECT ad_id, ad_filename FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
  if($database->database_num_rows($ad_query) != 1) {
    header("Location: AdminAds.php"); 
    exit;
  } else {
    $database->database_query("DELETE FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
    $ad_info = $database->database_fetch_assoc($ad_query);
    $bannerfile = "../uploads_admin/ads/$ad_info[ad_filename]";
    if(@file_exists($bannerfile)) {
      @unlink($bannerfile);
    }
  }

}









// SET AD CAMPIGN SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // AD_ID
$n = "n";    // AD_NAME
$v = "vd";    // NUMBER OF VIEWS
$c = "cd";    // NUMBER OF CLICKS

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "ad_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "ad_id DESC";
  $i = "i";
} elseif($s == "n") {
  $sort = "ad_name";
  $n = "nd";
} elseif($s == "nd") {
  $sort = "ad_name DESC";
  $n = "n";
} elseif($s == "v") {
  $sort = "ad_total_views";
  $v = "vd";
} elseif($s == "vd") {
  $sort = "ad_total_views DESC";
  $v = "v";
} elseif($s == "c") {
  $sort = "ad_total_clicks";
  $c = "cd";
} elseif($s == "cd") {
  $sort = "ad_total_clicks DESC";
  $c = "c";
} else {
  $sort = "ad_id DESC";
  $i = "i";
}




// GET ADS FOR MAIN LIST
$ads = $database->database_query("SELECT * FROM phps_ads ORDER BY $sort");
$ad_array = Array();
$ad_count = 0;
$nowdate = $datetime->timezone(time(), $setting[setting_timezone]);
while($ad_info = $database->database_fetch_assoc($ads)) {

  // DETERMINE CTR
  if($ad_info[ad_total_clicks] == 0 OR $ad_info[ad_total_clicks] == "") {
    $ad_info[ad_ctr] = "0.00%";
  } elseif($ad_info[ad_total_clicks] > 0) {
    $ad_info[ad_ctr] = round($ad_info[ad_total_clicks] / $ad_info[ad_total_views], 4) * 100;
    if(strlen($ad_info[ad_ctr]) == 1 OR strlen($ad_info[ad_ctr]) == 2) {
      $ad_info[ad_ctr] .= ".00";
    }
    $ad_info[ad_ctr] .= "%";
  }

  // DETERMINE AD STATUS
  $ad_status = "$admin_ads[22]";
  if($ad_info[ad_date_start] > $nowdate) {
    $ad_status = "$admin_ads[23]";
  }
  elseif($ad_info[ad_date_end] == 0) {
    $ad_status = "$admin_ads[22]";
  }
  elseif($ad_info[ad_date_end] < $nowdate) {
    $ad_status = "$admin_ads[24]";
  }


  if($ad_info[ad_paused] == 1) {
    $ad_status = "$admin_ads[25]";
  }

  $ad_array[$ad_count] = Array('ad_id' => $ad_info[ad_id],
			       'ad_name' => $ad_info[ad_name],
			       'ad_status' => $ad_status,
			       'ad_paused' => $ad_info[ad_paused],
			       'ad_total_views' => $ad_info[ad_total_views],
			       'ad_total_clicks' => $ad_info[ad_total_clicks],
			       'ad_ctr' => $ad_info[ad_ctr]);
  $ad_count++;
}

$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN VARIABLES AND SHOW ADMIN ADS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('s', $s);
$smarty->assign('i', $i);
$smarty->assign('n', $n);
$smarty->assign('v', $v);
$smarty->assign('c', $c);
$smarty->assign('ads', $ad_array);
$smarty->assign('ads_total', $ad_count);
$smarty->assign('showconfirm', $showconfirm);
$smarty->assign('ad_id', $ad_id);
$smarty->display("$page.tpl");
exit();
?>