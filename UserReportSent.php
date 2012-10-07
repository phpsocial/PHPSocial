<?php
$page = "UserReportSent";
include "Header.php";

// get return url if set
if(isset($_GET['return_url'])) { $return_url = $_GET['return_url']; }
$return_url = urldecode($return_url);
$return_url = str_replace("&amp;", "&", $return_url);

$smarty->assign('return_url', $return_url);
include "Footer.php";
?>