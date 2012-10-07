<?php
$page = "AdminViewusers";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['f_user'])) { $f_user = $_POST['f_user']; } elseif(isset($_GET['f_user'])) { $f_user = $_GET['f_user']; } else { $f_user = ""; }
if(isset($_POST['f_email'])) { $f_email = $_POST['f_email']; } elseif(isset($_GET['f_email'])) { $f_email = $_GET['f_email']; } else { $f_email = ""; }
if(isset($_POST['f_level'])) { $f_level = $_POST['f_level']; } elseif(isset($_GET['f_level'])) { $f_level = $_GET['f_level']; } else { $f_level = ""; }
if(isset($_POST['f_subnet'])) { $f_subnet = $_POST['f_subnet']; } elseif(isset($_GET['f_subnet'])) { $f_subnet = $_GET['f_subnet']; } else { $f_subnet = ""; }
if(isset($_POST['f_enabled'])) { $f_enabled = $_POST['f_enabled']; } elseif(isset($_GET['f_enabled'])) { $f_enabled = $_GET['f_enabled']; } else { $f_enabled = ""; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } elseif(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = 0; }

// GET USER IF ONE IS SPECIFIED
$user = new PHPS_User(Array($user_id));
if($user->user_exists == 0 & ($task == "confirm" | $task == "deleteuser")) { $task = "main"; }

// CONFIRM USER DELETION
if($task == "confirm") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deleteuser'),
			  Array('name' => 'user_id', 'value' => $user_id),
			  Array('name' => 's', 'value' => $s),
			  Array('name' => 'p', 'value' => $p),
			  Array('name' => 'f_user', 'value' => $f_user),
			  Array('name' => 'f_email', 'value' => $f_email),
			  Array('name' => 'f_level', 'value' => $f_level),
			  Array('name' => 'f_subnet', 'value' => $f_subnet),
			  Array('name' => 'f_enabled', 'value' => $f_enabled));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s),
			 Array('name' => 'p', 'value' => $p),
			 Array('name' => 'f_user', 'value' => $f_user),
			 Array('name' => 'f_email', 'value' => $f_email),
			  Array('name' => 'f_level', 'value' => $f_level),
			  Array('name' => 'f_subnet', 'value' => $f_subnet),
			 Array('name' => 'f_enabled', 'value' => $f_enabled));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('category_main', $category_main);
  $smarty->assign('confirm_form_action', 'AdminViewusers.php');
  $smarty->assign('cancel_form_action', 'AdminViewusers.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_viewusers[18]);
  $smarty->assign('instructions', $admin_viewusers[19]);
  $smarty->assign('confirm_submit', $admin_viewusers[18]);
  $smarty->assign('cancel_submit', $admin_viewusers[20]);
  $smarty->display("AdminConfirm.tpl");
  exit();




// DELETE USER
} elseif($task == "deleteuser") {
  $user->user_delete();
}







// SET USER SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // USER_ID
$u = "u";    // USER_USERNAME
$em = "em";  // USER_EMAIL
$v = "v";    // USER_VERIFIED
$sd = "sd";  // USER_SIGNUPDATE

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "user_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "user_id DESC";
  $i = "i";
} elseif($s == "u") {
  $sort = "user_username";
  $u = "ud";
} elseif($s == "ud") {
  $sort = "user_username DESC";
  $u = "u";
} elseif($s == "em") {
  $sort = "user_email";
  $em = "emd";
} elseif($s == "emd") {
  $sort = "user_email DESC";
  $em = "em";
} elseif($s == "v") {
  $sort = "user_verified, user_email";
  $v = "vd";
} elseif($s == "vd") {
  $sort = "user_verified DESC, user_email";
  $v = "v";
} elseif($s == "sd") {
  $sort = "user_signupdate";
  $sd = "sdd";
} elseif($s == "sdd") {
  $sort = "user_signupdate DESC";
  $sd = "sd";
} else {
  $sort = "user_id DESC";
  $i = "i";
}







