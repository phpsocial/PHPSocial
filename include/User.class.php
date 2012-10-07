<?php

/**
 * User class.
 */


class PHPS_User {

	/**
	 * Determines wether there is na error
	 *
	 * @var boolean
	 */
	public $is_error;

	/**
	 * Contains error message
	 *
	 * @var string
	 */
	public $error_message;		

	/**
	 * We editing an existing user or not
	 *
	 * @var boolean
	 */
	public $user_exists;

	/**
	 * Contains user details
	 *
	 * @var string
	 */
	public $user_info;

	/**
	 * Contains user's profile data
	 *
	 * @var string
	 */
	public $profile_info;

	/**
	 * Contains user's levels data
	 *
	 * @var string
	 */
	public $level_info;

	/**
	 * Contains user's subnet data
	 *
	 * @var string
	 */
	public $subnet_info;

	/**
	 * Contains user's settings data
	 *
	 * @var string
	 */
	public $usersetting_info;

	/**
	 * Contains the salt. Needed whe encriptiong user password
	 *
	 * @var string
	 */
	public $user_salt;

	/**
	 * Contains array of profile tabs with field arrays
	 *
	 * @var array
	 */
	public $profile_tabs;

	/**
	 * Contains profile fields data from specified tab
	 *
	 * @var array
	 */
	public $profile_fields;

	/**
	 * Contains data of unsaved (new) profie fields values
	 *
	 * @var array
	 */
	public $profile_fields_new;

	/**
	 * Contains db query to save/retrieve profile fields values
	 *
	 * @var string
	 */
	public $profile_field_query;

	/**
	 * Contains url string
	 *
	 * @var string
	 */
	public $url_string;

