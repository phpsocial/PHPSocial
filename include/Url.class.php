<?php
/**
 * Url class.
 *
 */

class PHPS_Url {

	/**
	 * Error flag
	 *
	 * @var boolean
	 */
	public $is_error;

	/**
	 * Base url
	 *
	 * @var string
	 */
	public $url_base;

	/**
	 * The url conversions
	 * 
	 * @var string
	 */
	public $convert_urls;

	
	public function  __construct() {
	  global $database, $baseurl;

	  $server_array = explode("/", $_SERVER['PHP_SELF']);
	  $server_array_mod = array_pop($server_array);
	  if($server_array[count($server_array)-1] == "admin") { $server_array_mod = array_pop($server_array); }
	  $server_info = implode("/", $server_array);
	  
	  if (strpos($server_info, "plugins")) $server_info = substr($server_info, 0, strpos($server_info, "plugins")-1);
	  
	  $this->url_base = $baseurl;

	  $phps_urls = $database->database_query("SELECT url_file, url_regular, url_subdirectory FROM phps_urls");
	  while($se_url_info = $database->database_fetch_assoc($phps_urls)) {
	    $this->convert_urls[$se_url_info[url_file]] = Array('url_regular' => $se_url_info[url_regular],
								'url_subdirectory' => $se_url_info[url_subdirectory]);
	  }

	  $this->convert_urls['profile'] = Array('url_regular' => 'Profile.php?user=$user',
						'url_subdirectory' => '$user/');

	}

	/**
	 * Create a full url to given page
	 *
	 * @global array $setting
	 * @param string $file
	 * @param PHPS_User $user
	 * @return string
	 */
	public function url_create($file, $user) {
	  global $setting;

	  $url_conversion = $this->convert_urls[$file];
	  
	  if($setting[setting_url] == 1) {
	    $new_url = $url_conversion[url_subdirectory];
	  } else {
	    $new_url = $url_conversion[url_regular];
	  }

	  $num_args = func_num_args();
	  $search = Array('$user');
	  $replace = Array($user);
	  for($a=2;$a<$num_args;$a++) {
	    $search[] = '$id'.($a-1);
	    $replace[] = func_get_arg($a);
	  }

	  $new_url = str_replace($search, $replace, $new_url);

	  return $this->url_base.$new_url;
  
	}

	/**
	 * Return url to the current page
	 *
	 * @return string
	 */
	public function url_current() {
	  $current_url_domain = $_SERVER['HTTP_HOST'];
	  $current_url_path = $_SERVER['SCRIPT_NAME'];
	  $current_url_querystring = $_SERVER['QUERY_STRING'];
	  $current_url = "http://".$current_url_domain.$current_url_path;
	  if($current_url_querystring != "") {  $current_url .= "?".$current_url_querystring; }
	  $current_url = urlencode($current_url);
	  return $current_url;
	}

	/**
	 * Return the path to the given user's directory
	 *
	 * @param integer $user_id
	 * @return string
	 */
	function url_userdir($user_id) {
	  global $baseurl;
	  $subdir = $user_id+999-(($user_id-1)%1000);
	  $userdir = $this->url_base."uploads_user/$subdir/$user_id/";
	  return $userdir;
	}
	/**
	 * Return the path to the given user's directory
	 *
	 * @param integer $user_id
	 * @return string
	 */
	function url_baseuserdir($user_id) {
	  global $baseurl;
	  $subdir = $user_id+999-(($user_id-1)%1000);
	  $userdir = $this->url_base."uploads_user/$subdir/$user_id/";
	  return $userdir;
	}
	/**
	 * Return the path to the given user's directory
	 *
	 * @param integer $user_id
	 * @return string
	 */
	function url_userTRdir($user_id) {
	  global $path2Phps;
	  $subdir = $user_id+999-(($user_id-1)%1000);
	  $userdir = "uploads_user/$subdir/$user_id/";
	  return $userdir;
	}
	
	/**
	 * Return the path to the given user's directory
	 *
	 * @param integer $user_id
	 * @return string
	 */
	function url_userTdir($user_id) {
	  global $path2Phps;
	  $subdir = $user_id+999-(($user_id-1)%1000);
	  $userdir = $path2Phps."uploads_user/$subdir/$user_id/";
	  return $userdir;
	}
	
	/**
	 * urencode wrapper
	 *
	 * @param string $url
	 * @return string
	 */
	function url_encode($url) {
	  return urlencode($url);
	} // END url_encode() METHOD

}
