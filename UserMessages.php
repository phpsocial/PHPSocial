<?php
$page = "UserMessages";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_GET['justsent']) AND $_GET['justsent'] == 1) { $justsent = $_GET['justsent']; }

if($user->level_info[level_message_allow] == 0) { header("Location: Profile.php"); exit(); }

$pms_per_page = 20;


if($task == "deleteselected") {
  $start = ($p - 1) * $pms_per_page;
  $user->user_message_delete_selected($start, $pms_per_page, 0);
}

$total_pms = $user->user_message_total(0, 0);

// make pms pages
$page_vars = make_page($total_pms, $pms_per_page, $p);

// get array of messages
$pms = $user->user_message_list($page_vars[0], $pms_per_page, 0);


if ($_GET['ajax_call']) {
    $smarty->assign('ajax_call', 1);
}
$smarty->assign('page', $page);
$smarty->assign('total_pms', $total_pms);
$smarty->assign('pms', $pms);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($pms));
$smarty->assign('justsent', $justsent);
include "Footer.php";
?>