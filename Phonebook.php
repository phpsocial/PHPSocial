<?php
$page = "Phonebook";
include "Header.php";

if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "ud"; }
if(isset($_POST['search'])) { $search = $_POST['search']; } elseif(isset($_GET['search'])) { $search = $_GET['search']; } else { $search = ""; }

if($setting[setting_connection_allow] == 0) { header("Location: Profile.php"); exit(); }



// set friend sort-by variables for heading links
$u = "ud";    // LAST UPDATE DATE
$l = "ld";    // LAST LOGIN DATE
$t = "t";     // FRIEND TYPE


switch($s) {
  case "ud": $sort = "phps_users.user_dateupdated DESC"; $u = "ud"; break;
  case "ld": $sort = "phps_users.user_lastlogindate DESC"; $l = "ld"; break;
  case "t": $sort = "phps_friends.friend_type"; $t = "td"; break;
  default: $sort = "phps_users.user_dateupdated DESC"; $u = "ud";
}

if($search != "") { $is_where = 1; $where = "phps_users.user_phone LIKE '%$search%' AND "; } else { $is_where = 0; $where = ""; }

// decide wether to show details
$connection_types = explode("<!>", trim($setting[setting_connection_types]));
if((count($connection_types) == 0 | str_replace(" ", "", $setting[setting_connection_types]) == "") & $setting[setting_connection_other] == 0 & $setting[setting_connection_explain] == 0) {
  $show_details = 0;
} else {
  $show_details = 1;
}

$total_friends = $user->user_friend_total(0, 1, 1, $where." phps_users.user_phone != '' ");

$friends_per_page = 10;
$page_vars = make_page($total_friends, $friends_per_page, $p);


$friends = $user->user_friend_list($page_vars[0], $friends_per_page, 0, 1, $sort, $where." phps_users.user_phone != '' ", $show_details);


$smarty->assign('s', $s);
$smarty->assign('u', $u);
$smarty->assign('l', $l);
$smarty->assign('t', $t);
$smarty->assign('search', $search);
$smarty->assign('friends', $friends);
$smarty->assign('total_friends', $total_friends);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($friends));
$smarty->assign('show_details', $show_details);
include "Footer.php";
?>