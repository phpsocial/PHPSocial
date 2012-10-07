<?php
$page = "AdminUrl";
$subpage = "admin_url_help";
$category_main = 'layout';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// SET RESULT
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $setting_url = $_POST['setting_url'];
  if($setting_url != "1" & $setting_url != "0") { $setting_url = "0"; }
  $database->database_query("UPDATE phps_settings SET setting_url='$setting_url'");
  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));

  // AUTOMATICALLY DISPLAY HTACCESS HELP FILE IF SUBDIRECTORIES CHOSEN
  if($setting_url == "1") { 
    header("Location: AdminHelpUrl.php");
    exit();
  }

  $result = 1;
}



$url_files = $database->database_query("SELECT * FROM phps_urls");
while($url_files_info = $database->database_fetch_assoc($url_files)) {
  $url_regular = 'http://www.yourdomain.com/'.str_replace(Array('$user', '$id'), Array('username', 'id'), $url_files_info[url_regular]);
  $url_subdirectory = 'http://www.yourdomain.com/'.str_replace(Array('$user', '$id'), Array('username', 'id'), $url_files_info[url_subdirectory]);
  $urls[] = Array('url_title' => $url_files_info[url_title],
		'url_regular' => $url_regular,
		'url_subdirectory' => $url_subdirectory);

}



// ASSIGN VARIABLES AND SHOW URL PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('urls', $urls);
$smarty->assign('result', $result);
$smarty->assign('setting_url', $setting[setting_url]);
$smarty->display("$page.tpl");
exit();
?>