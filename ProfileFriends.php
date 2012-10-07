<?php
$page = "ProfileFriends";
include "Header.php";

// get page variable
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

if($user->user_exists == 0 & $setting[setting_permission_profile] == 0) {
  $page = "error";
  $smarty->assign('error_header', $profile_friends[18]);
  $smarty->assign('error_message', $profile_friends[11]);
  $smarty->assign('error_submit', $profile_friends[13]);
  include "Footer.php";
}

// display error page if not owner
if($owner->user_exists == 0) {
  $page = "error";
  $smarty->assign('error_header', $profile_friends[18]);
  $smarty->assign('error_message', $profile_friends[19]);
  $smarty->assign('error_submit', $profile_friends[13]);
  include "Footer.php";
}

$privacy_level = $owner->user_privacy_max($user, $owner->level_info[level_profile_privacy]);
$allowed_privacy = true_privacy($owner->user_info[user_privacy_profile], $owner->level_info[level_profile_privacy]);
if($privacy_level < $allowed_privacy) { header("Location: ".$url->url_create("profile", $owner->user_info[user_username])); exit(); }


// get total friends
$total_friends = $owner->user_friend_total(0);

// make friend pages
$friends_per_page = 20;
$page_vars = make_page($total_friends, $friends_per_page, $p);

// get friend array
$friends = $owner->user_friend_list($page_vars[0], $friends_per_page, 0);


$smarty->assign('friends', $friends);
$smarty->assign('total_friends', $total_friends);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($friends));
$smarty->assign('p', $page_vars[1]);
include "Footer.php";
?>