<?php
/**
 * General functions
 * 
 */


/**
 * this funcxtion chenges location header to redirect for IIS prior to setting cookies
 *
 * @param string $url
 */
function cheader($url) {
	if(ereg("Microsoft", $_SERVER['SERVER_SOFTWARE'])) {
	  header("Refresh: 0; URL=$url");
	} else {
	  header("Location: $url");
	}
	exit();
} 

/**
 * Returns appropriate page vars
 *
 * @param integer $total_items
 * @param integer $items_per_page
 * @param integer $p
 * @return array
 */
function make_page($total_items, $items_per_page, $p) {

	if(($total_items % $items_per_page) != 0) { $maxpage = ($total_items) / $items_per_page + 1; } else { $maxpage = ($total_items) / $items_per_page; }
	$maxpage = (int) $maxpage;
	if($maxpage <= 0) { $maxpage = 1; }
	if($p > $maxpage) { $p = $maxpage; } elseif($p < 1) { $p = 1; }
	$start = ($p - 1) * $items_per_page;

	return array($start, $p, $maxpage);

} 


/**
 * Bumps login log
 *
 * @global PHPS_Database $database
 */
function bumplog() {
	global $database;
	$log_entries = $database->database_num_rows($database->database_query("SELECT login_id FROM phps_logins"));
	if($log_entries > 1000) {
	  $oldest_log = $database->database_fetch_assoc($database->database_query("SELECT login_id FROM phps_logins ORDER BY login_id ASC LIMIT 0,1"));
	  $database->database_query("DELETE FROM phps_logins WHERE login_id='$oldest_log[login_id]'");
	  bumplog();
	}
}

/**
 * Returns random code using given length (default 8)
 *
 * @param integer $len
 * @return string
 */
function randomcode($len="8") {

	$code = NULL;
	for($i=0;$i<$len;$i++) {
	  $char = chr(rand(48,122));
	  while(!ereg("[a-zA-Z0-9]", $char)) {
	    if($char == $lchar) { continue; }
	    $char = chr(rand(48,90));
	  }
	  $pass .= $char;
	  $lchar = $char;
	}
	return $pass;

}

/**
 * Validate email
 *
 * @param string $email
 * @return boolean
 */
function is_email_address($email) {

	$regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
	if(!preg_match($regexp, $email) ) { return false; } else { return true; }

}


/**
 * Represent str_ireplace if not exists
 * 
 */
if(!function_exists('str_ireplace')) {
	function str_ireplace($search, $replace, $subject) {
		$search = preg_quote($search, "/");
		return preg_replace("/".$search."/i", $replace, $subject);
	}
} 

/**
 * Represent htmlspecialchars_decode if not exists
 * 
 */
if(!function_exists('htmlspecialchars_decode')) {
	function htmlspecialchars_decode($text, $ent_quotes = "") {
		$text = str_replace("&quot;", "\"", $text);
		$text = str_replace("&#039;", "'", $text);
		$text = str_replace("&lt;", "<", $text);
		$text = str_replace("&gt;", ">", $text);
		$text = str_replace("&amp;", "&", $text);
		return $text;
	}
}


/**
 * Represent str_split if not exists
 *
 */
if(!function_exists('str_split')) { 
	function str_split($string, $split_length = 1) {
		$count = strlen($string);
		if($split_length < 1) {
		  return false;
		} elseif($split_length > $count) {
		  return array($string);
		} else {
		  $num = (int)ceil($count/$split_length);
		  $ret = array();
		  for($i=0;$i<$num;$i++) {
			$ret[] = substr($string,$i*$split_length,$split_length);
		  }
		  return $ret;
		}
	}  
}

/**
 * Doing security thing (strip slashes, htmlspecialchars, etc...)
 *
 * @param string $value
 * @return string
 */
function security($value) {
	if(is_array($value)) {
	  $value = array_map('security', $value);
	} else {
	  if(!get_magic_quotes_gpc()) {
	    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	  } else {
	    $value = htmlspecialchars(stripslashes($value), ENT_QUOTES, 'UTF-8');
	  }
	  $value = str_replace("\\", "\\\\", $value);
	}
	return $value;
}

/**
 * Link fields values
 *
 * @global string $url
 * @param string $field_value
 * @param integer $key
 * @param mixed $additional
 */
