<?php
/**
 * Admin class.
 *
 */



class PHPS_Admin {

	/**
	 * Error flag
	 *
	 * @var boolean
	 */
	public $is_error;

	/**
	 * Erro message
	 *
	 * @var string
	 */
	public $error_message;

	/**
	 * Editing existing admin or not
	 *
	 * @var boolean
	 */
	public $admin_exists;

	/**
	 * Contain the salt used to encrypt the admin password
	 * 
	 * @var string
	 */
	public $admin_salt;

	/**
	 * Admin's data
	 * 
	 * @var array
	 */
	public $admin_info;

	/**
	 * Superadmin flag
	 * 
	 * @var boolean
	 */
	public $admin_super;

	/**
	 * Set initial vars. such as admin info
	 *
	 * @global PHPS_Database $database
	 * @param integer $admin_id
	 * @param string $admin_username
	 */
	public function  PHPS_Admin($admin_id = 0, $admin_username = "") {
	  global $database;

	  $this->is_error = 0;
	  $this->error_message = "";
	  $this->admin_exists = 0;
	  $this->admin_salt = "$4admin"."admin$4"."4$4";
	  $this->admin_super = 0;
	
	  if($admin_id != 0 | $admin_username != "") {
	    $admin = $database->database_query("SELECT * FROM phps_admins WHERE admin_id='$admin_id' OR admin_username='$admin_username'");
	    if($database->database_num_rows($admin) == 1) {
	      $this->admin_exists = 1;
	      $this->admin_info = $database->database_fetch_assoc($admin);
	      $super = $database->database_fetch_assoc($database->database_query("SELECT admin_id FROM phps_admins ORDER BY admin_id LIMIT 1"));
	      if($super[admin_id] == $this->admin_info[admin_id]) { $this->admin_super = 1; }
	    }
	  }

	}

	/**
	 * Create an admin account using given information
	 * 
	 * @global PHPS_Database $database
	 * @param string $admin_username
	 * @param string $admin_password
	 * @param string $admin_name
	 * @param string $admin_email
	 */
	function admin_create($admin_username, $admin_password, $admin_name, $admin_email) {
	  global $database;

	  $admin_password_encrypted = crypt($admin_password, $this->admin_salt);
	  $database->database_query("INSERT INTO phps_admins (admin_username, admin_password, admin_name, admin_email) VALUES ('$admin_username', '$admin_password_encrypted', '$admin_name', '$admin_email')");
	
	}

	/**
	 * Verify login cookies
	 * 
	 */
	function admin_checkCookies() {

	  if(isset($_COOKIE['admin_id']) & isset($_COOKIE['admin_username']) & isset($_COOKIE['admin_password'])) {
	    // get admin row
	    $admin_id = $_COOKIE['admin_id'];
	    $this->PHPS_Admin($admin_id);

	    // verify login cookie
	    if($this->admin_exists == 0 | ($_COOKIE['admin_username'] != crypt($this->admin_info[admin_username], $this->admin_salt) | $_COOKIE['admin_password'] != $this->admin_info[admin_password])) {
	      $this->PHPS_Admin();
	    }
	  }

	}

	/**
	 * Admin login
	 *
	 * @global array $class_admin
	 */
	function admin_login() {
	  global $class_admin;

	  $this->PHPS_Admin(0, $_POST['username']);

	  // show erro if js is disabled
	  if(isset($_POST['javascript']) & $_POST['javascript'] == "no") {
	    $this->is_error = 1;
	    $this->error_message = $Admin[34];
	  } elseif($this->admin_exists == 0) {
	    $this->is_error = 1;
	    $this->error_message = $Admin[35];
	  } elseif(crypt($_POST['password'], $this->admin_salt) != $this->admin_info[admin_password]) {
	    $this->is_error = 1;
	    $this->error_message = $Admin[35];
	  } else {
	    setcookie("admin_id", $this->admin_info[admin_id], 0, "/");
	    setcookie("admin_username", crypt($this->admin_info[admin_username], $this->admin_salt), 0, "/");
	    setcookie("admin_password", $this->admin_info[admin_password], 0, "/");
	  }

	}

