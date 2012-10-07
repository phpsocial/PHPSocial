<?php
$page = "AdminAdsEdit";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['ad_id'])) { $ad_id = $_POST['ad_id']; } elseif(isset($_GET['ad_id'])) { $ad_id = $_GET['ad_id']; } else { $ad_id = 0; }








// BLANK PRE-UPLOAD PAGE
if($task == "blank") {
  exit;
}





// CANCEL BANNER (DELETE FROM SERVER AFTER ITS BEEN UPLOADED)
if($task == "cancelbanner") {
  $banner_filename = $_POST['banner_filename_delete'];
  $bannerfile = "../uploads_admin/ads/$banner_filename";
  if(@file_exists($bannerfile)) {
    unlink($bannerfile);
  }
  echo "
  <html>
  <head>
  </head>
  <body>
  </body>
  </html>
  ";
  exit;
}





// DO BANNER UPLOAD
if($task == "doupload") {

  // SET KEY VARIABLES
  $file_maxsize = "204800";
  $file_exts = Array('jpg', 'jpeg', 'gif', 'png');
  $file_types = Array('image/jpeg', 'image/jpg', 'image/jpe', 'image/pjpeg', 'image/pjpg', 'image/x-jpeg', 'x-jpg', 'image/gif', 'image/x-gif', 'image/png', 'image/x-png');
  $file_maxwidth = "1000"; 
  $file_maxheight = "1000";
  $ext = str_replace(".", "", strrchr($_FILES['file1']['name'], "."));
  $rand = rand(100000000, 999999999);
  $photo_newname = "banner$rand.".$ext;
  $file_dest = "../uploads_admin/ads/$photo_newname"; 
  $photo_name = "file1"; 
  $new_photo = new PHPS_Upload();
  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

  // UPLOAD PHOTO IF NO ERROR
  if($new_photo->is_error == 0) {
    $new_photo->upload_file($file_dest);
  }

  $new_photo->error_message = str_replace("'", "\\'", $new_photo->error_message);

  echo "
  <html>
  <head>
  </head>
  <body onload=\"parent.uploadbanner2('$photo_newname', '".$new_photo->is_error."', '".$new_photo->error_message."');\">
  </body>
  </html>
  ";

exit;
}

















// VERIFY THAT THIS AD EXISTS
$ad_query = $database->database_query("SELECT * FROM phps_ads WHERE ad_id='$ad_id' LIMIT 1");
if($database->database_num_rows($ad_query) != 1) {
  header("Location: AdminAds.php"); exit;
} else {
  $ad_info = $database->database_fetch_assoc($ad_query);
}