function link_field_values(&$field_value, $key, $additional) {
	global $url;

	$field_id = $additional[0];
	$field_browse = $additional[1];
	$field_link = $additional[2];
	$field_browsable = $additional[3];
	$field_value = trim($field_value);
	if(str_replace(" ", "", $field_link) == "") {
	  if($field_browsable == 2) {
	    if($field_browse == "") { $field_browse = urlencode(htmlspecialchars_decode($field_value, ENT_QUOTES)); }
	    $browse_url = $url->url_base."SearchAdvanced.php?task=browse&field_id=".$field_id."&field_value=".$field_browse;
	    if($field_value != "") { $field_value = "<a href='$browse_url'>$field_value</a>"; }
	  }
	} else {
	  if($field_value != "") { 
	    $link_to = str_replace("[field_value]", $field_value, $field_link);
	    $field_value = "<a href='$link_to' target='_blank'>$field_value</a>"; 
	  }
	}

} 

/**
 * Censors word from the string
 *
 * @global array $setting
 * @param string $field_value
 * @return string
 */
function censor($field_value) {
	global $setting;

	$censored_array = explode(",", trim($setting[setting_banned_words]));
	foreach($censored_array as $key => $value) {
	  $replace_value = str_pad("", strlen(trim($value)), "*");
	  $field_value = str_ireplace(trim($value), $replace_value, $field_value);
	}
 
	return $field_value;

}

/**
 * Returns size of a directory
 *
 * @param string $dirname
 * @return integer
 */
function dirsize($dirname) {
	if(!is_dir($dirname) || !is_readable($dirname)) { return false; }

	$dirname_stack[] = $dirname;
	$size = 0;

	do {
	  $dirname = array_shift($dirname_stack);
	  $handle = opendir($dirname);
	  while(false !== ($file = readdir($handle))) {
	    if($file != '.' && $file != '..' && is_readable($dirname . DIRECTORY_SEPARATOR . $file)) {
	      if(is_dir($dirname . DIRECTORY_SEPARATOR . $file)) {
	        $dirname_stack[] = $dirname . DIRECTORY_SEPARATOR . $file;
	      }
	      $size += filesize($dirname . DIRECTORY_SEPARATOR . $file);
	    }
	  }
	  closedir($handle);
	} while(count($dirname_stack) > 0);

	return $size;

}


/**
 * Gets online users
 *
 * @global PHPS_Database $database
 * @return array
 */
function online_users() {
	global $database;

	$onlineusers_array = Array();
	$online_time = time()-10*60;
	$online_users = $database->database_query("SELECT user_username FROM phps_users WHERE user_lastactive>'$online_time' ORDER BY user_lastactive DESC LIMIT 2000");
	while($online_user = $database->database_fetch_assoc($online_users)) {
	  $onlineusers_array[] = $online_user[user_username];
	}
	return $onlineusers_array;
}

/**
 * Gets a privacy level
 *
 * @param string $given_privacy
 * @param string $allowable_privacy
 * @return string
 */
function true_privacy($given_privacy, $allowable_privacy) {

	$true_privacy = $given_privacy;
	$allowable_privacy = str_split($allowable_privacy);
	rsort($allowable_privacy);

	if(!in_array($given_privacy, $allowable_privacy)) {
	  if($given_privacy >= $allowable_privacy[0]) {
	    $true_privacy = $allowable_privacy[0];
	  } else {
	    $allowable_privacy[count($allowable_privacy)+1] = $given_privacy;
	    rsort($allowable_privacy);
	    $given_privacy_key = array_search($given_privacy, $allowable_privacy);
	    $true_privacy = $allowable_privacy[$given_privacy_key-1];
	  }
	}

	return $true_privacy;
}

/**
 * Get text corresponding current privacy level
 *
 * @global array $Application
 * @param string $privacy_level
 * @return string
 */
function user_privacy_levels($privacy_level) {
	global $Application;

	switch($privacy_level) {
	  case 0: $privacy = $Application[62]; break;
	  case 1: $privacy = $Application[63]; break;
	  case 2: $privacy = $Application[64]; break;
	  case 3: $privacy = $Application[65]; break;
	  case 4: $privacy = $Application[66]; break;
	  case 5: $privacy = $Application[67]; break;
	  case 6: $privacy = $Application[68]; break;
	  default: $privacy = ""; break;
	}

	return $privacy;
} 

/**
 * search through the profile information
 *
 * @global PHPS_Database $database
 * @global string $url
 * @global array $Application
 * @global integer $results_per_page
 * @global integer $p
 * @param string $search_text
 * @param boolean $total_only
 * @param array $search_objects
 * @param array $results
 * @param integer $total_results
 */
