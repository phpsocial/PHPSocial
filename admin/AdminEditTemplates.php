<?php

$page = "AdminTemplatesEdit";
$category_main = 'global';
include "AdminHeader.php";


if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['t'])) { $filename = $_POST['t']; } elseif(isset($_GET['t'])) { $filename = $_GET['t']; } else { header("Location: AdminTemplates.php"); exit(); }


// VALIDATE FILENAME
$path = "../templates/$filename";
$is_error = 0;
$error_message = "";

// REMOVE ANY BACK-PATHING FROM URL
$filename = str_replace("..", "", $filename);

// MAKE SURE FILE IS A TEMPLATE OR CSS FILE
if(stristr($filename, ".tpl") === false AND stristr($filename, ".css") === false) {
  $is_error = 1;
  $error_message = $admin_templates_edit[5];
}
// MAKE SURE FILE EXISTS
elseif(!is_file($path) OR strstr($filename, "..")) {
  $is_error = 1;
  $error_message = $admin_templates_edit[6];
}
// MAKE SURE FILE IS READABLE
elseif(!is_readable($path)) {
  $is_error = 1;
  $error_message = $admin_templates_edit[7];
}
// MAKE SURE FILE IS WRITABLE
elseif(!is_writable($path)) {
  $is_error = 1;
  $error_message = $admin_templates_edit[8];
}




// SAVE TEMPLATE CHANGES
if($task == "save") {
  $template_code = htmlspecialchars_decode($_POST['template_code'], ENT_QUOTES);

  // WRITE CODE TO FILE
  $path = "../templates/$filename";
  $handle = fopen($path, 'w+');
  if(fwrite($handle, $template_code) === false) {
    $is_error = 1;
    $error_message = "$admin_templates_edit[9] ($filename)";
    exit();
  }
  fclose($handle);

  // GO BACK TO TEMPLATES PAGE  
  if($is_error != 1) {
    header("Location: AdminTemplates.php");
    exit();
  }
}


// RESET TASK IF ERROR EXISTS
if($is_error != 0) { $task = "main"; }


// GET TEMPLATE CONTENTS IF NO ERROR
if($is_error == 0) {
  $template_code = file_get_contents($path);
  if(ini_get('magic_quotes_gpc')) $template_code = stripslashes($template_code); 
  $template_code = str_replace("&", "&amp;", $template_code);
  $template_code = str_replace("<", "&lt;", $template_code);
  $template_code = str_replace(">", "&gt;", $template_code);
}

$uri_page = preg_replace('/\/admin\//', '', $_SERVER['REQUEST_URI']);
$smarty->assign('uri_page', $uri_page);

// ASSIGN VARIABLES AND SHOW EDIT TEMPLATES PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('error_message', $error_message);
$smarty->assign('filename', $filename);
$smarty->assign('template_code', $template_code);
$smarty->display("$page.tpl");
exit();
?>