<?php
$page = "UserFriendsAdd";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// ENSURE CONECTIONS ARE ALLOWED FOR THIS USER
$friendship_allowed = 1;
switch($setting[setting_connection_allow]) {
  case "3":
    // ANYONE CAN INVITE EACH OTHER TO BE FRIENDS
    break;
  case "2":
    // CHECK IF IN SAME SUBNETWORK
    if($user->user_info[user_subnet_id] != $owner->user_info[user_subnet_id]) { $friendship_allowed = 0; }
    break;
  case "1":
    // CHECK IF FRIEND OF FRIEND
    if($user->user_friend_of_friend($owner->user_info[user_id]) == FALSE) { $friendship_allowed = 0; }
    break;
  case "0":
    // NO ONE CAN INVITE EACH OTHER TO BE FRIENDS
    $friendship_allowed = 0;
    break;
}


// DISPLAY ERROR PAGE IF NO OWNER
if($owner->user_exists == 0) {
  $page = "error";
  $smarty->assign('error_header', $Application[511]);
  $smarty->assign('error_message', $Application[512]);
  $smarty->assign('error_submit', $Application[513]);
  include "Footer.php";
}


// INITIALIZE VARS
$confirm = 1;
$result = "";
$is_error = 0;


// GET FRIEND TYPES IF AVAILABLE
$connection_types = explode("<!>", trim($setting[setting_connection_types]));
if(count($connection_types) == 0 | str_replace(" ", "", $setting[setting_connection_types]) == "") { $friend_types = ""; } else { $friend_types = $connection_types; }

// DECIDE ON TASK
if($task != "cancel" & $task != "add") {
  if((count($connection_types) == 0 | str_replace(" ", "", $setting[setting_connection_types]) == "") & $setting[setting_connection_other] == 0 & $setting[setting_connection_explain] == 0) {
    $task = "add";
  }
}



// CANCEL
if($task == "cancel") {
  header("Location: ".$url->url_create("profile", $owner->user_info[user_username]));
  exit();

// FRIENDSHIP NOT ALLOWED
} elseif($friendship_allowed == 0) {
  $result = $Application[531];
  $confirm = 0;
  $is_error = 1;


// CHECK IF USER IS ON BLOCKLIST
} elseif($owner->user_blocked($user->user_info[user_id])) {
  $result = $Application[513];
  $confirm = 0;
  $is_error = 1;


// CHECK IF USER IS TRYING TO FRIEND THEMSELVES
} elseif($owner->user_info[user_id] == $user->user_info[user_id]) {
  $result = $Application[514];
  $confirm = 0;
  $is_error = 1;


// CHECK IF USER IS ALREADY FRIENDED
} elseif($user->user_friended($owner->user_info[user_id])) {
  $result = $Application[515];
  $confirm = 0;
  $is_error = 1;


// CHECK IF USER IS ALREADY FRIENDED, WAITING FOR CONFIRMATION
} elseif($user->user_friended($owner->user_info[user_id], 0)) {
  $result = $Application[530];
  $confirm = 0;
  $is_error = 1;

// CHECK IF USER FRIENDED YOU ALREADY
} elseif($owner->user_friended($user->user_info[user_id], 0)) {
  $result = $Application[516];
  $confirm = 0;
  $is_error = 1;



// FRIEND USER
} elseif($task == "add") {
  
  $friend_type = $_POST['friend_type'];
  $friend_type_other = censor($_POST['friend_type_other']);
  $friend_explain = censor($_POST['friend_explain']);
  
  if(count($connection_types) == 0) { $friend_type = ""; }
  if($setting[setting_connection_other] == 0) { $friend_type_other = ""; }
  if($setting[setting_connection_explain] == 0) { $friend_explain = ""; }

  if($friend_type == "other_friendtype") { $friend_type = ""; }
  if(str_replace(" ", "", $friend_type_other) != "") { $friend_type = $friend_type_other; }

  switch($setting[setting_connection_framework]) {
    case "0":
      // SET RESULT, DIRECTION, STATUS
      $direction = 2;
      $friend_status = 0;
      $result = $Application[517];
      break;
    case "1":
      // SET RESULT, DIRECTION, STATUS
      $direction = 1;
      $friend_status = 0;
      $result = $Application[517];
      break;
    case "2": 
      // SET RESULT, DIRECTION, STATUS
      $direction = 2;
      $friend_status = 1;
      $result = $Application[518];
      break;
    case "3":
      // SET RESULT, DIRECTION, STATUS
      $direction = 1;
      $friend_status = 1;
      $result = $Application[518];
      break;      
  }

  // CREATE FRIENDSHIP
  $user->user_friend_add($owner->user_info[user_id], $friend_status, $friend_type, $friend_explain);

  // IF TWO-WAY CONNECTION AND NON-CONFIRMED, INSERT OTHER DIRECTION
  if($direction == 2 & $friend_status == 1) { $owner->user_friend_add($user->user_info[user_id], $friend_status, '', ''); }

  // SEND FRIENDSHIP EMAIL
  send_friendrequest($owner, $user->user_info[user_username]);

  // UPDATE STATS
  update_stats("friends");

  $confirm = 0;



// SHOW CONFIRMATION PAGE
} else {
  $confirm = 1;
}
  




// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('confirm', $confirm);
$smarty->assign('friend_types', $friend_types);
$smarty->assign('friend_other', $setting[setting_connection_other]);
$smarty->assign('friend_explain', $setting[setting_connection_explain]);
include "Footer.php";
?>