<?php
$page = "Signup";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { if(isset($_GET['task'])){$task = $_GET['task']; } else{ $task = "step1";}}

// init error variables
$is_error = 0;
$error_message = "";

// if user is already logged in, then redirec to the profile page
if($user->user_exists != 0) {
	header("Location: Profile.php?user=". $user->user_info['user_username']);
	exit();
}

// check if user signed up set cookies (STEPS 3, 4, 5)
$signup_logged_in = 0;

if($task != "step1" && $task != "step1do") {
	if(isset($_COOKIE['signup_id']) && isset($_COOKIE['signup_email']) && isset($_COOKIE['signup_password'])) {

		// get user row if available
		$user_id = $_COOKIE['signup_id'];
		$new_user = new PHPS_User(array($user_id));
		
		// verify user login cookie values and reset login var
		if($_COOKIE['signup_email'] == crypt($new_user->user_info[user_email], "$1$".$new_user->user_info[user_code]."$") && $_COOKIE['signup_password'] == $new_user->user_info[user_password]) {
			$signup_logged_in = 1;
		}
	}
	if($signup_logged_in != 1) {
		cheader("Signup.php");
		exit();
	}
}

if($signup_logged_in != 1) {
	setcookie('signup_id', '', 0, '/');
	setcookie('signup_email', '', 0, '/');
	setcookie('signup_password', '', 0, '/');
	$_COOKIE['signup_id'] = '';
	$_COOKIE['signup_email'] = '';
	$_COOKIE['signup_password'] = '';
	$new_user = new PHPS_User();
	if($task == "step1") {
		$signup_email = isset($_GET['signup_email']) ? $_GET['signup_email'] : '';
		$signup_invite = isset($_GET['signup_invite']) ? $_GET['signup_invite'] : '';
		$signup_password = "";
	}
}

if($task == 'step1' || $task == 'step1do') {
	$validate = ($task == 'step1do') ? 1 : 0;
	$new_user->user_fields(0, 0, $validate, 1);
	if($validate == 1) {
		$is_error = $new_user->is_error; $error_message = $new_user->error_message;
	}
}


if($task == "step1do") {
	$signup_email = $_POST['signup_email'];
	$signup_password = $_POST['signup_password'];
	$signup_password2 = $_POST['signup_password2'];
	$signup_username = $_POST['signup_username'];
	$signup_timezone = $_POST['signup_timezone'];
	$signup_invite = $_POST['signup_invite'];
	$signup_phone = $_POST['signup_phone'];

	// get language pack selection
	if($setting[setting_lang_allow] != 1) {
		$signup_lang = $setting[setting_lang_default];
	}
	else {
		$signup_lang = strtolower($_POST['signup_lang']);
		if(!file_exists("./lang/lang".$signup_lang.".php")) {
			$signup_lang = $setting[setting_lang_default];
		}
	}
	// temporarily set password if random password enabled
	if($setting[setting_signup_randpass] != 0) {
		$signup_password = "temporary";
		$signup_password2 = "temporary";
	}

	// check user errors
	$new_user->user_account($signup_email, $signup_username);
	$new_user->user_password('', $signup_password, $signup_password2, 0);
	$is_error = $new_user->is_error;
	$error_message = $new_user->error_message; 

	// check invite code if necessary
	if($setting[setting_signup_invite] != 0) {
		if($setting[setting_signup_invite_checkemail] != 0) {
			$invite = $database->database_query("SELECT invite_id FROM phps_invites WHERE invite_code='$signup_invite' AND invite_email='$signup_email'");
			$invite_error_message = $Application[324];
		}
		else {
			$invite = $database->database_query("SELECT invite_id FROM phps_invites WHERE invite_code='$signup_invite'");
			$invite_error_message = $Application[325];
		}
		if($database->database_num_rows($invite) == 0) {
			$is_error = 1;
			$error_message = $invite_error_message;
		}
	}

	// check terms of service agreement if necessary
	if($setting[setting_signup_tos] != 0) {
		$signup_agree = $_POST['signup_agree'];
		if($signup_agree != 1) {
			$is_error = 1;
			$error_message = $Application[320];
		}
	}

	// retrieve and check security code if necessary
	if($setting[setting_signup_code] != 0) {
		session_start();
		$code = $_SESSION['code'];
		if($code == '') {
			$code = randomcode();
		}
		$signup_secure = $_POST['signup_secure'];
		if($signup_secure != $code) {
			$is_error = 1;
			$error_message = $Application[321];
		}
	}

	if($is_error == 0) {
		$new_user->user_create($signup_email, $signup_username, $signup_password, $signup_timezone, $signup_lang, $signup_phone);

		// insert action
		$actions->add($new_user, "signup", array('[username]'), array($new_user->user_info[user_username]));

		// invite code features
		if($setting[setting_signup_invite] != 0) {
			if($setting[setting_signup_invite_checkemail] != 0) {
				$invitation = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_invites WHERE invite_code='$signup_invite' AND invite_email='$signup_email' LIMIT 1"));
			}
			else {
				$invitation = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_invites WHERE invite_code='$signup_invite' LIMIT 1"));
			}

			// add user to inviter's friendlist
			$friend = new PHPS_User(array($invitation[invite_user_id]));
			if($friend->user_exists == 1) {
				if($setting[setting_connection_allow] == 3 || $setting[setting_connection_allow] == 1 || ($setting[setting_connection_allow] == 2 && $new_user->user_info[user_subnet_id] == $friend->user_info[user_subnet_id])) {
					// set result, direction, status
					switch($setting[setting_connection_framework]) {
						case "0":
							$direction = 2;
							$friend_status = 0;
						break;
						case "1":
							$direction = 1;
							$friend_status = 0;
						break;
						case "2":
							$direction = 2;
							$friend_status = 1;
						break;
						case "3":
							$direction = 1;
							$friend_status = 1;
						break;
					}

					// insert friends into friend table and explanation into explain table
					$friend->user_friend_add($new_user->user_info[user_id], $friend_status, '', '');

					// if two-way connection and non-confirmed, insert other direction
					if($direction == 2 & $friend_status == 1) {
						$new_user->user_friend_add($friend->user_info[user_id], $friend_status, '', '');
					}
				}
			}
		    // delete invite code
			$database->database_query("DELETE FROM phps_invites WHERE invite_id='$invitation[invite_id]' LIMIT 1");
		}

		// set signup cookie
		$id = $new_user->user_info[user_id];
		$em = crypt($new_user->user_info[user_email], "$1$".$new_user->user_info[user_code]."$");
		$pass = $new_user->user_info[user_password];
		setcookie("signup_id", "$id", 0, "/");
		setcookie("signup_email", "$em", 0, "/");
		setcookie("signup_password", "$pass", 0, "/");

		// send user to photo upload if specified by admin
		// or to user invite if no photo upload
		if($setting[setting_signup_photo] == 0) {
			if($setting[setting_signup_invitepage] == 0) {
				$task = "step4";
			}
			else {
				$task = "step3";
			}
		}
		else {
			$task = "step2";
		}
	}
	else {
		$task = "step1";
	}
}


