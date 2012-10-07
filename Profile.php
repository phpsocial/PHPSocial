<?php
$page = "Profile";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

if($user->user_exists == 0 & $setting[setting_permission_profile] == 0) {
  $page = "Error";
  $smarty->assign('error_header', $Application[151]);
  $smarty->assign('error_message', $Application[152]);
  $smarty->assign('error_submit', $Application[21]);
  include "Footer.php";
}

// display error page if no owner
if($owner->user_exists == 0) {
  $page = "Error";
  $smarty->assign('error_header', $Application[193]);
  $smarty->assign('error_message', $Application[194]);
  $smarty->assign('error_submit', $Application[21]);
  include "Footer.php";
}

// get privacy level
$privacy_level = $owner->user_privacy_max($user, $owner->level_info[level_profile_privacy]);
$allowed_privacy = true_privacy($owner->user_info[user_privacy_profile], $owner->level_info[level_profile_privacy]);
$is_profile_private = 0;
if($privacy_level < $allowed_privacy) { $is_profile_private = 1; }


// set status
if ($user->user_info['user_id'] == $owner->user_info['user_id'] && $task == "status") {
    $user->user_status($_GET['status']);

    // insert action if status is not empty
    if(str_replace(" ", "", $_GET['status']) != "") {
        $actions->add($user, "editstatus", Array('[username]', '[status]'), Array($user->user_info[user_username], str_replace("&", "&amp;", $_GET['status'])), 600);
    }
    
    exit();
}


// set status
if ($user->user_info['user_id'] == $owner->user_info['user_id'] && $task == "profile" && is_numeric($_GET['field'])) {
    if (preg_match("/([A-Za-z]{3}). ([0-9]*?), ([0-9]{4})/ims",$_GET['value'])) {
        $_GET['value'] = strtotime($_GET['value']);
    }
    $database->database_query("UPDATE `phps_profiles` SET `profile_".$_GET['field']."` = '".$_GET['value']."' WHERE `profile_user_id` = ".$user->user_info['user_id']);

    // INSERT ACTION
    $actions->add($user, "editprofile", Array('[username]'), Array($user->user_info[user_username]), 1800);
    
    exit();
}


// update profile views
if($is_profile_private == 0) {
  $profile_views = $owner->user_info[user_views_profile]+1;
  $database->database_query("UPDATE phps_users SET user_views_profile='$profile_views' WHERE user_id='".$owner->user_info[user_id]."'");
}




// get profile fields
$owner->user_fields(0, 0, 0, 0, 1);

// get profile comments
$comment = new PHPS_Comment('profile', 'user_id', $owner->user_info[user_id]);
$total_comments = $comment->comment_total();
if ($total_comments > $p*10) $p = 1;
$comments = $comment->comment_list(($p-1)*10, 10);

// get friends list
$friends = $owner->user_friend_list(0, 6, 0, 1, "RAND()");
$total_friends = $owner->user_friend_total(0);

// check if user is allowed to comment
$allowed_to_comment = 1;
$comment_level = $owner->user_privacy_max($user, $owner->level_info[level_profile_comments]);
$allowed_comment = true_privacy($owner->user_info[user_privacy_comments], $owner->level_info[level_profile_comments]);
if($comment_level < $allowed_comment) { $allowed_to_comment = 0; }


if($owner->level_info[level_profile_style] != 0 && $is_profile_private == 0) { 
  $profilestyle_info = $database->database_fetch_assoc($database->database_query("SELECT profilestyle_css FROM phps_profilestyles WHERE profilestyle_user_id='".$owner->user_info[user_id]."' LIMIT 1")); 
  $global_css = $profilestyle_info[profilestyle_css];
}

// ensure connection are allowed for this user
$is_friend = $user->user_friended($owner->user_info[user_id]);
$friendship_allowed = 1;
switch($setting[setting_connection_allow]) {
  case "3":
    //anyone can invite each other to the friend
    break;
  case "2":
    // check if in the same subnetwork
    if($user->user_info[user_subnet_id] != $owner->user_info[user_subnet_id]) { $friendship_allowed = 0; }
    break;
  case "1":
    // check if friend of friend
    if($user->user_friend_of_friend($owner->user_info[user_id]) == FALSE) { $friendship_allowed = 0; }
    break;
  case "0":
    // no one can invite each other to be friends
    $friendship_allowed = 0;
    break;
}
if($is_friend) { $friendship_allowed = 1; }

// check that user is online
$online_users_array = online_users();
if(in_array($owner->user_info[user_username], $online_users_array)) { $is_online = 1; } else { $is_online = 0; }

// get recent activity (action)
$actions = $actions->display();
$actions_total = count($actions);


if ($p > 1) $smarty->assign('prev', $p-1);
if ($total_comments > ($p*10)) $smarty->assign('next', $p+1);
$smarty->assign('tabs', $owner->profile_tabs);
$smarty->assign('comments', $comments);
$smarty->assign('total_comments', (int)$total_comments);
$smarty->assign('friends', $friends);
$smarty->assign('total_friends', $total_friends);
$smarty->assign('friend_ofs', $friend_ofs);
$smarty->assign('total_friend_ofs', $total_friend_ofs);
$smarty->assign('is_friend', $is_friend);
$smarty->assign('friendship_allowed', $friendship_allowed);
$smarty->assign('is_profile_private', $is_profile_private);
$smarty->assign('is_online', $is_online);
$smarty->assign('allowed_to_comment', $allowed_to_comment);
$smarty->assign('total_views', $profile_views);
$smarty->assign('actions', $actions);
$smarty->assign('actions_total', $actions_total);
include "Footer.php";
?>