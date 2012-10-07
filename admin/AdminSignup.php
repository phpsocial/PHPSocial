<?php
$page = "AdminSignup";
$category_main = 'global';
include "AdminHeader.php";


if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $photo = $_POST['photo'];
  $phone = $_POST['phone'];
  $enable = $_POST['enable'];
  $welcome = $_POST['welcome'];
  $invite = $_POST['invite'];
  $invite_checkemail = $_POST['invite_checkemail'];
  $invite_numgiven = $_POST['invite_numgiven'];
  $invitepage = $_POST['invitepage'];
  $verify = $_POST['verify'];
  $code = $_POST['code'];
  $randpass = $_POST['randpass'];
  $tos = $_POST['tos'];
  $tostext = $_POST['tostext'];

  // LOOP TABS TO UPDATE FIELDS
  $tabs = $database->database_query("SELECT * FROM phps_tabs");
  while($tab_info = $database->database_fetch_assoc($tabs)) {

    // LOOP OVER NON DEPENDENT FIELDS IN TAB
    $fields = $database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='0' ORDER BY field_order");
    while($field_info = $database->database_fetch_assoc($fields)) {
      $var = "field_signup_".$field_info[field_id];
      if(isset($_POST[$var])) { $field_signup = $_POST[$var]; } else { $field_signup = $field_info[field_signup]; }

      $database->database_query("UPDATE phps_fields SET field_signup='$field_signup' WHERE field_id='$field_info[field_id]'");
            
    }
  }

  // IF NUMBER OF INVITES GIVEN IS NOT A NUMBER BETWEEN 1 AND 999, SET TO ZERO
//  if(!is_numeric($invite_numgiven) OR $invite_numgiven > 999) { $invite_numgiven = 0; }

  // UPDATE SETTINGS
  $database->database_query("UPDATE phps_settings SET 
			setting_signup_photo='$photo',
			setting_signup_phone='$phone',
			setting_signup_enable='$enable',
			setting_signup_welcome='$welcome',
			setting_signup_invite='$invite',
			setting_signup_invite_checkemail='$invite_checkemail',
			setting_signup_invite_numgiven='$invite_numgiven',
			setting_signup_invitepage='$invitepage',
			setting_signup_verify='$verify',
			setting_signup_code='$code',
			setting_signup_randpass='$randpass',
			setting_signup_tos='$tos',
			setting_signup_tostext='$tostext'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = 1;
}










// GET TABS
$tab_array = Array();
$tab_count = 0;
$tabs = $database->database_query("SELECT * FROM phps_tabs");
while($tab_info = $database->database_fetch_assoc($tabs)) {

  // GET FIELDS IN TAB
  $fields = $database->database_query("SELECT field_id, field_title, field_signup FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='0' ORDER BY field_order");
  $num_fields = $database->database_num_rows($fields);
  $field_count = 0;
  $field_array = Array();
    
  // LOOP OVER NON DEPENDENT FIELDS IN TAB
  while($field_info = $database->database_fetch_assoc($fields)) {

    // SET FIELD ARRAY AND INCREMENT FIELD COUNT
    $field_array[$field_count] = Array('field_id' => $field_info[field_id], 
					'field_title' => $field_info[field_title], 
					'field_signup' => $field_info[field_signup]);
    $field_count++;
  } 

  // SET TAB ARRAY AND INCREMENT TAB COUNT
  $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id],
				 'tab_name' => $tab_info[tab_name],
				 'tab_order' => $tab_info[tab_order],
				 'tab_fields' => $field_array,
				 'tab_num_fields' => $field_count);
  $tab_count++;
}









// ASSIGN VARIABLES AND SHOW ADMIN SIGNUP PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->assign('tabs', $tab_array);
$smarty->assign('photo', $setting[setting_signup_photo]);
$smarty->assign('phone', $setting[setting_signup_phone]);
$smarty->assign('enable', $setting[setting_signup_enable]);
$smarty->assign('welcome', $setting[setting_signup_welcome]);
$smarty->assign('invite', $setting[setting_signup_invite]);
$smarty->assign('invite_checkemail', $setting[setting_signup_invite_checkemail]);
$smarty->assign('invite_numgiven', $setting[setting_signup_invite_numgiven]);
$smarty->assign('invitepage', $setting[setting_signup_invitepage]);
$smarty->assign('verify', $setting[setting_signup_verify]);
$smarty->assign('code', $setting[setting_signup_code]);
$smarty->assign('randpass', $setting[setting_signup_randpass]);
$smarty->assign('tos', $setting[setting_signup_tos]);
$smarty->assign('tostext', $setting[setting_signup_tostext]);
$smarty->display("$page.tpl");
exit();
?>