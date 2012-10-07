<?php
$page = "AdminViewplugins";
$category_main = 'network';
include "AdminHeader.php";
// install plugin - call plugin's installer
if(isset($_GET['install'])) {
  $install = $_GET['install'];
  //echo "../plugins/" . $install . "/admin/Install$install.php";
  if(file_exists("../plugins/" . $install . "/admin/Install$install.php")) {
  	include "../plugins/" . $install . "/admin/Install$install.php";
    header("Location: AdminViewplugins.php");
    exit();  
  }
}


// get plugins list
$plugins_installed = Array();
$plugin_types = Array();
$plugins = $database->database_query("SELECT * FROM phps_plugins ORDER BY plugin_id DESC");
while($plugin_info = $database->database_fetch_assoc($plugins)) {
  // find installation file
  $plugin_version_ready = "";
  if(file_exists("../plugins/" . $plugin_info[plugin_type] . "/admin/Install$plugin_info[plugin_type].php")) {
    include "../plugins/" . $plugin_info[plugin_type] . "/admin/Install$plugin_info[plugin_type].php";
    $plugin_version_ready = $plugin_version;
}

  // get pages
  $plugin_pages_main = explode("<~!~>", $plugin_info[plugin_pages_main]);
  $main_pages = array();
  for($l=0; $l<count($plugin_pages_main); $l++) {
    $plugin_page = explode("<!>", $plugin_pages_main[$l]);
    if($plugin_page[0] != "" & $plugin_page[1] != "") {
      $main_pages[] = array(
			'title' => $plugin_page[0],
			'file' => $plugin_page[1]);
    }
  }

  // set plugin info
  $plugin_types[] = "Install$plugin_info[plugin_type].php";

  $plugins_installed[] = array('plugin_name' => $plugin_info[plugin_name],
				'plugin_version' => $plugin_info[plugin_version],
				'plugin_type' => $plugin_info[plugin_type],
				'plugin_desc' => $plugin_info[plugin_desc],
				'plugin_icon' => $plugin_info[plugin_icon],
				'plugin_version_avail' => $versions[$plugin_info[plugin_type]],
				'plugin_version_ready' => $plugin_version_ready,
				'plugin_pages_main' => $main_pages);
}

// create plugins list
$plugins_ready = Array();


// find plugins install files
function getPluginsInstalls($pluginTypes, $dir = '../plugins') {
	$dirContent = scandir($dir);
	foreach ($dirContent as $pluginDir) {
		if($pluginDir == '.' || $pluginDir == '..') {
			continue;
		}
		if(file_exists($dir . '/' . $pluginDir . '/admin') && is_dir($dir . '/' . $pluginDir . '/admin')) {
			$pluginAdminFiles = scandir($dir . '/' . $pluginDir . '/admin');
			foreach ($pluginAdminFiles as $pluginAdminFile) {
				if($pluginAdminFile != '.' && $pluginAdminFile != '..') {
					if(strpos($pluginAdminFile, "Install") === 0 && !in_array($pluginAdminFile, $pluginTypes)) {
						require_once $dir . '/' . $pluginDir . '/admin/' . $pluginAdminFile;
						$pluginsReady[] = array(
							'plugin_name' => $pluginName,
							'plugin_version' => $pluginVersion,
							'plugin_type' => $pluginType,
							'plugin_desc' => $pluginDesc
						);
					}
				}
			}
		}
	}
	return $pluginsReady;
}

$plugins_ready = getPluginsInstalls($plugin_types, '../plugins');

// assign smarty variables
$smarty->assign('category_main', $category_main);
$smarty->assign('plugins_ready', $plugins_ready);
$smarty->assign('plugins_installed', $plugins_installed);
$smarty->assign('versions', $versions);
$smarty->display("$page.tpl");
exit();
?>