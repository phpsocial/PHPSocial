<?php
$page = "AdminLog";
$category_main = 'other';
include "AdminHeader.php";


// SELECT AND LOOP THROUGH LAST 500 LOGINS
$num_logins = 0;
$login_array = Array();
$logins = $database->database_query("SELECT * FROM phps_logins ORDER BY login_id DESC LIMIT 300");
while($login_info = $database->database_fetch_assoc($logins)) {

  // CANNOT GET HOSTNAME SINCE WHEN 300 ENTRIES, THIS IS SLOOOOOOW
  $hostname = "";

  // SET LOGIN ARRAY
  $login_array[$num_logins] = Array('login_id' => $login_info[login_id],
			      'login_email' => $login_info[login_email],
			      'login_password' => $login_info[login_password],
			      'login_date' => $login_info[login_date],
			      'login_ip' => $login_info[login_ip],
			      'login_result' => $login_info[login_result],
			      'login_hostname' => $hostname);
  $num_logins++;
}


// ASSIGN VARIABLES AND SHOW LOG PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('logins', $login_array);
$smarty->display("$page.tpl");
exit();
?>