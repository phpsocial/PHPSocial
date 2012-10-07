<?php
$page = "AdminLoginasuser";
include "AdminHeader.php";

// CHECK FOR USER ID
if(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = 0; }

// CHECK FOR REDIRECTION URL
if(isset($_GET['return_url'])) { $return_url = $_GET['return_url']; } else { $return_url = ""; }
$return_url = urldecode($return_url);
$return_url = str_replace("&amp;", "&", $return_url);

// VALIDATE USER ID
$user = new PHPS_User(Array($user_id));
if($user->user_exists == 0) { header("Location: AdminViewusers.php"); exit(); }

// LOG ADMIN IN AS USER
$user->user_setcookies();

// SEND ADMIN TO CORRECT URL
if($return_url == "") { cheader("../Profile.php?user=".$user->user_info['user_username']); exit(); } else { cheader("$return_url"); exit(); }

?>