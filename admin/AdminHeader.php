<?php
// SET ERROR REPORTING
error_reporting(E_ALL ^ E_NOTICE);

// CHECK FOR PAGE VARIABLE
if(!isset($page)) { $page = ""; }

// DEFINE SE PAGE CONSTANT
define('SE_PAGE', true);

// INITIATE SMARTY
if (!$folder) $folder = "admin";

if ($folder == "plugins") $prefix = "../../";
else $prefix = "";

include $prefix."../include/smarty/smarty.config.php";

// INCLUDE VERSION
include $prefix."../include/version.php";

// INCLUDE DATABASE INFORMATION
include $prefix."../include/Config.php";

// INCLUDE CLASS/FUNCTION FILES
include $prefix."../include/Database.class.php";
include $prefix."../include/Datetime.class.php";
include $prefix."../include/Upload.class.php";
include $prefix."../include/User.class.php";
include $prefix."../include/Url.class.php";
include $prefix."../include/Misc.class.php";
include $prefix."../include/General.functions.php";
include $prefix."../include/Email.functions.php";
include $prefix."../include/functions_stats.php";

// INCLUDE ADMIN-SPECIFIC CLASS/FUNCTION FILES
include $prefix."../include/Admin.class.php";

require_once $prefix.'../include/License.class.php';

// INITIATE DATABASE CONNECTION
$database = new PHPS_Database($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// GET SETTINGS
$setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));

// SET GLOBAL DEFAULT LANGUAGE VAR
$global_lang = $setting[setting_lang_default];
// INCLUDE LANGUAGE FILES
include $prefix."../lang/lang.".$global_lang.".php";
include $prefix."../lang/lang.".$global_lang.".admin.php";

$license = new License();
$license->setLicFilePath($prefix.'../include/');

// ENSURE NO SQL INJECTIONS THROUGH POST OR GET ARRAYS
$_POST = security($_POST);
$_GET = security($_GET);
$_COOKIE = security($_COOKIE);

// INITIALIZE ERROR MESSAGE VAR
$error_message = "";

if($_POST["task"] == "dovalidate") {
    if(!$license->acceptLicense($_POST['key'])) {
        $error_message = "Wrong license key";
        $smarty->assign('error_message', $error_message);
    }
}

if($license->check()) {
    $valid = 1;
} else {
    $valid = 1;
}

//check the license
//if(!$license->check()) {
//	$page = "AdminError";
//    $smarty->assign('error_header', $Admin[1024]);
//    $smarty->assign('error_message', $Admin[1025]);
//    $smarty->assign('error_submit', $Admin[1026]);
//	$smarty->display($page . '.tpl');
//    exit();
//}

// CREATE URL CLASS
$url = new PHPS_Url();

// CREATE DATETIME CLASS
$datetime = new PHPS_Datetime();


// CREATE ADMIN OBJECT AND ATTEMPT TO LOG ADMIN IN
$admin = new PHPS_Admin();
$admin->admin_checkCookies();

// ADMIN IS NOT LOGGED IN AND NOT ON LOGIN PAGE
if($page != "AdminLogin" & $page != "AdminLostpass" AND $page != "AdminLostpassReset" & $admin->admin_exists == 0) { header("Location: AdminLogin.php"); exit; }




// GET USER LEVEL MENU OPTIONS
$level_menu = Array();
$level_menu[] = Array('page' => 'AdminLevelsEdit',
			'title' => $AdminHeader[29],
			'link' => 'AdminEditLevels.php');
$level_menu[] = Array('page' => 'AdminLevelsUsersettings',
			'title' => $AdminHeader[30],
			'link' => 'AdminUsersettingsLevels.php');
$level_menu[] = Array('page' => 'AdminLevelsMessagesettings',
			'title' => $AdminHeader[31],
			'link' => 'AdminMessagesettingsLevels.php');

// GET PLUGIN USER LEVEL MENU OPTIONS AND INCLUDE PLUGIN PAGES
$global_plugins = Array();
$plugins = $database->database_query("SELECT plugin_type, plugin_pages_level FROM phps_plugins ORDER BY plugin_id ASC");
while($plugin_info = $database->database_fetch_assoc($plugins)) {
  if(file_exists("AdminHeader".$plugin_info[plugin_type].".php")) { include "AdminHeader".$plugin_info[plugin_type].".php"; } 
  $global_plugins[] = $plugin_info[plugin_type];

  $plugin_pages_level = explode("<~!~>", $plugin_info[plugin_pages_level]);
  for($l=0;$l<count($plugin_pages_level);$l++) {
    $plugin_page = explode("<!>", $plugin_pages_level[$l]);
    if($plugin_page[0] != "" & $plugin_page[1] != "") {
      $level_page = strrev(substr(strrev($plugin_page[1]), 4));
      $level_menu[] = Array('page' => $level_page,
				'title' => $plugin_page[0],
				'link' => $plugin_page[1]);
    }
  }
}


$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$uri_page = preg_replace('/\?.*/', '', $uri_page);
$smarty->assign('uri_page', $uri_page);


// ASSIGN ALL SMARTY VARIABLES
$smarty->assign('url', $url);
$smarty->assign('page', $page);
$smarty->assign('baseurl', $baseurl);
$smarty->assign('admin', $admin);
$smarty->assign('setting', $setting);
$smarty->assign('datetime', $datetime);
$smarty->assign('level_menu', $level_menu);

$smarty->assign('path2Phps', $path2Phps);

?>