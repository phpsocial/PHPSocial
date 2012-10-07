<?php
$page = "AdminLogout";
$category_main = 'other';
include "AdminHeader.php";

$admin->admin_logout();

// FORWARD TO ADMIN LOGIN PAGE

cheader("AdminLogin.php");
exit();
?>