<?php
$page = "News";
include "Header.php";

if($setting[setting_news_page] == 0 && !$user->user_exists) { header("Location: Home.php"); exit(); }

if(isset($_POST['tab'])) { $tab = $_POST['tab']; } elseif(isset($_GET['tab'])) { $tab = $_GET['tab']; } else { $tab = ""; }

if ($_POST['filter']) $allowed = "";
else {
    $allowed = "1,2,3,4,5,7";

    if ($user->user_exists) {
        $allowed = $database->get_one("SELECT `user_allowed_actions` FROM `phps_users` WHERE `user_id`=".$user->user_info['user_id']);
    }
}

if ($_POST['actiontype']){
    $allowed = "";
    foreach($_POST['actiontype'] as $k=>$v) {
        if ($allowed != "") $allowed .= ",";
        $allowed .= $k;
    }
    if ($user->user_exists) {
        $database->database_query("UPDATE `phps_users` SET `user_allowed_actions` = '".$allowed."' WHERE `user_id`=".$user->user_info['user_id']);
    }
}

// get actions types list
if ($tab == "Groups") {
    $action_types = $database->get_all("SELECT * FROM `phps_actiontypes` WHERE `actiontype_name` LIKE 'group%'");
    $allowed = "";
    foreach ($action_types as $k=>$t) {
        $allowed .= $t['actiontype_id'];
        if (isset($action_types[$k+1])) $allowed .= ",";
    }
} elseif ($tab == "Comments") {
    $action_types = $database->get_all("SELECT * FROM `phps_actiontypes` WHERE `actiontype_name` LIKE '%comment'");
    $allowed = "";
    foreach ($action_types as $k=>$t) {
        $allowed .= $t['actiontype_id'];
        if (isset($action_types[$k+1])) $allowed .= ",";
    }
} else {
    $action_types = $database->get_all("SELECT * FROM `phps_actiontypes` WHERE `actiontype_name` != 'signup'");
}
$a = explode(",", $allowed);
foreach($action_types as $k=>$v) {
    if (in_array($v['actiontype_id'], $a)) $action_types[$k]['actiontype_checked'] = true;
}


// get actions
$actions = $actions->display($allowed);

// assign smarty vars and include footer
$smarty->assign('actions', $actions);
$smarty->assign('tab', $tab);
$smarty->assign('action_types', $action_types);
include "Footer.php";
?>