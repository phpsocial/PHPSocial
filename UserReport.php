<?php
$page = "UserReport";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_POST['return_url'])) { $return_url = $_POST['return_url']; } elseif(isset($_GET['return_url'])) { $return_url = $_GET['return_url']; } else { $return_url = ""; }

if($user->user_exists == 0) {
  $page = "error";
  $smarty->assign('error_header', $user_report[11]);
  $smarty->assign('error_message', $user_report[12]);
  $smarty->assign('error_submit', $user_report[13]);
  include "Footer.php";
}


// make sure that return url is set
if($return_url == "") { header("Location: Profile.php"); exit; }

$return_url = urldecode($return_url);
$return_url = str_replace("&amp;", "&", $return_url);


// send report
if($task == "dosend") {


  $return_url = urlencode($return_url);

  // get report reason and details
  $report_reason = $_POST['report_reason'];
  $report_details = $_POST['report_details'];


  $database->database_query("INSERT INTO phps_reports (report_user_id, 
				       report_url, 
				       report_reason, 
				       report_details) VALUES (
				      '".$user->user_info[user_id]."',
				      '$return_url', 
				      '$report_reason', 
				      '$report_details')");

  // if more then 5000 reports in db - clean them
  $reports_total = $database->database_num_rows($database->database_query("SELECT report_id FROM phps_reports"));
  if($reports_total > 5000) {
    $database->database_query("DELETE FROM phps_reports WHERE report_id ORDER BY report_id ASC LIMIT 100");
  }

  // show confirm page
  header("Location: UserReportSent.php?return_url=$return_url");
  exit;
}



$smarty->assign('return_url', $return_url);
include "Footer.php";
?>