<?php
$page = "AdminLostpass";
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// SET ERROR VARS
$is_error = 0;
$submitted = 0;


if($task == "send_email") {

  $admin_email = $_POST['admin_email'];
  $admin_query = $database->database_query("SELECT admin_id FROM phps_admins WHERE admin_email='$admin_email' LIMIT 1");
  $submitted = 1;

  if($database->database_num_rows($admin_query) != 1) {
    $is_error = 1;
  } else {
    $lostpassword_code = randomcode(15);
    $lostpassword_time = time();

    $admin_lost = $database->database_fetch_assoc($admin_query);
    $database->database_query("UPDATE phps_admins SET admin_lostpassword_code='$lostpassword_code', admin_lostpassword_time='$lostpassword_time' WHERE admin_id='$admin_lost[admin_id]' LIMIT 1");

    $prefix = $url->url_base;
    $link = "<a href=\"$prefix"."admin/AdminResetLostpass.php?admin_id=$admin_lost[admin_id]&r=$lostpassword_code\">$prefix"."admin/AdminResetLostpass.php?admin_id=$admin_lost[admin_id]&r=$lostpassword_code</a>";
    $subject = $admin_lostpass[8];
    $message = "$admin_lostpass[9]\n\n$link\n\n$admin_lostpass[10]";

    send_generic($admin_email, $admin_email, $subject, $message, "", "");

  }
}



// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('is_error', $is_error);
$smarty->assign('submitted', $submitted);
$smarty->display("$page.tpl");
?>