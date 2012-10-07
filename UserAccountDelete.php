<?php
$page = "UserAccountDelete";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// delete this user
if($task == "dodelete") {
  $user->user_delete();
  $user->user_setcookies();
  cheader("Home.php");
  exit;
}
$smarty->assign('page', $page);
include "Footer.php";
?>