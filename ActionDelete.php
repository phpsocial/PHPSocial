<?php
$page = "ActionDelete";
include "Header.php";

if(isset($_GET['action_id'])) { $action_id = $_GET['action_id']; } else { $action_id = 0; }

if($setting[setting_actions_selfdelete] != 1) { exit; }

$action_user_id = $user->user_info[user_id];
$database->database_query("DELETE FROM phps_actions WHERE (action_id='$action_id' AND action_user_id='$action_user_id')");

// include "Footer.php";
?>