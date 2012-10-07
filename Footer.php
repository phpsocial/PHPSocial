<?php


if(!defined('SE_PAGE')) { exit(); }

// include plugin footer
for($g=0;$g<count($global_plugins);$g++) {
	if(file_exists(dirname(__FILE__) . "/plugins/".$global_plugins[$g]."/Footer".$global_plugins[$g].".php")) { 
		//echo dirname(__FILE__) . "/plugins/".$global_plugins[$g]."/Footer".$global_plugins[$g].".php";
		include dirname(__FILE__) . "/plugins/".$global_plugins[$g]."/Footer".$global_plugins[$g].".php"; 
	} 
}


// assign logged-in user vars
if($user->user_exists != 0) { 
  $smarty->assign('user_unread_pms', $user->user_message_total(0, 1));
}

// assign global smarty vars / objects and display page
$smarty->assign('url', $url);
$smarty->assign('location', $folder);
$smarty->assign('misc', $misc);
$smarty->assign('datetime', $datetime);
$smarty->assign('database', $database);
$smarty->assign('user', $user);
$smarty->assign('owner', $owner);
$smarty->assign('ads', $ads);
$smarty->assign('setting', $setting);
$smarty->assign_by_ref('global_plugin_menu', $dummy = null);
$smarty->assign('global_plugins_search', $global_plugins_search);
$smarty->assign('global_plugins', $global_plugins);
$smarty->assign('global_page', $page);
$smarty->assign('global_page_title', $Application[17]);
$smarty->assign('global_css', $global_css);
$smarty->assign('global_timezone', $global_timezone);
$smarty->display("$page.tpl");
exit();
?>