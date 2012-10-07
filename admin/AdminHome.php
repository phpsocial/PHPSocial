<?php
$page = "AdminHome";
$category_main = 'network';
include "AdminHeader.php";

// GET QUICK STATISTICS
$total_users = $database->database_num_rows($database->database_query("SELECT user_id FROM phps_users"));
$total_messages = $database->database_num_rows($database->database_query("SELECT pm_id FROM phps_pms"));
$total_user_levels = $database->database_num_rows($database->database_query("SELECT level_id FROM phps_levels"));
$total_subnetworks = $database->database_num_rows($database->database_query("SELECT subnet_id FROM phps_subnets"));
$total_reports = $database->database_num_rows($database->database_query("SELECT report_id FROM phps_reports"));
$total_friendships = $database->database_num_rows($database->database_query("SELECT friend_id FROM phps_friends WHERE friend_status='1'"));
$total_announcements = $database->database_num_rows($database->database_query("SELECT announcement_id FROM phps_announcements"));
$total_admins = $database->database_num_rows($database->database_query("SELECT admin_id FROM phps_admins"));


// GET TOTAL COMMENTS
$total_comments = 0;
$comment_tables = $database->database_query("SHOW TABLES FROM `$databaseName` LIKE 'se_%comments'");
while($table_info = $database->database_fetch_array($comment_tables)) {
  $comment_type = strrev(substr(strrev(substr($table_info[0], 3)), 8));
  $total_comments += $database->database_num_rows($database->database_query("SELECT ".$comment_type."comment_id FROM se_".$comment_type."comments"));
}



// GET TODAY'S NUMBER OF SIGNUPS AND LOGINS
$date_today = strtotime(date("Y-m-d"));
$date_now = time();
$signups_today = $database->database_num_rows($database->database_query("SELECT user_id FROM phps_users WHERE user_signupdate>='$date_today' AND user_signupdate<='$date_now' LIMIT 2001"));
if($signups_today > 2000) { $signups_today = "2000+"; }
$logins_today = $database->database_num_rows($database->database_query("SELECT login_id FROM phps_logins WHERE login_date>='$date_today' AND login_date<='$date_now' LIMIT 501"));
if($logins_today > 500) { $logins_today = "500+"; }

// GET TODAY'S PAGE VIEWS
$views_info = $database->database_fetch_assoc($database->database_query("SELECT stat_views FROM phps_stats ORDER BY stat_id DESC LIMIT 1"));

// CHECK IF INSTALL FILES HAVE NOT BEEN DELETED
if(file_exists("../install.php") OR file_exists("../installsql.php")) {
  $install_exists = 1;
} else {
  $install_exists = 0;
}
$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN VARIABLES AND SHOW ADMIN HOME PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('total_users_num', $total_users);
$smarty->assign('total_entries_num', $total_entries);
$smarty->assign('total_messages_num', $total_messages);
$smarty->assign('total_comments_num', $total_comments);
$smarty->assign('total_user_levels', $total_user_levels);
$smarty->assign('total_subnetworks', $total_subnetworks);
$smarty->assign('total_reports', $total_reports);
$smarty->assign('total_friendships', $total_friendships);
$smarty->assign('total_announcements', $total_announcements);
$smarty->assign('total_admins', $total_admins);
$smarty->assign('online_users', online_users());
$smarty->assign('signups_today', $signups_today);
$smarty->assign('logins_today', $logins_today);
$smarty->assign('views_today', $views_info[stat_views]);
$smarty->assign('space_used_num', $space_used);
$smarty->assign('version_num', $version);
$smarty->assign('versions', $versions);
$smarty->assign('install_exists', $install_exists);
$smarty->display("$page.tpl");
exit();
?>