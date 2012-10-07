<?php
$page = "HelpTos";
include "Header.php";


$smarty->assign('page', $page);
$smarty->assign('terms_of_service', htmlspecialchars_decode($setting[setting_signup_tostext], ENT_QUOTES));
include "Footer.php";
?>