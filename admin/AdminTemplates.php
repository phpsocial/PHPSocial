<?php
$page = "AdminTemplates";
$category_main = 'layout';
include "AdminHeader.php";


// GET ARRAYS OF TEMPLATES FROM TEMPLATE DIRECTORY
$user_files = Array();
$base_files = Array();
$head_files = Array();
if($handle = opendir('../templates')) { 
  while (false !== ($file = readdir($handle))) { 
    if($file != "." AND $file != ".." AND strstr($file, "Admin") === false) {
      // IF FILES ARE USER PAGES
      if(strstr($file, "User")) {
        $user_files[] = Array('filename' => $file);
      // IF FILES ARE HEADER/FOOTER/STYLE PAGES
      } elseif(preg_match("/header|footer|styles.*\.tpl|\.css/", $file)) {
        $head_files[] = Array('filename' => $file);
      // IF FILES ARE BASE PAGES
      } else {
        $base_files[] = Array('filename' => $file);
      }
    }
  }
  closedir($handle); 
} 

sort($user_files);
sort($base_files);
sort($head_files);


// ASSIGN VARIABLES AND SHOW TEMPLATES PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('user_files', $user_files);
$smarty->assign('base_files', $base_files);
$smarty->assign('head_files', $head_files);
$smarty->display("$page.tpl");
exit();
?>