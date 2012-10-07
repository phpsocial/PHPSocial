<?php
$page = "UserLogout";
include "Header.php";

$user->user_logout();

// forward to login page
cheader("Home.php");
exit();
?>