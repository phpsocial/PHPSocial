<?php
$page = "AdminInvite";
$category_main = 'other';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "doinvite") {
  $invite_emails = $_POST['invite_emails'];
  $user_info['user_id'] = 0;
  $user_info['user_invitesleft'] = 999;
  $user_info['user_username'] = $setting[setting_email_fromname];
  $user_info['user_email'] = $setting[setting_email_fromemail];

  if($setting[setting_signup_invite] == 0) {
    send_invitation($user_info, $invite_emails);
  } else {
    send_invitecode($user_info, $invite_emails);
  }
  
  $result = 1;
}



// ASSIGN VARIABLES AND SHOW BANNING PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('result', $result);
$smarty->display("$page.tpl");
exit();
?>