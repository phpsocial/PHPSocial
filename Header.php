<?php

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

// init smarty
if ($folder != "pluginsfront") $folder = "base";
include dirname(__FILE__) . "/include/smarty/smarty.config.php";

// check page variable
if(!isset($page)) { $page = ""; }

// define SE_PAGE constant
define('SE_PAGE', true);


include dirname(__FILE__) . "/include/Config.php";


include dirname(__FILE__) . "/include/Database.class.php";
include dirname(__FILE__) . "/include/Datetime.class.php";
include dirname(__FILE__) . "/include/ID3.class.php";
include dirname(__FILE__) . "/include/YouTube.Functions.php";
include dirname(__FILE__) . "/include/Comment.class.php";
include dirname(__FILE__) . "/include/Upload.class.php";
include dirname(__FILE__) . "/include/User.class.php";
include dirname(__FILE__) . "/include/Url.class.php";
include dirname(__FILE__) . "/include/Misc.class.php";
include dirname(__FILE__) . "/include/Ads.class.php";
include dirname(__FILE__) . "/include/Actions.class.php";
include dirname(__FILE__) . "/include/General.functions.php";
include dirname(__FILE__) . "/include/Email.functions.php";
include dirname(__FILE__) . "/include/Stats.functions.php";

$database = new PHPS_Database($databaseHost, $databaseUsername, $databasePassword, $databaseName);

$setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));


// include language file

$global_lang = $setting[setting_lang_default];

// if GD is not enabled - turn off image verification
if(!is_callable('gd_info')) {
  $setting[setting_comment_code] = 0;
  $setting[setting_signup_code] = 0;
  $setting[setting_invite_code] = 0;
  $setting[setting_group_discussion_code] = 0;
}



$_POST = security($_POST);
$_GET = security($_GET);
$_COOKIE = security($_COOKIE);


update_stats("views");

$url = new PHPS_Url();

$datetime = new PHPS_Datetime();

$misc = new PHPS_Misc();

$actions = new PHPS_Actions();

$global_css = "";

// check for page owner
if(isset($_POST['user'])) { $user_username = $_POST['user']; } elseif(isset($_GET['user'])) { $user_username = $_GET['user']; } else { $user_username = ""; }
if(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } elseif(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = ""; }
$owner = new PHPS_User(array($user_id, $user_username));

$smarty->assign('baseurl', $baseurl);

// create user object and try to login
$user = new PHPS_User();
$user->user_checkCookies();



// user is not logged in
if($user->user_exists != 0) {

  // set timezone if user logged in
  $global_timezone = $user->user_info[user_timezone];

  // set language file
  if($setting[setting_lang_allow] == 1) { $global_lang = $user->user_info[user_lang]; }

// if user is not logged
} else { 
 	
  if(substr($page, 0, 4) == "User") { header("Location: Login.php?return_url=".$url->url_current()); exit(); }
  
  $global_timezone = $setting[setting_timezone]; 
}


if ($user->user_exists) $smarty->assign('total_friends_requests', $user->user_friend_total(1, 0));

include dirname(__FILE__) . "/lang/lang.".$global_lang.".php";


// create ads object
$ads = new PHPS_Ads();

// include plugins
$global_plugins = array();
$global_plugins_search = array();
$plugins = $database->database_query("SELECT plugin_search, plugin_type, plugin_icon FROM phps_plugins ORDER BY plugin_id DESC");
while($plugin_info = $database->database_fetch_assoc($plugins)) { 
  dirname(__FILE__) . "/plugins/".$plugin_info[plugin_type]."/Header".$plugin_info[plugin_type].".php";
  if(file_exists(dirname(__FILE__) . "/plugins/".$plugin_info[plugin_type]."/Header".$plugin_info[plugin_type].".php")) {
		include dirname(__FILE__) . "/plugins/".$plugin_info[plugin_type]."/Header".$plugin_info[plugin_type].".php"; 
  } 
  $global_plugins[] = $plugin_info[plugin_type];
  if ($plugin_info[plugin_search]) $global_plugins_search[] = strtolower($plugin_info[plugin_type]);
}


// check if current user is not in owner's blocklist
if($user->user_exists == 1) {
  if($owner->user_blocked($user->user_info[user_id])) {
    // display error pages
    $page = "Error";
    $smarty->assign('error_header', $Application[18]);
    $smarty->assign('error_message', $Application[19]);
    $smarty->assign('error_submit', $Application[20]);
    include "Footer.php";
    exit();
  }
}

$smarty->assign('path2Phps', $path2Phps);
$smarty->assign('baseurl', $baseurl);

?>
