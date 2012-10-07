<?php
$page = "AdminActivity";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// set result variable
$result = 0;


if($task == "dosave") {

  $actions_showlength = $_POST['actions_showlength'];
  $actions_actionsperuser = $_POST['actions_actionsperuser'];
  $actions_selfdelete = $_POST['actions_selfdelete'];
  $actions_privacy = $_POST['actions_privacy'];
  $actions_visibility = $_POST['actions_visibility'];
  $actions_actionsonprofile = $_POST['actions_actionsonprofile'];
  $actions_actionsinlist = $_POST['actions_actionsinlist'];
  $actions_privacy = $_POST['actions_privacy'];

  // get action types
  $actiontypes_total = $_POST['actiontypes_total'];
  for($c = 1; $c <= $actiontypes_total; $c++) {
    $var = "actiontype_enabled_$c";
    $var2 = "actiontype_text_$c";
    $var3 = "actiontype_desc_$c";
    if(isset($_POST[$var2])) {
      if(isset($_POST[$var])) { $actiontype_enabled = $_POST[$var]; } else { $actiontype_enabled = 0; }
      $actiontype_text = $_POST[$var2];
      $actiontype_desc = $_POST[$var3];
      $database->database_query("UPDATE phps_actiontypes SET actiontype_enabled='$actiontype_enabled', actiontype_desc='$actiontype_desc', actiontype_text='$actiontype_text' WHERE actiontype_id='$c'");
    }
  }

  // save settings
  $database->database_query("UPDATE phps_settings SET setting_actions_showlength='$actions_showlength', 
						    setting_actions_actionsperuser='$actions_actionsperuser', 
						    setting_actions_selfdelete='$actions_selfdelete', 
						    setting_actions_privacy='$actions_privacy', 
						    setting_actions_visibility='$actions_visibility', 
						    setting_actions_actionsonprofile='$actions_actionsonprofile',
						    setting_actions_actionsinlist='$actions_actionsinlist'");
  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = 1;
}




// get action tyoes
$actiontypes = $database->database_query("SELECT * FROM phps_actiontypes ORDER BY actiontype_id ASC");
$actiontype_array = Array();
$actiontype_count = 0;
while($actiontype = $database->database_fetch_assoc($actiontypes)) {
  $actiontype_array[$actiontype_count] = Array('actiontype_id' => $actiontype[actiontype_id],
					       'actiontype_name' => $actiontype[actiontype_name],
					       'actiontype_desc' => $actiontype[actiontype_desc],
					       'actiontype_text' => $actiontype[actiontype_text],
					       'actiontype_enabled' => $actiontype[actiontype_enabled]);
  $actiontype_count++;
}



// get recent activity visiblity options
$count = 0;
while($count < 6) {
  if(user_privacy_levels($count) != "") {
    if(strpos($setting[setting_actions_visibility], "$count") !== FALSE) { $privacy_selected = 1; } else { $privacy_selected = 0; }
    $visibility_options[$count] = Array('privacy_name' => "actions_privacy_".$count,
				        'privacy_value' => $count,
				        'privacy_option' => user_privacy_levels($count),
				        'privacy_selected' => $privacy_selected);
  }
  $count++;
}




$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// assign variables and show log page
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('actions_showlength', $setting[setting_actions_showlength]);
$smarty->assign('actions_actionsperuser', $setting[setting_actions_actionsperuser]);
$smarty->assign('actions_selfdelete', $setting[setting_actions_selfdelete]);
$smarty->assign('actions_privacy', $setting[setting_actions_privacy]);
$smarty->assign('actions_visibility', $visibility_options);
$smarty->assign('actions_actionsonprofile', $setting[setting_actions_actionsonprofile]);
$smarty->assign('actions_actionsinlist', $setting[setting_actions_actionsinlist]);
$smarty->assign('actiontypes', $actiontype_array);
$smarty->assign('actiontypes_total', $actiontype_count);
$smarty->display("$page.tpl");
exit();
?>