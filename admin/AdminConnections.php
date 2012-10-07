<?php
$page = "AdminConnections";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $setting_connection_allow = $_POST['setting_connection_allow'];
  $setting_connection_framework = $_POST['setting_connection_framework'];
  $setting_connection_other = $_POST['setting_connection_other'];
  $setting_connection_explain = $_POST['setting_connection_explain'];


  $num_friendtypes = $_POST['num_friendtypes'];
  $friendtype_count = 0;
  $setting_connection_types = "";
  for($t=0;$t<$num_friendtypes;$t++) {
    $var = "friendtype_label$t";
    $friendtype_label = $_POST[$var];
    if(str_replace(" ", "", $friendtype_label) != "") {
      if($friendtype_count != 0) { $setting_connection_types .= "<!>"; }
      $setting_connection_types .= $friendtype_label;
      $friendtype_count++;
    }
  }


  $database->database_query("UPDATE phps_settings SET 
			setting_connection_allow='$setting_connection_allow', 
			setting_connection_framework='$setting_connection_framework',
			setting_connection_types='$setting_connection_types',
			setting_connection_other='$setting_connection_other',
			setting_connection_explain='$setting_connection_explain'");

  // UPDATE ALL USER FRIENDSHIPS - CONFIRM UNVERIFIED FRIENDSHIPS IF ADMIN SETS TO UNVERIFIED
  if($setting_connection_framework == "2" | $setting_connection_framework == "3") {
    $database->database_query("UPDATE phps_friends SET friend_status='1'");
  }

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = 1;
}






$friendtype_count = 0;
$friendtypes = explode("<!>", trim($setting[setting_connection_types]));
for($t=0;$t<count($friendtypes);$t++) {
  if(str_replace(" ", "", $friendtypes[$t]) != "") {
    $types[$friendtype_count] = Array('friendtype_id' => $friendtype_count,
				'friendtype_label' => $friendtypes[$t]);
    $friendtype_count++;
  }
}



// ADD ADDITIONAL BLANK OPTION IF NO FRIENDTYPES EXIST
if($friendtype_count == 0) {
  $types = Array('0' => Array('friendtype_id' => 0,
				'friendtype_label' => ''));
  $friendtype_count = 1;
}




$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN VARIABLES AND SHOW CONNECTIONS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('invitation', $setting[setting_connection_allow]);
$smarty->assign('framework', $setting[setting_connection_framework]);
$smarty->assign('other', $setting[setting_connection_other]);
$smarty->assign('explain', $setting[setting_connection_explain]);
$smarty->assign('num_friendtypes', $friendtype_count);
$smarty->assign('types', $types);
$smarty->display("$page.tpl");
exit();
?>