	/**
	 * Constructor
	 * 
	 * @global PHPS_Database $database
	 * @global array $Application
	 * @param array $user_unique
	 * @param array $select_fields
	 */
	public function PHPS_User($user_unique = array('0', '', ''), $select_fields = array('*', '*', '*', '*')) {
		global $database, $Application;

		$this->is_error = 0;
		$this->error_message = '';
		$this->user_exists = 0;
		$this->user_info[user_id] = 0;

		// verify user data
		if($user_unique[0] != 0 | $user_unique[1] != "" | $user_unique[2] != "") {

			$user_username = strtolower($user_unique[1]);
			$user_email = strtolower($user_unique[2]);

			// select user from the database
			$user = $database->database_query("SELECT $select_fields[0] FROM phps_users WHERE user_id='$user_unique[0]' OR LOWER(user_username)='$user_username' OR LOWER(user_email)='$user_email'");
			if($database->database_num_rows($user) == 1) {
				$this->user_exists = 1;
				$this->user_info = $database->database_fetch_assoc($user);

				// set user salt
				$this->user_salt = "$1$".substr($this->user_info[user_code], 0, 8)."$";

				// select profile information
				if($select_fields[1] != "") { $this->profile_info = $database->database_fetch_assoc($database->database_query("SELECT $select_fields[1] FROM phps_profiles WHERE profile_user_id='".$this->user_info[user_id]."'")); }

				// select user information
				if($select_fields[2] != "") { $this->level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_levels WHERE level_id='".$this->user_info[user_level_id]."'")); }

				// select subnet information
				if($this->user_info[user_subnet_id] != 0) {
					if($select_fields[3] != "") { $this->subnet_info = $database->database_fetch_assoc($database->database_query("SELECT subnet_id, subnet_name FROM phps_subnets WHERE subnet_id='".$this->user_info[user_subnet_id]."'")); }
				} else {
					$this->subnet_info[subnet_id] = 0;
					$this->subnet_info[subnet_name] = $Application[33];
				}
			}
		}

	}

	/**
	 * Populate user settings variable
	 *
	 * @global PHPS_Database object $database
	 * @param string $select_fields
	 */
	public function user_settings($select_fields = "*") {
		global $database;
		$this->usersetting_info = $database->database_fetch_assoc($database->database_query("SELECT $select_fields FROM phps_usersettings WHERE usersetting_user_id='".$this->user_info[user_id]."'"));

	}

	/**
	 * Verify cookies and set lastactivity
	 *
	 * @global PHPS_Database $database
	 * @global array $setting
	 */
	public function user_checkCookies() {
		global $database, $setting;
		if(isset($_COOKIE['user_id']) & isset($_COOKIE['user_email']) & isset($_COOKIE['user_password'])) {
			$user_id = $_COOKIE['user_id'];
		$this->PHPS_User(Array($user_id));
			if($this->user_exists == 0 | $_COOKIE['user_email'] != crypt($this->user_info[user_email], $this->user_salt) | $_COOKIE['user_password'] != $this->user_info[user_password] | ($this->user_info[user_verified] == 0 & $setting[setting_signup_verify] != 0)) {
				$this->user_clear();
			}
		}
		// update last activity if users logged in
		if($this->user_exists != 0) {
			$time_current = time();
			$database->database_query("UPDATE phps_users SET user_lastactive='$time_current' WHERE user_id='".$this->user_info[user_id]."'");
		}
	}


	public function user_login($email, $password, $javascript_disabled = 0, $persistent = 0) {
		global $database, $setting, $Application;

		$this->PHPS_User(Array(0, "", $email));

		$current_time = time();
		$login_result = 0;

		// show error if js is disabled
		if($javascript_disabled == 1) {
			$this->is_error = 1;
			$this->error_message = $Application[34];

		} elseif($this->user_exists == 0) {
			$this->is_error = 1;
			$this->error_message = $Application[35];

		} elseif(str_replace(" ", "", $password) == "" | crypt($password, $this->user_salt) != $this->user_info[user_password]) {
			$this->is_error = 1;
			$this->error_message = $Application[35];

		} elseif($this->user_info[user_enabled] == 0) {
			$this->is_error = 1;
			$this->error_message = $Application[36];

		} elseif($this->user_info[user_verified] == 0 & $setting[setting_signup_verify] != 0) {
			$this->is_error = 1;
			$this->error_message = $Application[37];

		} else {

			$login_result = 1;

			$database->database_query("UPDATE phps_users SET user_lastlogindate='$current_time', user_logins=user_logins+1 WHERE user_id='".$this->user_info[user_id]."'");

			$this->user_setcookies($persistent);

			update_stats("logins");

		}

		$database->database_query("INSERT INTO phps_logins (login_email, login_date, login_ip, login_result) VALUES ('$email', '$current_time', '".$_SERVER['REMOTE_ADDR']."', '$login_result')");
		bumplog();
	}

	/**
	 * Set user's login cookies
	 *
	 * @param integer $persistent
	 */
	public function user_setcookies($persistent = 0) {
		$cookie_id = $cookie_email = $cookie_password = "";
		if(!empty($this->user_info) && !empty($this->user_info['user_email']) && !empty($this->user_info['user_id']) && !empty($this->user_info['user_password'])) {
			$cookie_id = $this->user_info['user_id'];
			$cookie_email = crypt($this->user_info['user_email'], $this->user_salt);
			$cookie_password = $this->user_info['user_password'];
			if($persistent == 0) { $cookie_time = 0; } else { $cookie_time = time()+99999999; }
		} else {
			$cookie_time = time()-3600;
		}

		setcookie("user_id", $cookie_id, $cookie_time, "/");
		setcookie("user_email", $cookie_email, $cookie_time, "/");
		setcookie("user_password", $cookie_password, $cookie_time, "/");

	}

	/**
	 * Clear current object properties
	 *
	 */
	public function user_clear() {
		foreach ($this as $classProp => $propVal) {
			$propVal = is_integer($propVal) ? 0 : '';
			$this->$classProp = $propVal;
		}
	}

	/**
	 * Logout the user
	 *
	 * @global PHPS_Database $database
	 */
	public function user_logout() {
		global $database;
		// clear user's last activity
		$database->database_query("UPDATE phps_users SET user_lastactive='' WHERE user_id='".$this->user_info[user_id]."'");
		// create plain text user's email while logged out
		setcookie("prev_email", $this->user_info[user_email], time()+99999999, "/");
		$this->user_clear();
		$this->user_setcookies();
	}

	/**
	 * Validate user's account input
	 *
	 * @global PHPS_Database $database
	 * @global string $setting
	 * @global array $Application
	 * @param string $email
	 * @param string $username
	 *
	 */
	public function user_account($email, $username) {
		global $database, $setting, $Application, $path2Phps;

		// make sure that fields are filled
		if(str_replace(" ", "", $email) == "" OR str_replace(" ", "", $username) == "") { $this->is_error = 1; $this->error_message = $Application[38]; }

		if(ereg('[^A-Za-z0-9]', $username)) { $this->is_error = 1; $this->error_message = $Application[38]; }

		// check if name banned / no banned
		$banned_usernames = explode(",", strtolower($setting[setting_banned_usernames]));
		if(in_array(strtolower($username), $banned_usernames) === TRUE & str_replace(" ", "", $username) != "")
		{
			$this->is_error = 1; $this->error_message = $Application[39];
			}

		// make sure that username is not reserved
		if(is_dir($path2Phps.$username)) { $this->is_error = 1; $this->error_message = $Application[40]; }

		// make sure that email not banned
		$banned_emails = explode(",", strtolower($setting[setting_banned_emails]));
		$wildcard_ban = "*".strstr(strtolower($email), "@");
		if((in_array(strtolower($email), $banned_emails) === TRUE | in_array(strtolower($wildcard_ban), $banned_emails) === TRUE) & str_replace(" ", "", $email) != "") { $this->is_error = 1; $this->error_message = $Application[41]; }

		// validate email
		if(!is_email_address($email)) { $this->is_error = 1; $this->error_message = $Application[42]; }

		// check that username is unique
		$lowercase_username = strtolower($username);
		$username_query = $database->database_query("SELECT user_username FROM phps_users WHERE LOWER(user_username)='$lowercase_username' LIMIT 1");
		if(strtolower($this->user_info[user_username]) != $lowercase_username & $database->database_num_rows($username_query) != 0) { $this->is_error = 1; $this->error_message = $Application[43]; }

		// check that email is unique
		$lowercase_email = strtolower($email);
		$email_query = $database->database_query("SELECT user_email FROM phps_users WHERE LOWER(user_email)='$lowercase_email' LIMIT 1");
		if(strtolower($this->user_info[user_email]) != $lowercase_email & $database->database_num_rows($email_query) != 0) { $this->is_error = 1; $this->error_message = $Application[44]; }

	}

	/**
	 * Validate user's password
	 *
	 * @global array $Application
	 * @param string $password_old
	 * @param string $password
	 * @param string $password_confirm
	 * @param integer $check_old
	 */
	public function user_password($password_old, $password, $password_confirm, $check_old = 1) {
		global $Application;
		if(str_replace(" ", "", $password) == "" | str_replace(" ", "", $password_confirm) == "" | ($check_old == 1 & str_replace(" ", "", $password_old) == "")) { $this->is_error = 1; $this->error_message = $Application[38]; }
		if($check_old == 1 & crypt($password_old, $this->user_salt) != $this->user_info[user_password]) { $this->is_error = 1; $this->error_message = $Application[45]; }
		if($password != $password_confirm) { $this->is_error = 1; $this->error_message = $Application[46]; }
		if(str_replace(" ", "", $password) != "" & strlen($password) < 6) { $this->is_error = 1; $this->error_message = $Application[47]; }
		if(ereg('[^A-Za-z0-9]', $password)) { $this->is_error = 1; $this->error_message = $Application[48]; }

	}

	/**
	 * Validate user's profile input and create partial database input
	 *
	 * @global PHPS_Database $database
	 * @global PHPS_Datatime $datetime
	 * @global array $setting
	 * @global string $Application
	 * @param integer $tabs_only
	 * @param integer $tab_id
	 * @param integer $validate
	 * @param integer $signup
	 * @param integer $profile
	 * @param integer $search
	 */
	public function user_fields($tabs_only = 0, $tab_id = 0, $validate = 0, $signup = 0, $profile = 0, $search = 0) {
	  global $database, $datetime, $setting, $Application;

	  // include filter
	  if(!class_exists("PHPS_InputFilter")) { include "./include/Inputfilter.class.php"; }

	  // set tab varriables
	  $tab_query = "SELECT * FROM phps_tabs"; if($tab_id != 0) { $tab_query .= " WHERE tab_id='$tab_id'"; } $tab_query .= " ORDER BY tab_order";
	  $tabs = $database->database_query($tab_query);

	  while($tab_info = $database->database_fetch_assoc($tabs)) {

	    if($tabs_only == 0) {
	      $field_count = 0;
	      $this->profile_fields = "";
	      $field_query = "SELECT * FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='0'"; if($signup != 0) { $field_query .= " AND field_signup<>'0'"; } if($profile != 0) { $field_query .= " AND field_browsable<>'-1'"; } if($search != 0) { $field_query .= " AND (field_browsable='1' OR field_browsable='2')"; } $field_query .= " ORDER BY field_order";
	      $fields = $database->database_query($field_query);
	      while($field_info = $database->database_fetch_assoc($fields)) {

	        $is_field_error = 0;
	        $field_value = "";
	        $field_value_profile = "";

	        switch($field_info[field_type]) {

	          case 1: // text field
	          case 2: // textarea

	            if($validate == 1) {

			      $xssFilter = new PHPS_InputFilter(explode(",", $field_info[field_html]), "", 0, 1, 1);
	              $profile_var = "field_".$field_info[field_id];
	              $field_value = security($xssFilter->process(censor($_POST[$profile_var])));

	              if($field_info[field_type] == 2) { $field_value = str_replace("\r\n", "<br>", $field_value); }

	              if($field_info[field_required] != 0 & str_replace(" ", "", $field_value) == "") {
	                $this->is_error = 1;
	                $this->error_message = $Application[38];
	                $is_field_error = 1;
	              }

	              if($field_info[field_regex] != "" & str_replace(" ", "", $field_value) != "") {
	                if(!preg_match($field_info[field_regex], $field_value)) {
	                  $this->is_error = 1;
	                  $this->error_message = $Application[50];
	                  $is_field_error = 1;
	                }
	              }

	              // update save profile query
	              if($this->profile_field_query != "") { $this->profile_field_query .= ", "; }
	              $this->profile_field_query .= "profile_$field_info[field_id]='$field_value'";

		    // create a search query
		    } elseif($search == 1) {
		      $var = "field_".$field_info[field_id];
		      if(isset($_POST[$var])) { $field_value = $_POST[$var]; } elseif(isset($_GET[$var])) { $field_value = $_GET[$var]; } else { $field_value = ""; }
		      if($field_value != "") { 
			if($this->profile_field_query != "") { $this->profile_field_query .= " AND "; } 
			$this->profile_field_query .= "profile_$field_info[field_id] LIKE '%$field_value%'"; 
			$this->url_string .= $var."=".urlencode($field_value)."&";
		      }

	            } else {
	              if($this->profile_info != "") {
	                $profile_column = "profile_".$field_info[field_id];
	                $field_value = $this->profile_info[$profile_column];
	              }
	            }

		    if($profile == 1) {

		      if($field_info[field_browsable] == 2) {
		        $br_exploded_field_values = explode("<br>", trim($field_value));
		        $exploded_field_values = Array();
		        foreach($br_exploded_field_values as $key => $value) {
		          $comma_exploded_field_values = explode(",", trim($value));
		          array_walk($comma_exploded_field_values, 'link_field_values', Array($field_info[field_id], "", $field_info[field_link], $field_info[field_browsable]));
			  $exploded_field_values[$key] = implode(", ", $comma_exploded_field_values);
		        }
		        $field_value_profile = implode("<br>", $exploded_field_values);

		      } else {
			$exploded_field_values = Array(trim($field_value));
			array_walk($exploded_field_values, 'link_field_values', Array($field_info[field_id], "", $field_info[field_link], $field_info[field_browsable]));
			$field_value_profile = implode("", $exploded_field_values);
		      }

		      $field_value_profile = htmlspecialchars_decode($field_value_profile, ENT_QUOTES);

		    } else {
		      if($field_info[field_type] == 2) { $field_value = str_replace("<br>", "\r\n", $field_value); }
		    }
	            break;



	          case 3: // select
	          case 4: // radio button

	            if($validate == 1) {

	              $profile_var = "field_".$field_info[field_id];
	              $field_value = censor($_POST[$profile_var]);

	              if($field_info[field_required] != 0 & $field_value == "-1") {
	                $this->is_error = 1;
	                $this->error_message = $Application[38];
	                $is_field_error = 1;
	              }

	              // update save profile query
	              if($this->profile_field_query != "") { $this->profile_field_query .= ", "; }
	              $this->profile_field_query .= "profile_$field_info[field_id]='$field_value'";


		    // create a search query
		    } elseif($search == 1) {
		      $var = "field_".$field_info[field_id];
		      if(isset($_POST[$var])) { $field_value = $_POST[$var]; } elseif(isset($_GET[$var])) { $field_value = $_GET[$var]; } else { $field_value = ""; }
	              if($field_value != "-1" & $field_value != "") { 
			if($this->profile_field_query != "") { $this->profile_field_query .= " AND "; } 
			$this->profile_field_query .= "profile_$field_info[field_id]='$field_value'"; 
			$this->url_string .= $var."=".urlencode($field_value)."&";
		      }

	            } else {
	              if($this->profile_info != "") {
	                $profile_column = "profile_".$field_info[field_id];
	                $field_value = $this->profile_info[$profile_column];
	              }
	            }

	            $field_options = Array();
	            $options = explode("<~!~>", $field_info[field_options]);
	            $num_options = 0;
	            for($i=0,$max=count($options);$i<$max;$i++) {
	              $dep_field_info = "";
	              $option_dependency = 0;
	              $dep_field_value = "";
	              if(str_replace(" ", "", $options[$i]) != "") {
	                $option = explode("<!>", $options[$i]);
	                $option_id = $option[0];
	                $option_label = $option[1];
	                $option_dependency = $option[2];
	                $option_dependent_field_id = $option[3];

	                if($option_dependency == "1") { 
	                  $dep_field = $database->database_query("SELECT field_id, field_title, field_maxlength, field_link, field_style, field_browsable, field_required, field_regex FROM phps_fields WHERE field_id='$option_dependent_field_id' AND field_dependency='$field_info[field_id]'");
	                  if($database->database_num_rows($dep_field) != "1") {
	                    $dep_field_info = "";
	                    $option_dependency = 0;
	                    $dep_field_value = "";
	                  } else {
	                    $dep_field_info = $database->database_fetch_assoc($dep_field);


	                    if($validate == 1) {
	                      if($field_value == $option_id) {
	                        $dep_profile_var = "field_".$dep_field_info[field_id];
	                        $dep_field_value = censor($_POST[$dep_profile_var]);
  
	                        if($dep_field_info[field_required] != 0 & str_replace(" ", "", $dep_field_value) == "") {
	                          $this->is_error = 1;
	                          $this->error_message = $Application[38];
	                          $is_field_error = 1;
	                        }

	                        if($dep_field_info[field_regex] != "" & str_replace(" ", "", $dep_field_value) != "") {
	                          if(!preg_match($dep_field_info[field_regex], $dep_field_value)) {
	                            $this->is_error = 1;
	                            $this->error_message = $Application[50];
	                            $is_field_error = 1;
	                          }
	                        }

	                      } else {
	                        $dep_field_value = "";
	                      }

	    	              // update save profile query
	    	              if($this->profile_field_query != "") { $this->profile_field_query .= ", "; }
	    	              $this->profile_field_query .= "profile_$dep_field_info[field_id]='$dep_field_value'";


						// do not validate posted field value
	                    } else {
	                      if($this->profile_info != "") {
	                      $profile_column = "profile_".$dep_field_info[field_id];
	                      $dep_field_value = $this->profile_info[$profile_column];
	                      }
	                    }
	                  }
	                }

			// format value for profile if option selected
			if($profile == 1 & $field_value == $option_id) {
			  $field_value_profile = $option_label;

			  // link field values if neccessary
			  if($field_info[field_browsable] == 2) { 
			    link_field_values($field_value_profile, "", Array($field_info[field_id], $option[0], "", $field_info[field_browsable])); 
			    if($dep_field_value != "") { link_field_values($dep_field_value, "", Array($dep_field_info[field_id], "", $dep_field_info[field_link], $dep_field_info[field_browsable])); }
			  }

			  if($dep_field_value != "") { $field_value_profile .= " ".$dep_field_info[field_title]." ".$dep_field_value; }
			}
          
	                // set option arrays
	                $field_options[$num_options] = Array('option_id' => $option_id,
								'option_label' => $option_label,
								'option_dependency' => $option_dependency,
								'dep_field_id' => $dep_field_info[field_id],
								'dep_field_title' => $dep_field_info[field_title],
								'dep_field_required' => $dep_field_info[field_required],
								'dep_field_maxlength' => $dep_field_info[field_maxlength],
								'dep_field_style' => $dep_field_info[field_style],
								'dep_field_value' => $dep_field_value,
								'dep_field_error' => $dep_field_error);
	                $num_options++;
	              }
	            }
	            break;


	          case 5: // date field

		    // set month, day and year format from settings
		    switch($setting[setting_dateformat]) {
		      case "n/j/Y": case "n.j.Y": case "n-j-Y": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		      case "Y/n/j": case "Ynj": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "ymd"; break;
		      case "Y-n-d": $month_format = "n"; $day_format = "d"; $year_format = "Y"; $date_order = "ymd"; break;
		      case "Y-m-d": $month_format = "m"; $day_format = "d"; $year_format = "Y"; $date_order = "ymd"; break;
		      case "j/n/Y": case "j.n.Y": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		      case "M. j, Y": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		      case "F j, Y": case "l, F j, Y": $month_format = "F"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		      case "j F Y": case "D j F Y": case "l j F Y": $month_format = "F"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		      case "D-j-M-Y": case "D j M Y": case "j-M-Y": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		      case "Y-M-j": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "ymd"; break;
		    }  
  

	            // validate posted value
	            if($validate == 1) {
	              // retrive posted value
	              $profile_var1 = "field_".$field_info[field_id]."_1";
	              $profile_var2 = "field_".$field_info[field_id]."_2";
	              $profile_var3 = "field_".$field_info[field_id]."_3";
	              $field_1 = $_POST[$profile_var1];
	              $field_2 = $_POST[$profile_var2];
	              $field_3 = $_POST[$profile_var3];

	              // order date values properly
	              switch($date_order) {
	                case "mdy": $month = $field_1; $day = $field_2; $year = $field_3; break;
	                case "ymd": $year = $field_1; $month = $field_2; $day = $field_3; break;
	                case "dmy": $day = $field_1; $month = $field_2; $year = $field_3; break;
	              }
  
	              // set all to blank
	              if($month == 0 | $day == 0 | $year == 0) { $month = 0; $day = 0; $year = 0; }

	              // create a timestamp
	              $field_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");
  
	              // check for required
	              if($field_info[field_required] != 0 & $field_value == $datetime->MakeTime("0", "0", "0", "0", "0", "0")) {
	                $this->is_error = 1;
	                $this->error_message = $Application[38];
	                $is_field_error = 1;
	              }

	              // update save profile query
	              if($this->profile_field_query != "") { $this->profile_field_query .= ", "; }
	              $this->profile_field_query .= "profile_$field_info[field_id]='$field_value'";


		    // create a search query
		    } elseif($search == 1) {
		      $var1 = "field_".$field_info[field_id]."_1";
		      $var2 = "field_".$field_info[field_id]."_2";
		      $var3 = "field_".$field_info[field_id]."_3";
		      if(isset($_POST[$var1])) { $field_1 = $_POST[$var1]; } elseif(isset($_GET[$var1])) { $field_1 = $_GET[$var1]; } else { $field_1 = ""; }
		      if(isset($_POST[$var2])) { $field_2 = $_POST[$var2]; } elseif(isset($_GET[$var2])) { $field_2 = $_GET[$var2]; } else { $field_2 = ""; }
		      if(isset($_POST[$var3])) { $field_3 = $_POST[$var3]; } elseif(isset($_GET[$var3])) { $field_3 = $_GET[$var3]; } else { $field_3 = ""; }

	              // order date values
	              switch($date_order) {
	                case "mdy": $month = $field_1; $day = $field_2; $year = $field_3; break;
	                case "ymd": $year = $field_1; $month = $field_2; $day = $field_3; break;
	                case "dmy": $day = $field_1; $month = $field_2; $year = $field_3; break;
	              }

	              if($month == 0 | $day == 0 | $year == 0) { $month = 0; $day = 0; $year = 0; }

	              $field_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");

		      
	              if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) { 
                    if($this->profile_field_query != "") { $this->profile_field_query .= " AND "; } 
                    $this->profile_field_query .= "profile_$field_info[field_id]='$field_value'"; 
                    $this->url_string .= $var1."=".urlencode($field_1)."&";
                    $this->url_string .= $var2."=".urlencode($field_2)."&";
                    $this->url_string .= $var3."=".urlencode($field_3)."&";
                  }
    
	              if($this->profile_info != "") {
	                $profile_column = "profile_".$field_info[field_id];
	                $field_value = $this->profile_info[$profile_column];
	              } else {
	                $field_value = $datetime->MakeTime("0", "0", "0", "0", "0", "0");
	              }

	            } else {
	              // retrive db fields value
	              if($this->profile_info != "") {
	                $profile_column = "profile_".$field_info[field_id];
	                $field_value = $this->profile_info[$profile_column];
	              } else {
	                $field_value = $datetime->MakeTime("0", "0", "0", "0", "0", "0");
	              }
	            }


		    // format value for profile
		    if($profile == 1) {
	   	      if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) { 
	                $field_date = $datetime->MakeDate($field_value);
			$field_time = strtotime("$field_date[1] $field_date[3] $field_date[2]");
			$field_value_profile = $datetime->cdate($setting[setting_dateformat], $field_time); 
			if($field_info[field_browsable] == 2) { link_field_values($field_value_profile, "", Array($field_info[field_id], $field_value, "", $field_info[field_browsable])); }
		      }


		    // format value for form
	    	    } 
	    	    
	              // decompose timestamp into day, month and year
	              if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) {
	                $field_date = $datetime->MakeDate($field_value);
	                $field_month = $field_date[0]; $field_day = $field_date[1]; $field_year = $field_date[2];
	              } else {
	                $field_month = 0; $field_day = 0; $field_year = 0;
	              }

	              // create month array
	              $month_array = Array();
	              $month_array[0] = Array('name' => "$Application[59]", 'value' => "0", 'selected' => "");
	              for($m=1;$m<=12;$m++) {
	                if($field_month == $m) { $selected = " SELECTED"; } else { $selected = ""; }
	                $month_array[$m] = Array('name' => $datetime->cdate("$month_format", mktime(0, 0, 0, $m, 1, 1990)),
	    					'value' => $m,
	    					'selected' => $selected);
	              }
  
	              // create days array
	              $day_array = Array();
	              $day_array[0] = Array('name' => "$Application[60]", 'value' => "0", 'selected' => "");
	              for($d=1;$d<=31;$d++) {
	                if($field_day == $d) { $selected = " SELECTED"; } else { $selected = ""; }
	                $day_array[$d] = Array('name' => $datetime->cdate("$day_format", mktime(0, 0, 0, 1, $d, 1990)),
	    					'value' => $d,
	    					'selected' => $selected);
	              }

	              // create years array
	              $year_array = Array();
	              $year_count = 1;
	              $current_year = $datetime->cdate("Y", time());
	              $year_array[0] = Array('name' => "$Application[61]", 'value' => "0", 'selected' => "");
	              for($y=$current_year;$y>=1920;$y--) {
	                if($field_year == $y) { $selected = " SELECTED"; } else { $selected = ""; }
	                $year_array[$year_count] = Array('name' => $y,
	    						'value' => $y,
	    						'selected' => $selected);
	              $year_count++;
	              }

	              // order date arrays
	              switch($date_order) {
	                case "mdy": $date_array1 = $month_array; $date_array2 = $day_array; $date_array3 = $year_array; break;
	                case "ymd": $date_array1 = $year_array; $date_array2 = $month_array; $date_array3 = $day_array; break;
	                case "dmy": $date_array1 = $day_array; $date_array2 = $month_array; $date_array3 = $year_array; break;
	              }
		    
	            break;

	        }

	        // set fields if error acured
	        if($is_field_error == 1) { $field_error = $field_info[field_error]; } else { $field_error = ""; }

	        // set field value array for later use in subnet sorting
	        $this->profile_fields_new["profile_".$field_info[field_id]] = $field_value;

	        if($profile == 0 | ($profile == 1 & $field_value_profile != "")) {
		  $this->profile_fields[] = Array('field_id' => $field_info[field_id], 
						'field_title' => $field_info[field_title], 
						'field_desc' => $field_info[field_desc],
						'field_type' => $field_info[field_type],
						'field_required' => $field_info[field_required],
						'field_style' => $field_info[field_style],
						'field_maxlength' => $field_info[field_maxlength],
						'field_birthday' => $field_info[field_birthday],
						'field_options' => $field_options,
						'field_value' => $field_value,
						'field_value_profile' => $field_value_profile,
						'field_error' => $field_error,
						'date_array1' => $date_array1,
						'date_array2' => $date_array2,
						'date_array3' => $date_array3);
		  $field_count++;
		}

	      } 
	    }

