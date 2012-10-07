<?php
$page = "UserMessagesView";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_GET['pm_id'])) { $pm_id = $_GET['pm_id']; } elseif(isset($_POST['pm_id'])) { $pm_id = $_POST['pm_id']; } else { $pm_id = 0; }


// CHECK FOR ADMIN ALLOWANCE OF MESSAGES
if($user->level_info[level_message_allow] == 0) { header("Location: Profile.php"); exit(); }

// SET EMPTY VARS
$pm_inbox = 0;


// VALIDATE MESSAGE ID, GET PM INFO
$pm = $database->database_query("SELECT * FROM phps_pms WHERE pm_id='$pm_id' AND ((pm_user_id='".$user->user_info[user_id]."' AND pm_status<>'2') OR (pm_authoruser_id='".$user->user_info[user_id]."' AND pm_outbox<>'0'))");
if($database->database_num_rows($pm) != 1) {
  header("Location: UserMessages.php");
  exit();
}
$pm_info = $database->database_fetch_assoc($pm);




// IF VIEWING A MESSAGE FROM THE INBOX
if($pm_info[pm_user_id] == $user->user_info[user_id]) {
  $pm_inbox = 1;
  // SET MESSAGE STATUS TO READ IF IT'S NEW
  if($pm_info[pm_status] == 0) {
    $database->database_query("UPDATE phps_pms SET pm_status='1' WHERE pm_id='$pm_info[pm_id]'");
  }
}



// IF IN INBOX, GET AUTHOR INFORMATION
if($pm_inbox == 1) {
  $author = new PHPS_User(Array($pm_info[pm_authoruser_id]), Array('user_id, user_username, user_photo'));
  $recepient = $user;
// IF IN OUTBOX, GET RECEPIENT INFORMATION
} else {
  $author = $user;
  $recepient = new PHPS_User(Array($pm_info[pm_user_id]), Array('user_username'));
}



// GET PREVIOUS MESSAGES FROM CONVERSATION IF ANY EXIST
if($pm_info[pm_convo_id] != 0) {
  $convo = $database->database_query("SELECT phps_pms.*, phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_pms LEFT JOIN phps_users ON phps_pms.pm_authoruser_id=phps_users.user_id WHERE (pm_id='$pm_info[pm_convo_id]' OR pm_convo_id='$pm_info[pm_convo_id]') ORDER BY pm_id DESC");
  $convo_array = Array();
  $convo_count = 0;
  while($convo_message = $database->database_fetch_assoc($convo)) {

    // CREATE AN OBJECT FOR MESSAGE AUTHOR/RECIPIENT
    $pm_author = new PHPS_User();
    $pm_author->user_info[user_id] = $convo_message[user_id];
    $pm_author->user_info[user_username] = $convo_message[user_username];
    $pm_author->user_info[user_photo] = $convo_message[user_photo];

    $convo_array[$convo_count] = Array('pm_authoruser_id' => $convo_message[pm_authoruser_id],
					'pm_date' => $convo_message[pm_date],
					'pm_author' => $pm_author,
					'pm_subject' => $convo_message[pm_subject],
					'pm_body' => $convo_message[pm_body]);
    $convo_count++;
  }
}





// DELETE MESSAGE IF REQUESTED
if($task == "delete") {
  if($pm_inbox == 1) {
    $database->database_query("UPDATE phps_pms SET pm_status='2' WHERE pm_id='$pm_info[pm_id]' AND pm_user_id='".$user->user_info[user_id]."'");
    $database->database_query("DELETE FROM phps_pms WHERE pm_status='2' AND pm_outbox='0'");
    header("Location: UserMessages.php");
    exit();
  } else {
    $database->database_query("UPDATE phps_pms SET pm_outbox='0' WHERE pm_id='$pm_info[pm_id]' AND pm_authoruser_id='".$user->user_info[user_id]."'");
    $database->database_query("DELETE FROM phps_pms WHERE pm_status='2' AND pm_outbox='0'");
    header("Location: UserMessagesOutbox.php");
    exit();
  }

}






$smarty->assign('page', $page);
// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('pm_inbox', $pm_inbox);
$smarty->assign('pm_id', $pm_info[pm_id]);
$smarty->assign('pm_date', $pm_info[pm_date]);
$smarty->assign('pm_subject', $pm_info[pm_subject]);
$smarty->assign('pm_body', $pm_info[pm_body]);
$smarty->assign('pm_author', $author);
$smarty->assign('pm_recepient', $recepient);
$smarty->assign('convo', $convo_array);
$smarty->assign('convo_total', $convo_count);
include "Footer.php";
?>