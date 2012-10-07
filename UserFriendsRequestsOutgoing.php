<?php
$page = "UserFriendsRequestsOutgoing";
include "Header.php";

if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

if($setting[setting_connection_allow] == 0) { header("Location: Profile.php"); exit(); }

// get total friends
$total_friends = $user->user_friend_total(0, 0);

// make friend pages
$friends_per_page = 10;
$page_vars = make_page($total_friends, $friends_per_page, $p);

// get friend array
$friends = $user->user_friend_list($page_vars[0], $friends_per_page, 0, 0);

$uri_page = preg_replace('/\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

$smarty->assign('friends', $friends);
$smarty->assign('total_friends', $total_friends);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($friends));
include "Footer.php";
?>