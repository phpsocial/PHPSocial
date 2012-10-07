<?php
$page = "Ad";
include "Header.php";

if(isset($_GET['ad_id'])) { $ad_id = $_GET['ad_id']; } else { $ad_id = 0; }

$database->database_query("UPDATE phps_ads SET ad_total_clicks=ad_total_clicks+1 WHERE ad_id='$ad_id' LIMIT 1");

header("Content-type: image/gif");
exit;
?>