// CONSTRUCT QUERY USING FILTERS
$user_query = "SELECT user_id, user_username, user_email, user_enabled, user_verified, user_signupdate, user_level_id, user_subnet_id FROM phps_users";
if($f_user != "" | $f_email != "" | $f_level != "" | $f_subnet != "" | $f_enabled != "") {
  $user_query .= " WHERE";
  if($f_user != "") { $user_query .= " user_username LIKE '%$f_user%'"; }
  if($f_user != "" & $f_email != "") { $user_query .= " AND"; }
  if($f_email != "") { $user_query .= " user_email LIKE '%$f_email%'"; }
  if(($f_user != "" | $f_email != "") & $f_level != "") { $user_query .= " AND"; }
  if($f_level != "") { $user_query .= " user_level_id='$f_level'"; }
  if(($f_user != "" | $f_email != "" | $f_level != "") & $f_subnet != "") { $user_query .= " AND"; }
  if($f_subnet != "") { $user_query .= " user_subnet_id='$f_subnet'"; }
  if(($f_user != "" | $f_email != "" | $f_level != "" | $f_subnet != "") & $f_enabled != "") { $user_query .= " AND"; }
  if($f_enabled != "") { $user_query .= " user_enabled='$f_enabled'"; }
}





// GET TOTAL USERS
$total_users = $database->database_num_rows($database->database_query($user_query));

// MAKE USER PAGES
$users_per_page = 100;
$page_vars = make_page($total_users, $users_per_page, $p);

$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
			  'link' => $link);
}

$user_query .= " ORDER BY $sort LIMIT $page_vars[0], $users_per_page";






// DELETE MULTIPLE USERS
if($task == "dodelete") {
  $thisusers = $database->database_query($user_query);
  while($thisuser_info = $database->database_fetch_assoc($thisusers)) {
    $delete = 0;
    $var = "item_".$thisuser_info[user_id];
    $delete = $_POST[$var];
    if($delete == 1) {
      $user = new PHPS_User(Array($thisuser_info[user_id]), Array('user_id'));
      $user->user_delete();
      $total_users = $total_users - 1;
    }
  }
}



// LOOP OVER USER LEVELS
$levels = $database->database_query("SELECT level_id, level_name FROM phps_levels ORDER BY level_name");
while($level_info = $database->database_fetch_assoc($levels)) {
  $level_array[$level_info[level_id]] = Array('level_id' => $level_info[level_id],
			'level_name' => $level_info[level_name]);
}


// LOOP OVER SUBNETWORKS
$subnets = $database->database_query("SELECT subnet_id, subnet_name FROM phps_subnets ORDER BY subnet_name");
$subnet_array[0] = Array('subnet_id' => 0, 'subnet_name' => $admin_viewusers[26]);
while($subnet_info = $database->database_fetch_assoc($subnets)) {
  $subnet_array[$subnet_info[subnet_id]] = Array('subnet_id' => $subnet_info[subnet_id],
		       'subnet_name' => $subnet_info[subnet_name]);
}


// PULL USERS INTO AN ARRAY
$user_array = Array();
$user_count = 0;
$users = $database->database_query($user_query);
while($user_info = $database->database_fetch_assoc($users)) {
  if($user_info[user_enabled] == "0") { $user_enabled = $admin_viewusers[10]; } else { $user_enabled = $admin_viewusers[9]; }

//  $level = $database->database_fetch_assoc($database->database_query("SELECT level_name FROM phps_levels WHERE level_id='$user_info[user_level_id]'"));

  $user_array[$user_count] = Array('user_id' => $user_info[user_id],
				   'user_username' => $user_info[user_username],
				   'user_email' => $user_info[user_email],
				   'user_level_id' => $user_info[user_level_id],
				   'user_level' => $level_array[$user_info[user_level_id]][level_name],
				   'user_subnet' => $subnet_array[$user_info[user_subnet_id]][subnet_name],
				   'user_enabled' => $user_enabled,
				   'user_verified' => $user_info[user_verified],
				   'user_signupdate' => $user_info[user_signupdate]);
  $user_count++;
}




// ASSIGN VARIABLES AND SHOW VIEW USERS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('total_users', $total_users);
$smarty->assign('pages', $page_array);
$smarty->assign('users', $user_array);
$smarty->assign('i', $i);
$smarty->assign('u', $u);
$smarty->assign('em', $em);
$smarty->assign('v', $v);
$smarty->assign('sd', $sd);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('s', $s);
$smarty->assign('f_user', $f_user);
$smarty->assign('f_email', $f_email);
$smarty->assign('f_level', $f_level);
$smarty->assign('f_subnet', $f_subnet);
$smarty->assign('f_enabled', $f_enabled);
$smarty->assign('user_verification', $setting[setting_signup_verify]);
$smarty->assign('levels', array_values($level_array));
$smarty->assign('subnets', array_values($subnet_array));
$smarty->display("$page.tpl");
exit();
?>