// upload photo
if($task == "step2do") {
  $new_user->user_photo_upload("photo");
  $is_error = $new_user->is_error;
  $error_message = $new_user->error_message;
  $task = "step3";
}


// send invite emails
if($task == "step3do") {

  $invite_emails = $_POST['invite_emails'];
  $invite_message = $_POST['invite_message'];

  if($invite_emails != "") {
    send_invitation($new_user->user_info, $invite_emails, $invite_message);
  }

  // send user to thank you page
  $task = "step4";

}



// show completion page
if($task == "step4") {
  // unset signup cookies
  setcookie("signup_id", "", 0, "/");
  setcookie("signup_email", "", 0, "/");
  setcookie("signup_password", "", 0, "/");

  // update signup stats
  update_stats("signups");

  // display thank you
  $step = 4;
}




// SHOW FOURTH STEP
if($task == "step3") {
  $step = 3;
  $next_task = "step3do";
  if($setting[setting_signup_invitepage] == 0) { $task = "step2"; }
}





// show third step
if($task == "step2") {
  $step = 2;
  $next_task = "step2do";
  if($setting[setting_signup_invitepage] == 0) { $last_task = "step4"; } else { $last_task = "step3"; }
  if($setting[setting_signup_photo] == 0) { $task = "step1"; }
}



// show first step
if($task == "step1") {
	$step = 1;
	$next_task = "step1do";
	if(count($new_user->profile_tabs) == 0) {
		$task = "step1";
	}
	// get language file options
	$lang_options = array();
	$lang_count = 0;
	if($dh = opendir("./lang/")) {
		while(($file = readdir($dh)) !== false) {
			if($file != "." && $file != "..") {
				if(preg_match("/lang([^_]+)\.php/", $file, $matches)) {
					$lang_options[$lang_count] = ucfirst($matches[1]);
					$lang_count++;
				}
			}
		}
		closedir($dh);
	}
}


// set default timezone
if(!isset($signup_timezone)) { 
	$signup_timezone = $setting['setting_timezone'];
}


// assign variables and include footer
$smarty->assign('error_message', $error_message);
$smarty->assign('new_user', $new_user);
$smarty->assign('tabs', $new_user->profile_tabs);
$smarty->assign('signup_email', $signup_email);
$smarty->assign('signup_phone', $signup_phone);
$smarty->assign('signup_password', $signup_password);
$smarty->assign('signup_password2', $signup_password2);
$smarty->assign('signup_username', $signup_username);
$smarty->assign('signup_timezone', $signup_timezone);
$smarty->assign('signup_lang', $signup_lang);
$smarty->assign('signup_invite', $signup_invite);
$smarty->assign('signup_secure', $signup_secure);
$smarty->assign('signup_agree', $signup_agree);
$smarty->assign('lang_options', $lang_options);
$smarty->assign('next_task', $next_task);
$smarty->assign('last_task', $last_task);
$smarty->assign('step', $step);
include "Footer.php";
?>