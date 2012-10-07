<?php
$page = "SearchAdvanced";
include "Header.php";

if($user->user_exists == 0 & $setting[setting_permission_search] == 0) {
  $page = "Error";
  $smarty->assign('error_header', $Application[314]);
  $smarty->assign('error_message', $Application[313]);
  $smarty->assign('error_submit', $Application[315]);
  include "Footer.php";
}

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }


$showfields = 1;
$linkedfield_title = "";
$linkedfield_value = "";
$sort = "user_dateupdated DESC";
$users_per_page = 20;


// browse user with a specific value
// linked from profile
if($task == "browse") {

  // get basic vars
  $field_id = $_GET['field_id'];
  $field_value = $_GET['field_value'];
  $browse_field_value = $field_value;
  $url_string = "field_id=".$field_id."&field_value=".urlencode($field_value)."&";
  $showfields = 0;

  $browse_query = "SELECT phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_profiles LEFT JOIN phps_users ON phps_profiles.profile_user_id=phps_users.user_id LEFT JOIN phps_levels ON phps_levels.level_id=phps_users.user_level_id WHERE phps_users.user_verified='1' AND phps_users.user_enabled='1' AND (phps_users.user_privacy_search='1' OR phps_levels.level_profile_search='0')";

  // get field info
  $field_info = $database->database_fetch_assoc($database->database_query("SELECT field_id, field_title, field_type, field_options, field_dependency FROM phps_fields WHERE field_id='$field_id'"));
  $linkedfield_title = $field_info[field_title];

  // get parent field info
  if($field_info[field_dependency] != 0) { 
    $parent_field_info = $database->database_fetch_assoc($database->database_query("SELECT field_title, field_type, field_options FROM phps_fields WHERE field_id='$field_info[field_dependency]'"));
    $parent_field_title = $parent_field_info[field_title];
    if($parent_field_info[field_type] == 3 | $parent_field_info[field_type] == 4) {
      $options = explode("<~!~>", $parent_field_info[field_options]);
      for($i=0,$max=count($options);$i<$max;$i++) {
        if(str_replace(" ", "", $options[$i]) != "") {
          $option = explode("<!>", $options[$i]);
          $option_id = $option[0];
	  $option_label = $option[1];
	  $option_dependent_field_id = $option[3];
          if($field_info[field_id] == $option[3]) {
            $parent_field_title .= ": $option_label";
          }
        }
      }
    }
    $linkedfield_title = $parent_field_title." ".$linkedfield_title;
  }

  // get field value
  switch($field_info[field_type]) {
    case 1:
    case 2:
      $browse_field_value = "%".$field_value."%";
      $linkedfield_value = $field_value;
      break;
    case 3:
    case 4:
      $options = explode("<~!~>", $field_info[field_options]);
      for($i=0,$max=count($options);$i<$max;$i++) {
        if(str_replace(" ", "", $options[$i]) != "") {
          $option = explode("<!>", $options[$i]);
          $option_id = $option[0];
	  $option_label = $option[1];
          if($field_value == $option_id) {
            $linkedfield_value = $option_label;
          }
        }
      }
      break;
    case 5:
      $linkedfield_value = $datetime->cdate($setting[setting_dateformat], $field_value);
      break;
  }

  // finish browse query
  $browse_query .= " AND profile_".$field_info[field_id]." LIKE '$browse_field_value'";

  // get total users
  $total_users = $database->database_num_rows($database->database_query($browse_query));

  // make browse pages
  $page_vars = make_page($total_users, $users_per_page, $p);

  $browse_query .= " ORDER BY $sort LIMIT $page_vars[0], $users_per_page";

  // get users
  $users = $database->database_query($browse_query);
  $user_array = Array();
  while($user_info = $database->database_fetch_assoc($users)) {
    $browse_user = new PHPS_User();
    $browse_user->user_info[user_id] = $user_info[user_id];
    $browse_user->user_info[user_username] = $user_info[user_username];
    $browse_user->user_info[user_photo] = $user_info[user_photo];
    $user_array[] = $browse_user;
  }



// search through user based on many profile criteria
} else {

  // get filds list
  $searcher = new PHPS_User();
  $searcher->user_fields(0, 0, 0, 0, 0, 1);
  $tab_array = $searcher->profile_tabs;
  $url_string = $searcher->url_string;

  // perform search
  if($task == "dosearch" OR $task == "main") {
    if(isset($_POST['sort'])) { $sort = $_POST['sort']; } elseif(isset($_GET['sort'])) { $sort = $_GET['sort']; } else { $sort = "user_dateupdated DESC"; }

    // search query
    $search_query = "SELECT phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_profiles LEFT JOIN phps_users ON phps_profiles.profile_user_id=phps_users.user_id LEFT JOIN phps_levels ON phps_levels.level_id=phps_users.user_level_id WHERE phps_users.user_verified='1' AND phps_users.user_enabled='1' AND (phps_users.user_privacy_search='1' OR phps_levels.level_profile_search='0')";
    if($searcher->profile_field_query != "") { $search_query .= " AND ".$searcher->profile_field_query; }

    // get total users
    $total_users = $database->database_num_rows($database->database_query($search_query));

    // make search pages
    $page_vars = make_page($total_users, $users_per_page, $p);

    $search_query .= " ORDER BY $sort LIMIT $page_vars[0], $users_per_page";

    // get users
    $users = $database->database_query($search_query);
    $user_array = Array();
    $online_users_array = online_users();
    while($user_info = $database->database_fetch_assoc($users)) {
      $search_user = new PHPS_User();
      $search_user->user_info[user_id] = $user_info[user_id];
      $search_user->user_info[user_username] = $user_info[user_username];
      $search_user->user_info[user_photo] = $user_info[user_photo];

      // check if user is online
      if(in_array($search_user->user_info[user_username], $online_users_array)) { 
        $search_user->user_info[user_online] = 1; 
      } else { 
        $search_user->user_info[user_online] = 0; 
      }

      $user_array[] = $search_user;
    }
  }
}

$smarty->assign('page', $page);
$smarty->assign('users', $user_array);
$smarty->assign('total_users', $total_users);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($user_array));
$smarty->assign('showfields', $showfields);
$smarty->assign('url_string', $url_string);
$smarty->assign('linkedfield_title', $linkedfield_title);
$smarty->assign('linkedfield_value', $linkedfield_value);
$smarty->assign('task', $task);
$smarty->assign('tabs', $tab_array);
$smarty->assign('sort', $sort);
include "Footer.php";
?>