// SET CURRENT VALUES
$ad_html = $ad_info[ad_html];
$ad_name = $ad_info[ad_name];
$ad_position = $ad_info[ad_position];
$ad_date_start_month = $datetime->cdate('M', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
$ad_date_start_day = $datetime->cdate('j', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
$ad_date_start_year = $datetime->cdate('Y', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
$ad_date_start_hour = $datetime->cdate('g', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
$ad_date_start_minute = $datetime->cdate('i', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
$ad_date_start_ampm = $datetime->cdate('A', $datetime->timezone($ad_info[ad_date_start], $setting[setting_timezone]));
if($ad_info[ad_date_end] != 0 AND $ad_info[ad_date_end] != "") {
  $ad_date_end_options = 1;
  $ad_date_end_month = $datetime->cdate('M', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
  $ad_date_end_day = $datetime->cdate('j', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
  $ad_date_end_year = $datetime->cdate('Y', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
  $ad_date_end_hour = $datetime->cdate('g', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
  $ad_date_end_minute = $datetime->cdate('i', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
  $ad_date_end_ampm = $datetime->cdate('A', $datetime->timezone($ad_info[ad_date_end], $setting[setting_timezone]));
}

$ad_limit_views = $ad_info[ad_limit_views];
if($ad_limit_views != 0 AND $ad_limit_views != "") {
  $ad_limit_views_unlimited = "unchecked";
}

$ad_limit_clicks = $ad_info[ad_limit_clicks];
if($ad_limit_clicks != 0 AND $ad_limit_clicks != "") {
  $ad_limit_clicks_unlimited = "unchecked";
}

$ad_limit_ctr = $ad_info[ad_limit_ctr];
if($ad_limit_ctr != 0 AND $ad_limit_ctr != "") {
  $ad_limit_ctr_unlimited = "unchecked";
}

$ad_levels_array = $ad_info[ad_levels];
$ad_subnets_array = $ad_info[ad_subnets];
$ad_public = $ad_info[ad_public];






// SET EMPTY VARIABLES
$is_error = 0;
$error_message = "";










if($task == "dosave") {

  // GET BANNER HTML
  $ad_html = $_POST['ad_html'];
  if($ad_html == "") {
    $is_error = 1;
    $error_message = $admin_ads_edit[1];
  }

  // GET CAMPAIGN NAME
  $ad_name = $_POST['ad_name'];
  if($is_error == 0 AND $ad_name == "") {
    $is_error = 1;
    $error_message = $admin_ads_edit[2];
  }

  // CONSTRUCT START DATE
  $ad_date_start_month = $_POST['ad_date_start_month'];
  $ad_date_start_day = $_POST['ad_date_start_day'];
  $ad_date_start_year = $_POST['ad_date_start_year'];
  $ad_date_start_hour = $_POST['ad_date_start_hour'];
  $ad_date_start_minute = $_POST['ad_date_start_minute'];
  $ad_date_start_ampm = $_POST['ad_date_start_ampm'];

  // PHP 4's strtotime doesn't like AM/PM
  $ad_date_start_hour_absolute = $ad_date_start_hour + ( $ad_date_start_ampm=='PM' ? 12 : 0 );

  // Convert the time zone to a format compatible with
  $adtz = ( $setting[setting_timezone] ? $setting[setting_timezone]."00" : ' GMT' );
  $adtz = preg_replace('/^([-]*)(\d\d\d)$/', '${1}0\2', $adtz);

  // Format it all pretty like for strtotime
  $datestring_start = sprintf('%1$02s %2$s %3$s %4$02s:%5$02s:%6$02s %7$s',
    $ad_date_start_day,
    $ad_date_start_month,
    $ad_date_start_year,
    $ad_date_start_hour_absolute,
    $ad_date_start_minute,
    '0',
    $adtz
  );

  $ad_date_start = strtotime($datestring_start); 

  if($is_error == 0 AND ($ad_date_start_month == "" OR $ad_date_start_day == "" OR $ad_date_start_year == "" OR $ad_date_start_hour == "" OR $ad_date_start_minute == "" OR $ad_date_start_ampm == "")) {
    $is_error = 1;
    $error_message = $admin_ads_edit[3];
  }

  // CONSTRUCT END DATE
  $ad_date_end_options = $_POST['ad_date_end_options'];
  if($ad_date_end_options == 0) {
    $ad_date_end = 0;
  } else {
    $ad_date_end_month = $_POST['ad_date_end_month'];
    $ad_date_end_day = $_POST['ad_date_end_day'];
    $ad_date_end_year = $_POST['ad_date_end_year'];
    $ad_date_end_hour = $_POST['ad_date_end_hour'];
    $ad_date_end_minute = $_POST['ad_date_end_minute'];
    $ad_date_end_ampm = $_POST['ad_date_end_ampm'];

    // PHP 4's strtotime doesn't like AM/PM
    $ad_date_end_hour_absolute = $ad_date_end_hour + ( $ad_date_end_ampm=='PM' ? 12 : 0 );

    // Convert the time zone to a format compatible with
    $adtz = ( $setting[setting_timezone] ? $setting[setting_timezone]."00" : ' GMT' );
    $adtz = preg_replace('/^([-]*)(\d\d\d)$/', '${1}0\2', $adtz);

    // Format it all pretty like for strtotime
    $datestring_end = sprintf('%1$02s %2$s %3$s %4$02s:%5$02s:%6$02s %7$s',
      $ad_date_end_day,
      $ad_date_end_month,
      $ad_date_end_year,
      $ad_date_end_hour_absolute,
      $ad_date_end_minute,
      '0',
      $adtz
    );

    $ad_date_end = strtotime($datestring_end); 

    if($is_error == 0 AND ($ad_date_end_month == "" OR $ad_date_end_day == "" OR $ad_date_end_year == "" OR $ad_date_end_hour == "" OR $ad_date_end_minute == "" OR $ad_date_end_ampm == "")) {
      $is_error = 1;
      $error_message = $admin_ads_edit[4];
    }
    if($is_error == 0 AND $ad_date_end <= $ad_date_start) {
      $is_error = 1;
      $error_message = $admin_ads_edit[5];
    }
  }

  // DETERMINE VIEWS LIMIT
  $ad_limit_views_unlimited = $_POST['ad_limit_views_unlimited'];
  if($ad_limit_views_unlimited == 1) {
    $ad_limit_views = 0;
  } else {
    $ad_limit_views_unlimited = "unchecked";
    $ad_limit_views = $_POST['ad_limit_views'];
    $ad_limit_views = str_replace(",", "", $ad_limit_views);
    $ad_limit_views = str_replace(".", "", $ad_limit_views);
    $ad_limit_views = (int)$ad_limit_views;
    if($is_error == 0 AND ($ad_limit_views == "" OR !is_int($ad_limit_views))) {
      $is_error = 1;
      $error_message = $admin_ads_edit[6];
      $ad_limit_views = "";
    }
  }

  // DETERMINE CLICKS LIMIT
  $ad_limit_clicks_unlimited = $_POST['ad_limit_clicks_unlimited'];
  if($ad_limit_clicks_unlimited == 1) {
    $ad_limit_clicks = 0;
  } else {
    $ad_limit_clicks_unlimited = "unchecked";
    $ad_limit_clicks = $_POST['ad_limit_clicks'];
    $ad_limit_clicks = str_replace(",", "", $ad_limit_clicks);
    $ad_limit_clicks = str_replace(".", "", $ad_limit_clicks);
    $ad_limit_clicks = (int)$ad_limit_clicks;
    if($is_error == 0 AND ($ad_limit_clicks == "" OR !is_int($ad_limit_clicks))) {
      $is_error = 1;
      $error_message = $admin_ads_edit[7];
      $ad_limit_clicks = "";
    }
  }

  // DETERMINE MINIMUM CTR LIMIT
  $ad_limit_ctr_unlimited = $_POST['ad_limit_ctr_unlimited'];
  if($ad_limit_ctr_unlimited == 1) {
    $ad_limit_ctr = 0;
  } else {
    $ad_limit_ctr_unlimited = "unchecked";
    $ad_limit_ctr = $_POST['ad_limit_ctr'];
    $ad_limit_ctr = str_replace("%", "", $ad_limit_ctr);
    if($is_error == 0 AND (!is_numeric($ad_limit_ctr) OR $ad_limit_ctr > 100)) {
      $is_error = 1;
      $error_message = "$admin_ads_edit[8]";
      $ad_limit_ctr = "";
    }
  }

  // DETERMINE AD POSITION
  $ad_position = $_POST['banner_position'];

  // SET USER LEVELS AUDIENCE
  $ad_levels = $_POST['ad_levels'];
  if($ad_levels) {
    $ad_levels_array = "";
    foreach($ad_levels as $ad_level) {
      $ad_levels_array .= ",$ad_level";
    }
    $ad_levels_array .= ",";
  }

  // SET SUBNETS AUDIENCE
  $ad_subnets = $_POST['ad_subnets'];
  if($ad_subnets) {
    $ad_subnets_array = "";
    foreach($ad_subnets as $ad_subnet) {
      $ad_subnets_array .= ",$ad_subnet";
    }
    $ad_subnets_array .= ",";
  }

  // GET SHOW TO PUBLIC SETTING
  $ad_public = $_POST['ad_public'];

  // GET AD FILENAME
  $ad_filename = $_POST['banner_filename'];

  // DELETE OLD AD BANNER BEFORE REPLACING WITH NEW ONE
  if($ad_filename && $ad_info[ad_filename] && $ad_info[ad_filename]!=$ad_filename) {
    $banner_filename = $ad_info[ad_filename];
    $bannerfile = "../uploads_admin/ads/$banner_filename";
    if(@file_exists($bannerfile)) {
      @unlink($bannerfile);
    }
  }

  // IF NO ERROR, INSERT INTO ADS TABLE
  if($is_error == 0) {
    $database->database_query("UPDATE phps_ads SET ad_name='$ad_name',
						 ad_date_start='$ad_date_start',
						 ad_date_end='$ad_date_end',
						 ad_limit_views='$ad_limit_views',
						 ad_limit_clicks='$ad_limit_clicks',
						 ad_limit_ctr='$ad_limit_ctr',
						 ad_public='$ad_public',
						 ad_position='$ad_position',
						 ad_levels='$ad_levels_array',
						 ad_subnets='$ad_subnets_array',
						 ad_html='$ad_html',
						 ad_filename='$ad_filename' WHERE ad_id='$ad_id' LIMIT 1");
    header("Location: AdminAds.php");
    exit;
  }

}




// GET USER LEVELS
$levels = $database->database_query("SELECT level_id, level_name, level_default FROM phps_levels");
$level_array = Array();
$level_count = 0;
$ad_levels_array = explode(",", $ad_levels_array);
while($level_info = $database->database_fetch_assoc($levels)) {

  if(in_array($level_info[level_id], $ad_levels_array)) { 
    $level_selected = 1; 
  } else { 
    $level_selected = 0; 
  }

  $level_array[$level_count] = Array('level_id' => $level_info[level_id],
				     'level_name' => $level_info[level_name],
				     'level_default' => $level_info[level_default],
				     'level_selected' => $level_selected);
  $level_count++;
}





// GET SUBNETS
$subnets = $database->database_query("SELECT subnet_id, subnet_name FROM phps_subnets");
$subnet_array = Array();
$subnet_count = 0;
$ad_subnets_array = explode(",", $ad_subnets_array);


// ADD THE DEFAULT SUBNETWORK FIRST
if(in_array("0", $ad_subnets_array)) {
  $subnet_selected = 1;
} else {
  $subnet_selected = 0;
}
$subnet_array[$subnet_count] = Array('subnet_id' => "0",
				     'subnet_name' => $admin_ads_edit[66],
				     'subnet_selected' => $subnet_selected);
$subnet_count++;

// NOW ADD THE REST
while($subnet_info = $database->database_fetch_assoc($subnets)) {

  if(in_array($subnet_info[subnet_id], $ad_subnets_array)) { 
    $subnet_selected = 1;
  } else { 
    $subnet_selected = 0; 
  }

  $subnet_array[$subnet_count] = Array('subnet_id' => $subnet_info[subnet_id],
				       'subnet_name' => $subnet_info[subnet_name],
				       'subnet_selected' => $subnet_selected);
  $subnet_count++;
}











// GET CURRENT TIME
$nowdate = $datetime->cdate('M j Y \a\t g:i A', $datetime->timezone(time(), $setting[setting_timezone]));

// PRESET START DATE WITH CURRENT TIME
if($ad_date_start_month == "") {
  $ad_date_start_month = $datetime->cdate('M', $datetime->timezone(time(), $setting[setting_timezone]));
}
if($ad_date_start_day == "") {
  $ad_date_start_day = $datetime->cdate('j', $datetime->timezone(time(), $setting[setting_timezone]));
}
if($ad_date_start_year == "") {
  $ad_date_start_year = $datetime->cdate('Y', $datetime->timezone(time(), $setting[setting_timezone]));
}
if($ad_date_start_hour == "") {
  $ad_date_start_hour = $datetime->cdate('g', $datetime->timezone(time(), $setting[setting_timezone]));
}
if($ad_date_start_minute == "") {
  $ad_date_start_minute = $datetime->cdate('i', $datetime->timezone(time(), $setting[setting_timezone]));
}
if($ad_date_start_ampm == "") {
  $ad_date_start_ampm = $datetime->cdate('A', $datetime->timezone(time(), $setting[setting_timezone]));
}



// REMOVE ZEROS FROM DISPLAY
if($ad_limit_views == 0) { $ad_limit_views = ""; }
if($ad_limit_clicks == 0) { $ad_limit_clicks = ""; }
if($ad_limit_ctr == 0) { $ad_limit_ctr = ""; }



// ADD PERCENT SIGN TO MIN CTR VALUE
if($ad_limit_ctr != "") {
  $ad_limit_ctr .= "%";
}



// ASSIGN VARIABLES AND SHOW ADMIN ADS PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign("ad_id", $ad_id);
$smarty->assign("task", $task);
$smarty->assign("is_error", $is_error);
$smarty->assign("error_message", $error_message);
$smarty->assign("nowdate", $nowdate);
$smarty->assign("levels", $level_array);
$smarty->assign("levels_total", $level_count);
$smarty->assign("subnets", $subnet_array);
$smarty->assign("subnets_total", $subnet_count);
$smarty->assign("ad_html", htmlspecialchars_decode($ad_html, ENT_QUOTES));
$smarty->assign("ad_html_encoded", $ad_html);
$smarty->assign("ad_name", $ad_name);
$smarty->assign("ad_date_start_month", $ad_date_start_month);
$smarty->assign("ad_date_start_day", $ad_date_start_day);
$smarty->assign("ad_date_start_year", $ad_date_start_year);
$smarty->assign("ad_date_start_hour", $ad_date_start_hour);
$smarty->assign("ad_date_start_minute", $ad_date_start_minute);
$smarty->assign("ad_date_start_ampm", $ad_date_start_ampm);
$smarty->assign("ad_date_end_options", $ad_date_end_options);
$smarty->assign("ad_date_end_month", $ad_date_end_month);
$smarty->assign("ad_date_end_day", $ad_date_end_day);
$smarty->assign("ad_date_end_year", $ad_date_end_year);
$smarty->assign("ad_date_end_hour", $ad_date_end_hour);
$smarty->assign("ad_date_end_minute", $ad_date_end_minute);
$smarty->assign("ad_date_end_ampm", $ad_date_end_ampm);
$smarty->assign("ad_limit_views_unlimited", $ad_limit_views_unlimited);
$smarty->assign("ad_limit_views", $ad_limit_views);
$smarty->assign("ad_limit_clicks_unlimited", $ad_limit_clicks_unlimited);
$smarty->assign("ad_limit_clicks", $ad_limit_clicks);
$smarty->assign("ad_limit_ctr_unlimited", $ad_limit_ctr_unlimited);
$smarty->assign("ad_limit_ctr", $ad_limit_ctr);
$smarty->assign("ad_public", $ad_public);
$smarty->assign("ad_position", $ad_position);
$smarty->display("$page.tpl");
exit();
?>



