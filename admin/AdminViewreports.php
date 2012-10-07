<?php
$page = "AdminViewreports";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['f_object'])) { $f_object = $_POST['f_object']; } elseif(isset($_GET['f_object'])) { $f_object = $_GET['f_object']; } else { $f_object = ""; }
if(isset($_POST['f_reason'])) { $f_reason = $_POST['f_reason']; } elseif(isset($_GET['f_reason'])) { $f_reason = $_GET['f_reason']; } else { $f_reason = ""; }
if(isset($_POST['f_details'])) { $f_details = $_POST['f_details']; } elseif(isset($_GET['f_details'])) { $f_email = $_GET['f_details']; } else { $f_details = ""; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }



if($task == "delete") {
  $report_id = $_GET['report_id'];
  if(!is_numeric($report_id)) { header("Location: AdminViewreports.php"); exit; }
  $report_query = $database->database_query("SELECT report_id FROM phps_reports WHERE report_id='$report_id' LIMIT 1");
  if($database->database_num_rows($report_query) != 0) {
    $database->database_query("DELETE FROM phps_reports WHERE report_id='$report_id'");
  }
}






// SET REPORT SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // REPORT_ID
$u = "u";    // USER_USERNAME

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "phps_reports.report_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "phps_reports.report_id DESC";
  $i = "i";
} elseif($s == "u") {
  $sort = "phps_users.user_username";
  $u = "ud";
} elseif($s == "ud") {
  $sort = "phps_users.user_username DESC";
  $u = "u";
} else {
  $sort = "phps_reports.report_id DESC";
  $i = "i";
}

// CONSTRUCT QUERY
$reports_query = "SELECT * FROM phps_reports";

// CONSTRUCT QUERY USING FILTERS
$reports_query = "SELECT phps_reports.*, phps_users.user_id, phps_users.user_username FROM phps_reports LEFT JOIN phps_users ON phps_reports.report_user_id=phps_users.user_id";
if($f_object != "" | $f_reason != "" | $f_details != "") {
  $reports_query .= " WHERE";
  if($f_object != "") { $reports_query .= " phps_reports.report_object='$f_object'"; }
  if($f_object != "" & $f_reason != "") { $reports_query .= " AND"; }
  if($f_reason != "") { $reports_query .= " phps_reports.report_reason='$f_reason'"; }
  if(($f_object != "" | $f_reason != "") & $f_details != "") { $reports_query .= " AND"; }
  if($f_details != "") { $reports_query .= " phps_reports.report_details LIKE '%$f_details%'"; }
}


// GET TOTAL REPORTS
$total_reports = $database->database_num_rows($database->database_query($reports_query));

// MAKE REPORTS PAGES
$reports_per_page = 100;
$page_vars = make_page($total_reports, $reports_per_page, $p);

$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
			  'link' => $link);
}

$reports_query .= " ORDER BY $sort LIMIT $page_vars[0], $reports_per_page";





// DELETE MULTIPLE REPORTS
if($task == "dodelete") {
  $reports = $database->database_query($reports_query);
  while($report_info = $database->database_fetch_assoc($reports)) {
    $delete = 0;
    $var = "item_".$report_info[report_id];
    $delete = $_POST[$var];
    if($delete == 1) {
      $database->database_query("DELETE FROM phps_reports WHERE report_id='$report_info[report_id]'");
      $total_report = $total_report - 1;
    }
  }
  header("Location: AdminViewreports.php"); exit;
}




// PULL REPORTS INTO AN ARRAY
$reports_array = Array();
$report_count = 0;
$reports = $database->database_query($reports_query);
while($report_info = $database->database_fetch_assoc($reports)) {

  // DECODE REASON TYPE
  switch($report_info[report_reason]) {
    case "1":
      $report_reason = $admin_viewreports[21]; break;
    case "2":
      $report_reason = $admin_viewreports[22]; break;
    case "3":
      $report_reason = $admin_viewreports[23]; break;
    default:
    case "0":
      $report_reason = $admin_viewreports[13]; break;
  }

  $report_array[$report_count] = Array('report_id' => $report_info[report_id],
				       'report_user_id' => $report_info[report_user_id],
				       'report_username' => $report_info[user_username],
				       'report_object' => $report_info[report_object],
				       'report_url' => $report_info[report_url],
				       'report_reason' => $report_reason,
				       'report_details' => $report_info[report_details]);
  $report_count++;
}



// ASSIGN VARIABLES AND SHOW VIEW REPORTS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('total_reports', $total_reports);
$smarty->assign('pages', $page_array);
$smarty->assign('reports', $report_array);
$smarty->assign('i', $i);
$smarty->assign('u', $u);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('s', $s);
$smarty->assign('f_object', $f_object);
$smarty->assign('f_reason', $f_reason);
$smarty->assign('f_details', $f_details);
$smarty->display("$page.tpl");
exit();
?>