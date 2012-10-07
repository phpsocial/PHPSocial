<?php
$page = "UserMessagesNew";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['pm_id'])) { $pm_id = $_POST['pm_id']; } elseif(isset($_GET['pm_id'])) { $pm_id = $_GET['pm_id']; } else { $pm_id = 0; }


// CHECK FOR ADMIN ALLOWANCE OF MESSAGES
if($user->level_info[level_message_allow] == 0) { header("Location: Profile.php"); exit(); }


// SET ERROR VARIABLES AND EMPTY VARS
$is_error = 0;
$error_message = "";


// TRY TO SEND MESSAGE
if($task=="validate" || $task=="send") {
  $to                 = $_POST['to'];
  $subject            = $_POST['subject'];
  $message            = $_POST['message'];
  $convo_id           = $_POST['convo_id'];

  $tos                = array_filter(preg_split('/[\s,;]+?/', $to));
  $validate_messages  = array();
  $validate_result    = '1';

  if(count($tos) > 5) {
    $validate_messages[] = $user_messages_new[3];
    $validate_result = '0';

  } elseif(count($tos) == 0) {
    $validate_messages[] = $user_message_new[15];
    $validate_result = '0';

  } elseif(count($tos) > 0) {
    // MAKE WHERE
    $validate_where = "WHERE phps_users.user_username IN('".join("','", $tos)."')"; 

    // GENERATE QUERY
    $sql = "
      SELECT
        phps_users.user_id,
        phps_users.user_username,
        phps_levels.level_message_allow,
        phps_friends.friend_status
      FROM
        phps_users
      LEFT JOIN
        phps_levels
        ON phps_users.user_level_id=phps_levels.level_id
      LEFT JOIN
        phps_friends
        ON (phps_friends.friend_user_id1=phps_users.user_id AND phps_friends.friend_user_id2='".$user->user_info['user_id']."' AND phps_friends.friend_status='1')
      $validate_where
    ";

    $validate_users = $database->database_query($sql) or die($database->database_error());
    $validate_users_info = array();

    while($validate_user_info_item=$database->database_fetch_assoc($validate_users)) {
      $validate_users_info[$validate_user_info_item['user_username']] = $validate_user_info_item;
    }

    foreach($tos AS $to_username) {
      // CHECK EXISTANCE
      if(empty($validate_users_info[$to_username])) {
        $validate_messages[] = "\"$to_username\" $user_messages_new[16]";
        $validate_result = '0';
        continue;
      }

      // CHECK MESSAGABLE
      if(empty($validate_users_info[$to_username]['level_message_allow']) || ($validate_users_info[$to_username]['level_message_allow']==1 && empty($validate_users_info[$to_username]['friend_status']))) {
        $validate_messages[] = "$user_messages_new[17] \"$to_username\".";
        $validate_result = '0';
        continue;
      }
    }

  }

  // IF NOT MESSAGE, SUCCESS
  if(empty($validate_messages)) { $validate_messages[] = ""; }

}


// SEND VALIDATION RESULT THROUGH AJAX
if($task=="validate") {
/* ------------------------------ */
    echo "
<html>
<body onload='parent.recv_validation(\"".
  addslashes($validate_result).
  "\", \"".
  addslashes(join('<br>', $validate_messages)).
"\");'>
</body>
</html>
";
/* ------------------------------ */
  exit();
}


// TRY TO SEND MESSAGE
if($task=="send") {
  // SEND MESSAGE TO USERS
  foreach($tos AS $to_username) {
    if($is_error) continue;
    $user->user_message_send($to_username, $subject, $message, $convo_id);
    $is_error = $user->is_error;
    $error_message = $user->error_message;
  }

  // IF NO ERROR, SEND BACK TO INBOX
  if($is_error == 0) { header("Location: UserMessages.php?justsent=1"); exit(); }
}




// MAIN SEND/REPLY PAGE
if($task=="main") { 

  // VALIDATE MESSAGE ID IF SET (REPLY)
  $pm = $database->database_query("SELECT phps_pms.pm_id, phps_pms.pm_convo_id, phps_pms.pm_subject, phps_users.user_username FROM phps_pms LEFT JOIN phps_users ON phps_pms.pm_authoruser_id=phps_users.user_id WHERE pm_id='$pm_id' AND pm_user_id='".$user->user_info[user_id]."' AND pm_status<>'2'");
  if($database->database_num_rows($pm) == 1) {
    $pm_info = $database->database_fetch_assoc($pm);
    $to = $pm_info[user_username];
    $subject = "RE: ".$pm_info[pm_subject];
    if($pm_info[pm_convo_id] != 0) { $convo_id = $pm_info[pm_convo_id]; } else { $convo_id = $pm_info[pm_id]; }

  // NO MESSAGE ID SET (NEW MESSAGE)
  } else {
    if(isset($_GET['to'])) { $to = $_GET['to']; } else { $to = ""; }
    if(isset($_GET['subject'])) { $subject = $_GET['subject']; } else { $subject = ""; }
    if(isset($_GET['message'])) { $message = $_GET['message']; } else { $message = ""; }
  }
}



// GET LIST OF FRIENDS FOR SUGGEST BOX
$total_friends = $user->user_friend_total(0);
$friends = $user->user_friend_list(0, $total_friends, 0);

$smarty->assign('page', $page);
// ASSIGN SMARTY VARS AND INCLUDE FOOTER
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('friends', $friends);
$smarty->assign('to', $to);
$smarty->assign('subject', $subject);
$smarty->assign('message', $message);
$smarty->assign('convo_id', $convo_id);
include "Footer.php";
?>