	/**
	 * Loops and/or validate admin's input
	 *
	 * @global PHPS_Database $database
	 * @global array $class_admin
	 * @param string $admin_username
	 * @param string $admin_password_old
	 * @param string $admin_password
	 * @param string $admin_password_confirm
	 * @param string $admin_name
	 * @param string $admin_email
	 */
	function admin_account($admin_username, $admin_password_old, $admin_password, $admin_password_confirm, $admin_name, $admin_email) {
	  global $database, $class_admin;

	  // check empty
	  if(str_replace(" ", "", $admin_username) == "" | str_replace(" ", "", $admin_name) == "" | str_replace(" ", "", $admin_email) == "") { $this->is_error = 1; $this->error_message = $Admin[36]; }

	  // check empty password
	  if(($this->admin_info[admin_password] == "" & str_replace(" ", "", $admin_password) == "") | ($this->admin_info[admin_password] != "" & (str_replace(" ", "", $admin_password_old) == "" | str_replace(" ", "", $admin_password) == "" | str_replace(" ", "", $admin_password_confirm) == "") & (str_replace(" ", "", $admin_password_old) != "" | str_replace(" ", "", $admin_password) != "" | str_replace(" ", "", $admin_password_confirm) != ""))) { $this->is_error = 1; $this->error_message = $Admin[36]; }

	  // check old password
	  if(str_replace(" ", "", $admin_password_old) != "" & crypt($admin_password_old, $this->admin_salt) != $this->admin_info[admin_password]) { $this->is_error = 1; $this->error_message = $Admin[37]; }
  
	  // check invalid user name and password
	  if(preg_match("/[^a-zA-Z0-9]/", $admin_username) | preg_match("/[^a-zA-Z0-9]/", $admin_password)) { $this->is_error = 1; $this->error_message = $Admin[38]; }

	  // check for duplicated username
	  $lowercase_username = strtolower($admin_username);
	  if(strtolower($this->admin_info[admin_username]) != $lowercase_username & $database->database_num_rows($database->database_query("SELECT admin_id FROM phps_admins WHERE LOWER(admin_username)='$lowercase_username'")) != 0) { $this->is_error = 1; $this->error_message = $Admin[39]; }

	  // check for password lenth
	  if(str_replace(" ", "", $admin_password) != "" & strlen($admin_password) < 6) { $this->is_error = 1; $this->error_message = $Admin[40]; }
	
	  // check for password mutch
	  if(str_replace(" ", "", $admin_password) != "" & $admin_password != $admin_password_confirm) { $this->is_error = 1; $this->error_message = $Admin[41]; }

	} 

	/**
	 * Edit admin account
	 *
	 * @global PHPS_Database $database
	 * @global PHPS_Admin $admin
	 * @param string $admin_username
	 * @param string $admin_password
	 * @param string $admin_name
	 * @param string $admin_email
	 */
	function admin_edit($admin_username, $admin_password, $admin_name, $admin_email) {
	  global $database;

	  if(str_replace(" ", "", $admin_password) != "") {
	    $admin_password_encrypted = crypt($admin_password, $this->admin_salt);
	  } else {
	    $admin_password_encrypted = $this->admin_info[admin_password];
	  }
	
	  $database->database_query("UPDATE phps_admins SET admin_username='$admin_username', admin_password='$admin_password_encrypted', admin_name='$admin_name', admin_email='$admin_email' WHERE admin_id='".$this->admin_info[admin_id]."'");

	  // reset cookie if current admin is logged in
	  global $admin;
	  if($admin->admin_info[admin_id] == $this->admin_info[admin_id]) {
	    setcookie("admin_password", "$admin_password_encrypted", 0, "/");
	  }
	
	}

	/**
	 * Clear object eproperties
	 * 
	 */
	function admin_clear() {
		foreach ($this as $classProp => $propVal) {
			$propVal = is_integer($propVal) ? 0 : '';
			$this->$classProp = $propVal;
		}
	}

	/**
	 * Admin logout
	 *
	 */
	function admin_logout() {
	  setcookie("admin_id", "", 0, "/");
	  setcookie("admin_username", "", 0, "/");
	  setcookie("admin_password", "", 0, "/");
	  $this->admin_clear();
	} 

	/**
	 * delete admin
	 *
	 * @global PHPS_Database $database
	 */
	function admin_delete() {
	  global $database;
	  $database->database_query("DELETE FROM phps_admins WHERE admin_id='".$this->admin_info[admin_id]."'");
	  $this->admin_clear();

	}

}
