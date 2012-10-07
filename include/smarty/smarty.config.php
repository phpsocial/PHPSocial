<?php

if($folder == "base") {
	$serverpath = ".";
} elseif ($folder == "plugins") {
    $serverpath = "../../..";
} elseif ($folder == "pluginsfront") {
    $serverpath = "../..";
} else {
	$serverpath = "..";
}

// SPECIFY PATHS TO SMARTY RESOURCES
if ($folder == "pluginsfront") {
    $smartypath_template_dir = realpath("$serverpath/plugins/$pluginname/templates");
} elseif ($folder == "plugins") {
    $smartypath_template_dir = realpath("$serverpath/plugins/$pluginname/templates");
} else {
    $smartypath_template_dir = realpath("$serverpath/templates");
}
$smartypath_compile_dir = realpath("$serverpath/include/smarty/templates_c");
$smartypath_cache_dir = realpath("$serverpath/include/smarty/cache");
$smartypath_config_dir = realpath("$serverpath/include/smarty/configs");

// INITIATE SMARTY CLASS
require("$serverpath/include/smarty/Smarty.class.php");
$smarty = new Smarty();

// ASSIGN SMARTY TEMPLATE DIRECTORY PATHS
$smarty->template_dir = $smartypath_template_dir;
$smarty->compile_dir = $smartypath_compile_dir;
$smarty->cache_dir = $smartypath_cache_dir;
$smarty->config_dir = $smartypath_config_dir;

?>