function search_profile($search_text, $total_only, &$search_objects, &$results, &$total_results) {
	global $database, $url, $Application, $results_per_page, $p;

	$fields = $database->database_query("SELECT field_id, field_type, field_options FROM phps_fields WHERE field_type<>'5' AND (field_dependency<>'0' OR (field_dependency='0' AND (field_browsable='1' OR field_browsable='2')))");
	$profile_query = "phps_users.user_username LIKE '%$search_text%'";
    
	// loop over fields
	while($field_info = $database->database_fetch_assoc($fields)) {
    
	  // text field or textarea
	  if($field_info[field_type] == 1 | $field_info[field_type] == 2) {
	    if($profile_query != "") { $profile_query .= " OR "; }
	    $profile_query .= "phps_profiles.profile_".$field_info[field_id]." LIKE '%$search_text%'";

	  // radio or select box
	  } elseif($field_info[field_type] == 3 | $field_info[field_type] == 4) {
	    // loop over fields options
	    $options = explode("<~!~>", $field_info[field_options]);
	    for($i=0,$max=count($options);$i<$max;$i++) {
	      if(str_replace(" ", "", $options[$i]) != "") {
	        $option = explode("<!>", $options[$i]);
	        $option_id = $option[0];
	        $option_label = $option[1];
	        if(strpos($option_label, $search_text)) {
	          if($profile_query != "") { $profile_query .= " OR "; }
	          $profile_query .= "phps_profiles.profile_".$field_info[field_id]."='$option_id'";
	        }
	      }
	    }
	  }
	}

	// query
	$profile_query = "SELECT phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_profiles LEFT JOIN phps_users ON phps_profiles.profile_user_id=phps_users.user_id LEFT JOIN phps_levels ON phps_levels.level_id=phps_users.user_level_id WHERE phps_users.user_verified='1' AND phps_users.user_enabled='1' AND (phps_users.user_privacy_search='1' OR phps_levels.level_profile_search='0') AND ($profile_query)";

	// get total profiles
	$total_profiles = $database->database_num_rows($database->database_query($profile_query." LIMIT 201"));

	// if not totla only
	if($total_only == 0) {

	  // make profile pages
	  $start = ($p - 1) * $results_per_page;
	  $limit = $results_per_page+1;

	  // search profiles
	  $online_users_array = online_users();
	  $profiles = $database->database_query($profile_query." ORDER BY phps_users.user_id DESC LIMIT $start, $limit");
	  while($profile_info = $database->database_fetch_assoc($profiles)) {

	    // create an object for user
	    $profile = new PHPS_User();
	    $profile->user_info[user_id] = $profile_info[user_id];
	    $profile->user_info[user_username] = $profile_info[user_username];
	    $profile->user_info[user_photo] = $profile_info[user_photo];

	    // check if user online
	    if(in_array($profile_info[user_username], $online_users_array)) { $is_online = 1; } else { $is_online = 0; }

	    $results[] = array('result_url' => $url->url_create('profile', $profile_info[user_username]),
			       'result_icon' => '',
			       'result_name' => $profile_info[user_username].$Application[70],
			       'result_desc' => '',
			       'result_user' => $profile,
			       'result_online' => $is_online);
	  }

	  // set total results
	  $total_results = $total_profiles;

	}

	// set array values
	if($total_profiles > 200) { $total_profiles = "200+"; }
	$search_objects[] = array('search_type' => '0',
				'search_item' => $Application[69],
				'search_total' => $total_profiles);


}

/**
 * Return time in seconds with microseconds
 *
 * @return string
 */
function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
} 



/**
 * Looks for long substring and chops them
 *
 * @param string $text
 * @param integer $size
 * @return string
 */
function ChopText($text, $size = 50) {
    $new_text = '';
    $text_1 = explode('>',$text);
    $sizeof = sizeof($text_1);
    for ($i=0; $i<$sizeof; ++$i) {
        $text_2 = explode('<',$text_1[$i]);
        if (!empty($text_2[0])) {
            $new_text .= preg_replace('#([^\n\r ]{'. $size .'})#i', '\\1 <br>', $text_2[0]);
        }
        if (!empty($text_2[1])) {
            $new_text .= '<' . $text_2[1] . '>';  
        }
    }
    return $new_text;
}
?>