	    // set tab array
	    if($field_count != 0 | $tabs_only == 1) {
	      $this->profile_tabs[] = Array('tab_id' => $tab_info[tab_id], 
						'tab_name' => $tab_info[tab_name], 
						'tab_o' => $tab_o, 
						'tab_status' => $tab_status,
						'tab_order' => $tab_order,
						'fields' => $this->profile_fields);
	    }
	  }
	} 


	/**
	 * Gives subnetwork id using given inputs
	 *
	 * @global PHPS_Database $database
	 * @global PHPS_Datatime $datetime
	 * @global array $setting
	 * @global array $Application
	 * @param string $email
	 * @param array $profile_info
	 * @return integer
	 */
	public function user_subnet_select($email = "", $profile_info = "") {
	  global $database, $datetime, $setting, $Application;

	  // set default values
	  if($email == "") { $email = $this->user_info[user_email]; }
	  if($profile_info == "") { $profile_info = $this->profile_info; }
	  if($this->user_info[user_subnet_id] == "") { $subnet_id = 0; } else { $subnet_id = $this->user_info[user_subnet_id]; }

	  // determine user's primary subnetwork value
	  $field1_val = "";
	  switch($setting[setting_subnet_field1_id]) {
	    case -1: break;
	    case 0: $field1_val = $email; break;
	    default:
	      $field1 = $database->database_query("SELECT field_id, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field1_id]'");
	      if($database->database_num_rows($field1) != 0) {
	        $field1_info = $database->database_fetch_assoc($field1);
	        if($field1_info[field_birthday] == 1) {
	          $field1_val = $datetime->age($profile_info["profile_".$field1_info[field_id]]);
	        } else {
	          $field1_val = $profile_info["profile_".$field1_info[field_id]];
	        }
	      }
	  }

	  // determine user's secondary subnetwork value
	  $field2_val = "";
	  switch($setting[setting_subnet_field2_id]) {
	    case -1: break;
	    case 0: $field2_val = $email; break;
	    default:
	      $field2 = $database->database_query("SELECT field_id, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field2_id]'");
	      if($database->database_num_rows($field2) != 0) {
	        $field2_info = $database->database_fetch_assoc($field2);
	        if($field2_info[field_birthday] == 1) {
	          $field2_val = $datetime->age($profile_info["profile_".$field2_info[field_id]]);
	        } else {
	          $field2_val = $profile_info["profile_".$field2_info[field_id]];
	        }
	      }
	  }

	  // if fields not empty - run query
	  if($field1_val != "") {

	    $field1_val_num = "'".$field1_val."'";
	    $field2_val_num = "'".$field2_val."'";
	    if(is_numeric($field1_val)) { $field1_val_num = str_replace(" ", "", $field1_val); }
	    if(is_numeric($field2_val)) { $field2_val_num = str_replace(" ", "", $field2_val); }

	    // subnetwork query
	    $subnet_query = "SELECT subnet_id, subnet_name FROM phps_subnets WHERE
	    ( 
	      (subnet_field1_qual='==' AND '$field1_val' LIKE REPLACE(subnet_field1_value, '*', '%')) OR
	      (subnet_field1_qual='!=' AND '$field1_val' NOT LIKE REPLACE(subnet_field1_value, '*', '%')) OR
	      (subnet_field1_qual='>' AND subnet_field1_value<$field1_val_num) OR
	      (subnet_field1_qual='<' AND subnet_field1_value>$field1_val_num) OR
	      (subnet_field1_qual='>=' AND subnet_field1_value<=$field1_val_num) OR
	      (subnet_field1_qual='<=' AND subnet_field1_value>=$field1_val_num) OR
	      (subnet_field1_qual='' AND subnet_field1_value='')
	    ) AND (
	      (subnet_field2_qual='==' AND '$field2_val' LIKE REPLACE(subnet_field2_value, '*', '%')) OR
	      (subnet_field2_qual='!=' AND '$field2_val' NOT LIKE REPLACE(subnet_field2_value, '*', '%')) OR
	      (subnet_field2_qual='>' AND subnet_field2_value<$field2_val_num) OR
	      (subnet_field2_qual='<' AND subnet_field2_value>$field2_val_num) OR
	      (subnet_field2_qual='>=' AND subnet_field2_value<=$field2_val_num) OR
	      (subnet_field2_qual='<=' AND subnet_field2_value>=$field2_val_num) OR
	      (subnet_field2_qual='' AND subnet_field2_value='')
	    ) LIMIT 1";

	    $subnet = $database->database_query($subnet_query);
	    if($database->database_num_rows($subnet) != 0) { 
	      $subnet_info = $database->database_fetch_assoc($subnet);
	      $subnet_id = $subnet_info[subnet_id]; 
	    } else {
	      $subnet_id = 0;
	    }

	  }

	  // if subnetwork changed - make note
	  if($subnet_id != $this->user_info[user_subnet_id]) {
	    if($subnet_id != 0) { $new_subnet = $subnet_info[subnet_name]; } else { $new_subnet = $Application[33]; }
	    $subnet_changed = $Application[51].$this->subnet_info[subnet_name].$Application[52]."$new_subnet.";
	    $subnet_changed_verify = $Application[53].$this->subnet_info[subnet_name].$Application[52]."$new_subnet.";
	  }

	  return Array($subnet_id, $new_subnet, $subnet_changed, $subnet_changed_verify);
	  
	}

	/**
	 * Update user last update date
	 *
	 * @global PHPS_Database $database
	 */
	public function user_lastupdate() {
	  global $database;
	  $database->database_query("UPDATE phps_users SET user_dateupdated='".time()."' WHERE user_id='".$this->user_info[user_id]."'");
	}

	/**
	 * Outputs user's photo dir or no photo image
	 *
	 * @global string $url
	 * @param string $nophoto_image
	 * @return string
	 */
	public function user_photo($nophoto_image = "") {
	  global $url;
	  $user_photo = $url->url_userTRdir($this->user_info[user_id]).$this->user_info[user_photo];
	  //if(!file_exists($user_photo) | $this->user_info[user_photo] == "") { $user_photo = $nophoto_image; }
	  if($this->user_info[user_photo] == "") { $user_photo = $nophoto_image; }
	  return $user_photo;
	  
	}
	
	/**
	 * Upload and return user's photo
	 *
	 * @global PHPS_Database $database
	 * @global string $url
	 * @param string $photo_name
	 */
	public function user_photo_upload($photo_name) {
	  global $database, $url;

	  // set key variables
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->level_info[level_photo_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = $this->level_info[level_photo_width];
	  $file_maxheight = $this->level_info[level_photo_height];
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $url->url_userTdir($this->user_info[user_id]).$photo_newname;

	  $new_photo = new PHPS_Upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // upload and resize photo
	  if($new_photo->is_error == 0) {

	    // delete old photo if exists
	    $this->user_photo_delete();

	    // check if resizing is avialable then move uploaded photo
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // update user's info with image
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE phps_users SET user_photo='$photo_newname' WHERE user_id='".$this->user_info[user_id]."'");
	      $this->user_info[user_photo] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;
	  
	}

	/**
	 * Delete user's photo
	 *
	 * @global PHPS_Database $database
	 */
	public function user_photo_delete() {
	  global $database;
	  $user_photo = $this->user_photo();
	  if($user_photo != "") {
	    unlink($user_photo);
	    $database->database_query("UPDATE phps_users SET user_photo='' WHERE user_id='".$this->user_info[user_id]."'");
	    $this->user_info[user_photo] = "";
	  }
	}

	/**
	 * Returns total number of friends
	 *
	 * @global PHPS_Database $database
	 * @global array $setting
	 * @param integer $direction
	 * @param integer $friend_status
	 * @param integer $user_details
	 * @param string $where
	 * @return integer
	 */
	public function user_friend_total($direction = 0, $friend_status = 1, $user_details = 0, $where = "") {
	  global $database, $setting;

	  $friend_total = 0;

	  // check the connection
	  if($setting[setting_connection_allow] != 0) {

	    // begin query
	    $friend_query = "SELECT friend_id FROM phps_friends";

	    // joing to friends table in needed
	    if($user_details == 1) { 
	      $friend_query .= " LEFT JOIN phps_users ON";
	      if($direction == 1) { $friend_query .= " phps_friends.friend_user_id1=phps_users.user_id"; } else { $friend_query .= " phps_friends.friend_user_id2=phps_users.user_id"; }
	    }

	    // continue query
	    $friend_query .= " WHERE friend_status='$friend_status'";

	    // euther "LIST OF WHO USER IS A FRIEND OF" or "LIST OF USER'S FRIENDS"
	    if($direction == 1) { $friend_query .= " AND friend_user_id2='".$this->user_info[user_id]."'"; } else { $friend_query .= " AND friend_user_id1='".$this->user_info[user_id]."'"; }

	    // add additional where clause if exists
	    if($where != "") { $friend_query .= " AND $where"; }

	    $friend_total = $database->database_num_rows($database->database_query($friend_query));

	  }

	  return $friend_total;

	} 


	/**
	 * Returns an array of user's friends
	 *
	 * @global PHPS_Database $database
	 * @global array $setting
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $direction
	 * @param integer $friend_status
	 * @param string $sort_by
	 * @param string $where
	 * @param integer $friend_details
	 * @return array
	 */
	public function user_friend_list($start, $limit, $direction = 0, $friend_status = 1, $sort_by = "phps_users.user_dateupdated DESC", $where = "", $friend_details = 0) {
	  global $database, $setting;

	  $friend_array = Array();

	  if($setting[setting_connection_allow] != 0) {

	    $friend_query = "SELECT phps_friends.friend_id, phps_users.user_id, phps_users.user_phone, phps_users.user_username, phps_users.user_photo, phps_users.user_lastlogindate, phps_users.user_dateupdated";

	    if($friend_details == 1) { $friend_query .= ", phps_friends.friend_type, phps_friendexplains.friendexplain_body"; }

	    $friend_query .= " FROM phps_friends LEFT JOIN phps_users ON";

	    if($direction == 1) { $friend_query .= " phps_friends.friend_user_id1=phps_users.user_id"; } else { $friend_query .= " phps_friends.friend_user_id2=phps_users.user_id"; }
	
	    if($friend_details == 1) { $friend_query .= " LEFT JOIN phps_friendexplains ON phps_friends.friend_id=phps_friendexplains.friendexplain_friend_id"; }

	    $friend_query .= " WHERE friend_status='$friend_status'";

	    // either "LIST OF WHO USER IS A FRIEND OF" or "LIST OF USER'S FRIENDS"
	    if($direction == 1) { $friend_query .= " AND friend_user_id2='".$this->user_info[user_id]."'"; } else { $friend_query .= " AND friend_user_id1='".$this->user_info[user_id]."'"; }

	    // add additional where clause
	    if($where != "") { $friend_query .= " AND $where"; }

	    // set sort and limit
	    $friend_query .= " ORDER BY $sort_by LIMIT $start, $limit";

	    // loop over friends
	    $friends = $database->database_query($friend_query);
	    while($friend_info = $database->database_fetch_assoc($friends)) {

	      // create an object for friend
	      $friend = new PHPS_User();
	      $friend->user_info[user_id] = $friend_info[user_id];
	      $friend->user_info[user_username] = $friend_info[user_username];
	      $friend->user_info[user_phone] = $friend_info[user_phone];
	      $friend->user_info[user_photo] = $friend_info[user_photo];
	      $friend->user_info[user_lastlogindate] = $friend_info[user_lastlogindate];
	      $friend->user_info[user_dateupdated] = $friend_info[user_dateupdated];

	      // set type and explanation
	      if($friend_details == 1) {
	        $friend->friend_type = $friend_info[friend_type];
	        $friend->friend_explain = $friend_info[friendexplain_body];
	      }

	      // set arrays of frinds
	      $friend_array[] = $friend;
	    }
	  }

	  // return friends array
	  return $friend_array;

	} 


	/**
	 * Create a user friend of current user
	 *
	 * @global PHPS_Database $database
	 * @param integer $other_user_id
	 * @param integer $friend_status
	 * @param integer $friend_type
	 * @param string $friend_explain
	 */
	public function user_friend_add($other_user_id, $friend_status, $friend_type, $friend_explain) {
	  global $database;

	  // add to frinds
	  $database->database_query("INSERT INTO phps_friends (friend_user_id1, friend_user_id2, friend_status, friend_type) VALUES ('".$this->user_info[user_id]."', '$other_user_id', '$friend_status', '$friend_type')");
	  $friend_id = $database->database_insert_id();
	  $database->database_query("INSERT INTO phps_friendexplains (friendexplain_friend_id, friendexplain_body) VALUES ('$friend_id', '$friend_explain')");

	  // remove from blocklist
	  if($this->user_blocked($other_user_id)) {
	    $blocklist = explode(",", $this->user_info[user_blocklist]);
	    $user_key = array_search($other_user_id, $blocklist);
            $blocklist[$user_key] = "";
	    $this->user_info[user_blocklist] = implode(",", $blocklist);
	    $database->database_query("UPDATE phps_users SET user_blocklist='".$this->user_info[user_blocklist]."' WHERE user_id='".$this->user_info[user_id]."'");
	  }

	}


	/**
	 * Remove user as a friend of current user
	 *
	 * @global PHPS_Database $database
	 * @global array $setting
	 * @param integer $other_user_id
	 */
	public function user_friend_remove($other_user_id) {
	  global $database, $setting;

          // remove frome friends if friend
          $friend1 = $database->database_query("SELECT friend_id FROM phps_friends WHERE friend_user_id1='".$this->user_info[user_id]."' AND friend_user_id2='$other_user_id'");
          if($database->database_num_rows($friend1) == 1) {
            $friendship = $database->database_fetch_assoc($friend1);
            $database->database_query("DELETE FROM phps_friends WHERE friend_id='$friendship[friend_id]'");
            $database->database_query("DELETE FROM phps_friendexplains WHERE friendexplain_friend_id='$friendship[friend_id]'");
          }

          // remove additional raw if two-derectionals
          $friend2 = $database->database_query("SELECT friend_id FROM phps_friends WHERE friend_user_id2='".$this->user_info[user_id]."' AND friend_user_id1='$other_user_id'");
          if($database->database_num_rows($friend2) == 1 & ($setting[setting_connection_framework] == 0 | $setting[setting_connection_framework] == 2)) {
            $friendship = $database->database_fetch_assoc($friend2);
            $database->database_query("DELETE FROM phps_friends WHERE friend_id='$friendship[friend_id]'");
            $database->database_query("DELETE FROM phps_friendexplains WHERE friendexplain_friend_id='$friendship[friend_id]'");    
          }

	}


	/**
	 * Returns true if the specified user is a friend of existing user
	 *
	 * @global PHPS_Database $database
	 * @param integer $other_user_id
	 * @return boolean
	 */
	public function user_friend_of_friend($other_user_id) {
	  global $database;

	  if($database->database_num_rows($database->database_query("SELECT t2.friend_user_id2 FROM phps_friends AS t1 LEFT JOIN phps_friends AS t2 ON t1.friend_user_id2=t2.friend_user_id1 WHERE t1.friend_user_id1='".$this->user_info[user_id]."' AND t2.friend_user_id2='$other_user_id' AND t1.friend_status<>'0' AND t2.friend_status<>'0'")) != 0) {
	    return true;
	  } else {
	    return false;
	  }
	} 

	/**
	 * Returns true is the specified user has been frinded by the existing user
	 *
	 * @global PHPS_Database $database
	 * @param integer $other_user_id
	 * @param integer $friend_status
	 * @return boolean
	 */
	public function user_friended($other_user_id, $friend_status = 1) {
	  global $database;

	  if($database->database_num_rows($database->database_query("SELECT friend_id FROM phps_friends WHERE friend_user_id1='".$this->user_info[user_id]."' AND friend_user_id2='$other_user_id' AND friend_status='$friend_status'")) == 1) {
	    return true;
	  } else {
	    return false;
	  }
	}

	/**
	 * Returns true if specified user has been blocked by current user
	 *
	 * @param integer $other_user_id
	 * @return boolean
	 */
	public function user_blocked($other_user_id) {
	  $blocklist = explode(",", $this->user_info[user_blocklist]);
	  if(in_array($other_user_id, $blocklist) == TRUE & $this->level_info[level_profile_block] != 0) {
	    return true;
	  } else {
	    return false;
	  }
	} 

	/**
	 * This method returns maximum privacy level viewable by a user with regard to the current user
	 *
	 * @global PHPS_Database $database
	 * @param integer $other_user
	 * @param string $allowable_privacy
	 * @return boolean
	 */
	public function user_privacy_max($other_user, $allowable_privacy = "012345") {
	  global $database;
	
	  switch(TRUE) {
	
	    // nobody
	    // no one has $privacy_level = 6

	    // owner
	    case($this->user_info[user_id] == $other_user->user_info[user_id]):
	      $privacy_level = 5;
	      break;

	    // friend
	    case($this->user_friended($other_user->user_info[user_id])):
	      $privacy_level = 4;
	      break;
  
	    // frind of a frind with sme subnetwork
	    case($this->user_info[user_subnet_id] == $other_user->user_info[user_subnet_id] AND $this->user_friend_of_friend($other_user->user_info[user_id]) == TRUE):
	      $privacy_level = 3;
	      break;

	    // same subnetwork
	    case($this->user_info[user_subnet_id] == $other_user->user_info[user_subnet_id]):
	      $privacy_level = 2;
	      break;

	    // registered user
	    case($other_user->user_exists != 0):
	      $privacy_level = 1;
	      break;

	    //everyone (default)
	    default:
	      $privacy_level = 0;
	      break;
	
	  }

	  // make sure that privacy level allowed by admin
	  $allowable_privacy = str_split($allowable_privacy);
	  rsort($allowable_privacy);
	  if($privacy_level >= $allowable_privacy[0]) {
	    $privacy_level = 6;
	  }

	  // retunr privacy level
	  return $privacy_level;

	} 


	/**
	 * Return total number of messages
	 *
	 * @global PHPS_Database $database
	 * @param integer $direction
	 * @param integer $unread_only
	 * @return boolean
	 */
	public function user_message_total($direction = 0, $unread_only = 0) {
	  global $database;

	  $message_total = 0;

	  // make sure messages are allowed
	  if($this->level_info[level_message_allow] != 0) {

	    // message query
	    $message_query = "SELECT pm_id FROM phps_pms WHERE";

	    // check direction
	    if($direction == 1) { $message_query .= " pm_authoruser_id='".$this->user_info[user_id]."' AND pm_outbox<>'0'"; } else { $message_query .= " pm_user_id='".$this->user_info[user_id]."' AND pm_status<>'2'"; }

	    // check message status
	    if($unread_only == 1) { $message_query .= " AND pm_status='0'"; }

	    // run query
	    $message_total = $database->database_num_rows($database->database_query($message_query));

	  }

	  return $message_total;

	} 

	/**
	 * Gets user's messages
	 *
	 * @global PHPS_Database $database
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $direction
	 * @return array
	 */
	public function user_message_list($start, $limit, $direction = 0) {
	  global $database;

	  $message_array = array();

	  // make sure messages are allowed
	  if($this->level_info[level_message_allow] != 0) {

	    // message query
	    $message_query = "SELECT phps_pms.*, phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_pms LEFT JOIN phps_users ON";

	    if($direction == 1) { $message_query .= " phps_pms.pm_user_id=phps_users.user_id WHERE pm_authoruser_id='".$this->user_info[user_id]."' AND pm_outbox<>'0'"; } else { $message_query .= " phps_pms.pm_authoruser_id=phps_users.user_id WHERE pm_user_id='".$this->user_info[user_id]."' AND pm_status<>'2'"; }

	    $message_query .= " ORDER BY pm_date DESC LIMIT $start, $limit";

	    // loop over messages
	    $messages = $database->database_query($message_query);
	    while($message_info = $database->database_fetch_assoc($messages)) {

	      // create object for the messages author / reciver
	      $pm_user = new PHPS_User();
	      $pm_user->user_info[user_id] = $message_info[user_id];
	      $pm_user->user_info[user_username] = $message_info[user_username];
	      $pm_user->user_info[user_photo] = $message_info[user_photo];

	      //remove <br>s from list
	      $pm_body = str_replace("<br>", "", $message_info[pm_body]);

	      // set message array
	      $message_array[] = Array('pm_id' => $message_info[pm_id],
				'pm_subject' => $message_info[pm_subject],
				'pm_date' => $message_info[pm_date],
				'pm_status' => $message_info[pm_status],
				'pm_outbox' => $message_info[pm_outbox],
				'pm_body' => $pm_body,
				'pm_user' => $pm_user);
	    }
	  }

	  return $message_array;

	}

	/**
	 * Send message
	 *
	 * @global PHPS_Database $database
	 * @global array $Application
	 * @param <type> $to
	 * @param string $subject
	 * @param string $message
	 * @param integer $convo_id
	 */
	public function user_message_send($to, $subject, $message, $convo_id = 0) {
	  global $database, $Application;

	  // validate conversation id
	  if($convo_id == "" OR !is_numeric($convo_id)) { $convo_id = 0; }

	  // get to user
	  $to_user = new PHPS_User(array(0, $to));

	  // if message empty?
	  if(str_replace(" ", "", $message) == "") { $this->is_error = 1; $this->error_message = $Application[54]; }

	  // to user doesn't exists
	  if($to_user->user_exists == 0) { $this->is_error = 1; $this->error_message = $Application[55]; }

	  // to user is the same as logged one
	  if($to_user->user_info[user_username] == $this->user_info[user_username]) { $this->is_error = 1; $this->error_message = $Application[56]; }

	  // to user has current user in his blocklist
	  if($to_user->user_blocked($this->user_info[user_id])) { $is_error = 1; $error_message = $Application[57]; }

	  // to user is not a friend and TO FRIENDS ONLY option is turned on by admin
	  if($this->level_info[level_message_allow] == 1 & $this->user_friended($to_user->user_info[user_id]) == FALSE) { $this->is_error = 1; $this->error_message = $Application[58]; }

	  // sending a message if no errror
	  if($this->is_error == 0) {

	    // replace newlines with brakes
	    $message = str_replace("\n", "<br>", $message);

	    // insert message
	    $pm_date = time();
	    $database->database_query("INSERT INTO phps_pms (pm_user_id, pm_authoruser_id, pm_convo_id, pm_date, pm_subject, pm_body, pm_status, pm_outbox) VALUES ('".$to_user->user_info[user_id]."', '".$this->user_info[user_id]."', '$convo_id', '$pm_date', '$subject', '$message', '0', '1')");

	    // send notification
	    send_message($to_user, $this->user_info[user_username]);

	    // if outbox is full - delete an oldest ones
	    $num_outbox = $this->user_message_total(1, 0);
	    if($num_outbox > $this->level_info[level_message_outbox]) {
	      $num_delete = $num_outbox-($this->level_info[level_message_outbox]);
	      $database->database_query("UPDATE phps_pms SET pm_outbox='0' WHERE pm_authoruser_id='".$this->user_info[user_id]."' AND pm_outbox<>'0' ORDER BY pm_id ASC LIMIT $num_delete");
	    }      

	    // if inbox is full - delete oldest ones
	    $total_pms = $to_user->user_message_total(0, 0);
	    if($num_inbox > $to_user->level_info[level_message_inbox]) {
	      $num_delete = $num_inbox-($to_user->level_info[level_message_inbox]);
	      $database->database_query("UPDATE phps_pms SET pm_status='2' WHERE pm_user_id='".$to_user->user_info[user_id]."' AND pm_status<>'2' ORDER BY pm_date ASC LIMIT $num_delete");
	    }

	    // clear pms
	    $database->database_query("DELETE FROM phps_pms WHERE pm_status='2' AND pm_outbox='0'");
	  }

	}

	/**
	 * Deletes many messages
	 *
	 * @global PHPS_Database $database
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $direction
	 */
	public function user_message_delete_selected($start, $limit, $direction = 0) {
	  global $database;

	  $message_array = Array();

	  // make sure that messages are allowed
	  if($this->level_info[level_message_allow] != 0) {

	    // messages wuery
	    $message_query = "SELECT pm_id FROM phps_pms";

	    if($direction == 1) { $message_query .= " WHERE pm_authoruser_id='".$this->user_info[user_id]."' AND pm_outbox<>'0'"; } else { $message_query .= " WHERE pm_user_id='".$this->user_info[user_id]."' AND pm_status<>'2'"; }

	    // continue message query
	    $message_query .= " ORDER BY pm_date DESC LIMIT $start, $limit";

	    // loop over messages
	    $delete_query = "";
	    $messages = $database->database_query($message_query);
	    while($message_info = $database->database_fetch_assoc($messages)) {
	      $var = "message_".$message_info[pm_id];

	      // add to delete query
	      if($_POST[$var] == 1) {
	        if($delete_query != "") { $delete_query .= " OR "; }
	        $delete_query .= "pm_id='$message_info[pm_id]'";
	      }
	    }

	    // preform updates and deletions
	    if($delete_query != "") {
	      if($direction == 1) { $setwhere_clause = "pm_outbox='0' WHERE pm_authoruser_id='".$this->user_info[user_id]."'"; } else { $setwhere_clause = "pm_status='2' WHERE pm_user_id='".$this->user_info[user_id]."'"; }
	      $database->database_query("UPDATE phps_pms SET $setwhere_clause AND ($delete_query)");
	      $database->database_query("DELETE FROM phps_pms WHERE pm_status='2' AND pm_outbox='0'");
	    }
	
	  }

	}

	/**
	 * Create user account using given information
	 *
	 * @global PHPS_database $database
	 * @global array $setting
	 * @global string $url
	 * @param string $signup_email
	 * @param string $signup_username
	 * @param string $signup_password
	 * @param string $signup_timezone
	 * @param string $signup_language
	 */
	public function user_create($signup_email, $signup_username, $signup_password, $signup_timezone, $signup_language, $signup_phone = '') {
	  global $database, $setting, $url;

	  // preset vars
	  $signup_subnet_id = 0;
	  $signup_level_info = $database->database_fetch_assoc($database->database_query("SELECT level_id, level_profile_privacy, level_profile_comments FROM phps_levels WHERE level_default='1' LIMIT 1"));
	  $signup_code = randomcode();
	  $signup_date = time();
	  $signup_dateupdated = $signup_date;
	  $signup_invitesleft = $setting[setting_signup_invite_numgiven];
	  $signup_notify_friendrequest = 1;
	  $signup_notify_message = 1;
	  $signup_notify_profilecomment = 1;
	  $signup_privacy_search = 1;

	  // set wether user enabled or not
	  if($setting[setting_signup_enable] == 0) { $signup_enabled = 0; } else { $signup_enabled = 1; }

	  // set email verification
	  if($setting[setting_signup_verify] == 0) { $signup_verified = 1; } else { $signup_verified = 0; }

	  // create random password in needed
	  if($setting[setting_signup_randpass] != 0) { $signup_password = randomcode(10); }

	  // encode password wiht md5
	  $user_salt = "$1$".substr($signup_code, 0, 8)."$";
	  $crypt_password = crypt($signup_password, $user_salt);

	  // set privacy default
	  $allowable_privacy = str_split($signup_level_info[level_profile_privacy]);
	  sort($allowable_privacy);
	  $profile_privacy = $allowable_privacy[0];

	  // set comment default
	  $allowable_comments = str_split($signup_level_info[level_profile_comments]);
	  sort($allowable_comments);
	  $profile_comments = $allowable_comments[0];

	  // get subnet id
	  $signup_subnet = $this->user_subnet_select($signup_email, $this->profile_fields_new); 
	  $signup_subnet_id = $signup_subnet[0];

	  // add user to user table
	  $database->database_query("INSERT INTO phps_users (user_level_id,
						user_subnet_id,
						user_email,
						user_phone,
						user_newemail,
						user_username,
						user_password,
						user_code,
						user_enabled,
						user_verified,
						user_signupdate,
						user_invitesleft,
						user_timezone,
						user_lang,
						user_dateupdated,
						user_privacy_search,
						user_privacy_profile,
						user_privacy_comments
						) VALUES (
						'$signup_level_info[level_id]',
						'$signup_subnet_id',
						'$signup_email',
						'$signup_phone',
						'$signup_email',
						'$signup_username',
						'$crypt_password',
						'$signup_code',
						'$signup_enabled',
						'$signup_verified',
						'$signup_date',
						'$signup_invitesleft',
						'$signup_timezone',
						'$signup_language',
						'$signup_dateupdated',
						'$signup_privacy_search',
						'$profile_privacy',
						'$profile_comments')");

	  //get user info
	  $user_id = $database->database_insert_id();
	  $this->user_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_users WHERE user_id='$user_id'"));
	  $this->level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_levels WHERE level_id='".$this->user_info[user_level_id]."'"));
	  $this->subnet_info = $database->database_fetch_assoc($database->database_query("SELECT subnet_id, subnet_name FROM phps_subnets WHERE subnet_id='".$this->user_info[user_subnet_id]."'"));

	  // add user profile
	  $database->database_query("INSERT INTO phps_profiles (profile_user_id) VALUES ('".$this->user_info[user_id]."')");
	  if(count($this->profile_tabs) != 0) {
	    $profile_query = "UPDATE phps_profiles SET ".$this->profile_field_query." WHERE profile_user_id='".$this->user_info[user_id]."'";
	    $database->database_query($profile_query);
	  }

	  // get profile info
	  $this->profile_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_profiles WHERE profile_user_id='".$this->user_info[user_id]."'"));

	  // add row in styles table
	  $database->database_query("INSERT INTO phps_profilestyles (profilestyle_user_id, profilestyle_css) VALUES ('".$this->user_info[user_id]."', '')");

	  // add row in settings table
	  $database->database_query("INSERT INTO phps_usersettings (usersetting_user_id, usersetting_notify_friendrequest, usersetting_notify_message, usersetting_notify_profilecomment) VALUES ('".$this->user_info[user_id]."', '$signup_notify_friendrequest', '$signup_notify_message', '$signup_notify_profilecomment')");

	  // add user directory
	  $user_directory = $url->url_userTdir($this->user_info[user_id]);
	  $user_path_array = explode("/", $user_directory);
	  array_pop($user_path_array);
	  array_pop($user_path_array);
	  $subdir = implode("/", $user_path_array)."/";
	  if(!is_dir($subdir)) { 
	    mkdir($subdir, 0777); 
	    chmod($subdir, 0777); 
	    $handle = fopen($subdir."index.php", 'x+');
	    fclose($handle);
	  }
	  mkdir($user_directory, 0777);
	  chmod($user_directory, 0777);
	  $handle = fopen($user_directory."/index.php", 'x+');
	  fclose($handle);

	  // send random password if needed
	  if($setting[setting_signup_randpass] != 0) { send_newpass($this->user_info, $signup_password); }

	  // send verification email if required
	  if($setting[setting_signup_verify] != 0) { send_verification($this->user_info); }

	  // set wellcome email if required
	  if($setting[setting_signup_welcome] != 0 & $setting[setting_signup_verify] == 0) { send_welcome($this->user_info, $signup_password); }

	}

	/**
	 * Set user status
	 *
	 * @global PHPS_Database $database
	 * @param  string $status
	 */
	public function user_status($status) {
	  global $database;

	  $database->database_query("UPDATE `phps_users` SET `user_status` = '".$status."' WHERE `user_id`=".$this->user_info['user_id']);
	  return true;
    }

	/**
	 * Delete user
	 *
	 * @global PHPS_Database $database
	 * @global string $url
	 * @global array $global_plugins
	 */
	public function user_delete() {
	  global $database, $url, $global_plugins;

	  // delete related plugins objects
	  for($g=0;$g<count($global_plugins);$g++) {
	    if(function_exists('deleteuser_'.$global_plugins[$g])) {
	      call_user_func_array('deleteuser_'.$global_plugins[$g], array($this->user_info[user_id])); 
	    }
	  }

	  // delete user table row
	  $database->database_query("DELETE FROM phps_users WHERE user_id='".$this->user_info[user_id]."' LIMIT 1");
	  // delete user profile
	  $database->database_query("DELETE FROM phps_profiles WHERE profile_user_id='".$this->user_info[user_id]."'");
	  // delete user styles
	  $database->database_query("DELETE FROM phps_profilestyles WHERE profilestyle_user_id='".$this->user_info[user_id]."'");
	  // delete owned and posted comments
	  $database->database_query("DELETE FROM phps_profilecomments WHERE profilecomment_user_id='".$this->user_info[user_id]."' OR profilecomment_authoruser_id='".$this->user_info[user_id]."'");
	  // delete owned and posted pms
	  $database->database_query("DELETE FROM phps_pms WHERE pm_user_id='".$this->user_info[user_id]."' OR pm_authoruser_id='".$this->user_info[user_id]."'");
	  // delete connection to and from users
	  $database->database_query("DELETE FROM phps_friends, phps_friendexplains USING phps_friends LEFT JOIN phps_friendexplains ON phps_friends.friend_id=phps_friendexplains.friendexplain_friend_id WHERE phps_friends.friend_user_id1='".$this->user_info[user_id]."' OR phps_friends.friend_user_id2='".$this->user_info[user_id]."'");
	  // delete all user's reports
	  $database->database_query("DELETE FROM phps_reports WHERE report_user_id='".$this->user_info[user_id]."'");
	  // delete user's actions
	  $database->database_query("DELETE FROM phps_actions WHERE action_user_id='".$this->user_info[user_id]."'");


	  // delete user's files
	  if(is_dir($url->url_userTdir($this->user_info[user_id]))) {
	    $dir = $url->url_userTdir($this->user_info[user_id]);
	  } else {
	    $dir = ".".$url->url_userTdir($this->user_info[user_id]);
	  }
	  if($dh = opendir($dir)) {
	    while(($file = readdir($dh)) !== false) {
	      if($file != "." & $file != "..") {
	        unlink($dir.$file);
	      }
	    }
	    closedir($dh);
	  }
	  rmdir($dir);

	  $this->user_clear();

	} 
}
