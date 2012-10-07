<?php
/**
 * Email related functions
 *
 */

/**
 * Send custom email
 * 
 * @param string $recipient
 * @param string $sender
 * @param string $subject
 * @param string $message
 * @param string $search
 * @param string $replace
 * @return boolean
 */
function send_generic($recipient, $sender, $subject, $message, $search, $replace) {

	// decode stuff for sending
	$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
	$message = htmlspecialchars_decode($message, ENT_QUOTES);

	// replace variables in message and subject
	$subject = str_replace($search, $replace, $subject);
	$message = str_replace($search, $replace, $message);

	// encode for utf-8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// replace newlines with brakes
	$message = str_replace("\n", "<br>", $message);

	// set headers
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $sender"."\n";
	$headers .= "Return-Path: $sender"."\n";
	$headers .= "Reply-To: $sender";

	// send mail
	mail($recipient, $subject, $message, $headers);

	return true;
} 

/**
 * Send verification email to user
 *
 * @global array $setting
 * @global string $url
 * @param array $user_info
 * @return boolean
 */
function send_verification($user_info) {
	global $setting, $url;
	$prefix = $url->url_base;
	$verify_code = md5($user_info[user_code]);
	$time = time();
	$verify_link = "$prefix"."SignupVerify.php?u=$user_info[user_id]&verify=$verify_code&d=$time";
	$subject = htmlspecialchars_decode($setting[setting_email_verify_subject], ENT_QUOTES);
	$message = htmlspecialchars_decode($setting[setting_email_verify_message], ENT_QUOTES);
	$subject = str_replace("[username]", $user_info[user_username], $subject);
	$message = str_replace("[username]", $user_info[user_username], $message);
	$subject = str_replace("[email]", $user_info[user_email], $subject);
	$message = str_replace("[email]", $user_info[user_email], $message);
	$subject = str_replace("[link]", "<a href=\"$verify_link\">".$verify_link."</a>", $subject);
	$message = str_replace("[link]", "<a href=\"$verify_link\">".$verify_link."</a>", $message);
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";
	$message = str_replace("\n", "<br>", $message);

	// set headers
	$from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// send mail
	mail($user_info[user_newemail], $subject, $message, $headers);

	return true;
}

/**
 * Send wellcome email to the user
 * 
 * @global string $url
 * @global array $setting
 * @param array $user_info
 * @param string $password
 * @return bolean
 */
function send_welcome($user_info, $password = "") {
	global $url, $setting;
	$prefix = $url->url_base;
	$subject = htmlspecialchars_decode($setting[setting_email_welcome_subject], ENT_QUOTES);
	$message = htmlspecialchars_decode($setting[setting_email_welcome_message], ENT_QUOTES);
	$subject = str_replace("[username]", $user_info[user_username], $subject);
	$message = str_replace("[username]", $user_info[user_username], $message);
	$subject = str_replace("[email]", $user_info[user_email], $subject);
	$message = str_replace("[email]", $user_info[user_email], $message);
	$subject = str_replace("[password]", $password, $subject);
	$message = str_replace("[password]", $password, $message);
	$subject = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $subject);
	$message = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $message);
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";
	$message = str_replace("\n", "<br>", $message);

	// set headers
	$from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// send mail
	mail($user_info[user_email], $subject, $message, $headers);

	return true;
}

/**
 * Send new password email to user
 *
 * @global array $setting
 * @global PHPS_Url $url
 * @param array $user_info
 * @param string $newpass
 * @return boolean
 */
function send_newpass($user_info, $newpass) {
	global $setting, $url;

	$prefix = $url->url_base;

	$subject = htmlspecialchars_decode($setting[setting_email_newpass_subject], ENT_QUOTES);
	$message = htmlspecialchars_decode($setting[setting_email_newpass_message], ENT_QUOTES);

	$subject = str_replace("[username]", $user_info[user_username], $subject);
	$message = str_replace("[username]", $user_info[user_username], $message);
	$subject = str_replace("[email]", $user_info[user_email], $subject);
	$message = str_replace("[email]", $user_info[user_email], $message);
	$subject = str_replace("[password]", $newpass, $subject);
	$message = str_replace("[password]", $newpass, $message);
	$subject = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $subject);
	$message = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $message);

	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	$message = str_replace("\n", "<br>", $message);

	// set headers
	$from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// send email
	mail($user_info[user_email], $subject, $message, $headers);

	return true;
} 

/**
 * Send generic invitation email
 *
 * @global array $setting
 * @global PHPS_Url $url
 * @param array $user_info
 * @param array $invite_emails
 * @param string $invite_message
 * @return boolean
 */
function send_invitation($user_info, $invite_emails, $invite_message = "") {
	global $setting, $url;

	$prefix = $url->url_base;

	//check that are no more than 5 emails
	$invite_emails = array_slice(explode(",", $invite_emails), 0, 5);

	$subject = htmlspecialchars_decode($setting[setting_email_invite_subject], ENT_QUOTES);
	$message = htmlspecialchars_decode($setting[setting_email_invite_message], ENT_QUOTES);

	$subject = str_replace("[username]", $user_info[user_username], $subject);
	$message = str_replace("[username]", $user_info[user_username], $message);
	$subject = str_replace("[email]", $user_info[user_email], $subject);
	$message = str_replace("[email]", $user_info[user_email], $message);
	$subject = str_replace("[message]", $invite_message, $subject);
	$message = str_replace("[message]", $invite_message, $message);
	$subject = str_replace("[link]", "<a href=\"$prefix"."Signup.php\">$prefix"."Signup.php</a>", $subject);
	$message = str_replace("[link]", "<a href=\"$prefix"."Signup.php\">$prefix"."Signup.php</a>", $message);

	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	$message = str_replace("\n", "<br>", $message);

	$from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	for($e=0;$e<5;$e++) {
	  $invite_email = str_replace(" ", "", $invite_emails[$e]);
	  if($invite_email != "") {
	    @mail($invite_email, $subject, $message, $headers);
	  }
	}
  
	return true;
}

/**
 * Send invitation code
 *
 */
function send_invitecode($user_info, $invite_emails, $invite_message="") {
	global $database, $setting, $url;

	$time = time();
	$invites_left = $user_info[user_invitesleft];

	$prefix = $url->url_base;
  
	$emails = explode(",", $invite_emails);
	for($e=0;$e<5;$e++) {
	  $email = str_replace(" ", "", $emails[$e]);
	  if($email != "" & $invites_left > 0) {

	    $invite_code = randomcode();
	    $database->database_query("INSERT INTO phps_invites (invite_user_id, invite_date, invite_email, invite_code) VALUES ('$user_info[user_id]', '$time', '$email', '$invite_code')");

	    $subject = htmlspecialchars_decode($setting[setting_email_invitecode_subject], ENT_QUOTES);
	    $message = htmlspecialchars_decode($setting[setting_email_invitecode_message], ENT_QUOTES);
 
	    $subject = str_replace("[username]", $user_info[user_username], $subject);
	    $message = str_replace("[username]", $user_info[user_username], $message);
	    $subject = str_replace("[email]", $user_info[user_email], $subject);
	    $message = str_replace("[email]", $user_info[user_email], $message);
	    $subject = str_replace("[message]", $invite_message, $subject);
	    $message = str_replace("[message]", $invite_message, $message);
	    $subject = str_replace("[code]", $invite_code, $subject);
	    $message = str_replace("[code]", $invite_code, $message);
	    $subject = str_replace("[link]", "<a href=\"$prefix"."Signup.php?signup_email=$email&signup_invite=$invite_code\">$prefix"."Signup.php?signup_email=$email&signup_invite=$invite_code</a>", $subject);
	    $message = str_replace("[link]", "<a href=\"$prefix"."Signup.php?signup_email=$email&signup_invite=$invite_code\">$prefix"."Signup.php?signup_email=$email&signup_invite=$invite_code</a>", $message);
		
	    $subject="=?UTF-8?B?".base64_encode($subject)."?=";

	    $message = str_replace("\n", "<br>", $message);

	    $from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	    $headers = "MIME-Version: 1.0"."\n";
	    $headers .= "Content-type: text/html; charset=utf-8"."\n";
	    $headers .= "Content-Transfer-Encoding: 8bit"."\n";
	    $headers .= "From: $from_email"."\n";
	    $headers .= "Return-Path: $from_email"."\n";
	    $headers .= "Reply-To: $from_email";

	    @mail($email, $subject, $message, $headers);
 
	    if($user_info[user_id] != 0) { $invites_left--; }
	  }
	}
 
	if($user_info[user_id] != 0) {
	  $database->database_query("UPDATE phps_users SET user_invitesleft='$invites_left' WHERE user_id='$user_info[user_id]'");
	}

	return true;
}

// THIS FUNCTION SENDS LOST PASSWORD EMAIL
// INPUT: $user_info REPRESENTING THE RECIPIENT'S USER INFO
//	  $lostpassword_code REPRESENTING THE CODE ASSOCIATED WITH RESETTING THE PASSWORD
// OUTPUT:
function send_lostpassword($user_info, $lostpassword_code) {
	global $setting, $url;

	// GET SERVER INFO
	$prefix = $url->url_base;

	// DECODE SUBJECT AND EMAIL FOR SENDING
	$subject = htmlspecialchars_decode($setting[setting_email_lostpassword_subject], ENT_QUOTES);
	$message = htmlspecialchars_decode($setting[setting_email_lostpassword_message], ENT_QUOTES);

	// REPLACE VARIABLES IN EMAIL SUBJECT AND MESSAGE
	$subject = str_replace("[username]", $user_info[user_username], $subject);
	$message = str_replace("[username]", $user_info[user_username], $message);
	$subject = str_replace("[email]", $user_info[user_email], $subject);
	$message = str_replace("[email]", $user_info[user_email], $message);
	$subject = str_replace("[link]", "<a href=\"$prefix"."LostpassReset.php?user=$user_info[user_username]&r=$lostpassword_code\">$prefix"."LostpassReset.php?user=$user_info[user_username]&r=$lostpassword_code</a>", $subject);
	$message = str_replace("[link]", "<a href=\"$prefix"."LostpassReset.php?user=$user_info[user_username]&r=$lostpassword_code\">$prefix"."LostpassReset.php?user=$user_info[user_username]&r=$lostpassword_code</a>", $message);

	// ENCODE SUBJECT FOR UTF8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// REPLACE CARRIAGE RETURNS WITH BREAKS
	$message = str_replace("\n", "<br>", $message);

	// SET HEADERS
	$from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// SEND MAIL
	@mail($user_info[user_email], $subject, $message, $headers);
  
	return true;
}

// THIS FUNCTION SENDS FRIEND REQUEST TO USER
// INPUT: $owner REPRESENTING THE RECIPIENT'S USER OBJECT
//	  $friendname REPRESENTING THE NAME OF THE USER REQUESTING FRIENDSHIP
// OUTPUT:
function send_friendrequest($owner, $friendname) {
	global $setting, $url;

	// SET USER SETTINGS
	$owner->user_settings();

	// MAKE SURE USER WANTS TO BE NOTIFIED
	if($owner->usersetting_info[usersetting_notify_friendrequest] != 0) {
  
	  // GET SERVER INFO
	  $prefix = $url->url_base;

	  // DECODE SUBJECT AND EMAIL FOR SENDING
	  $subject = htmlspecialchars_decode($setting[setting_email_friendrequest_subject], ENT_QUOTES);
	  $message = htmlspecialchars_decode($setting[setting_email_friendrequest_message], ENT_QUOTES);

	  // REPLACE VARIABLES IN EMAIL SUBJECT AND MESSAGE
	  $subject = str_replace("[username]", $owner->user_info[user_username], $subject);
	  $message = str_replace("[username]", $owner->user_info[user_username], $message);
	  $subject = str_replace("[friendname]", $friendname, $subject);
	  $message = str_replace("[friendname]", $friendname, $message);
	  $subject = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $subject);
	  $message = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $message);

	  // ENCODE SUBJECT FOR UTF8
	  $subject="=?UTF-8?B?".base64_encode($subject)."?=";

	  // REPLACE CARRIAGE RETURNS WITH BREAKS
	  $message = str_replace("\n", "<br>", $message);

	  // SET HEADERS
	  $from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	  $headers = "MIME-Version: 1.0"."\n";
	  $headers .= "Content-type: text/html; charset=utf-8"."\n";
	  $headers .= "Content-Transfer-Encoding: 8bit"."\n";
	  $headers .= "From: $from_email"."\n";
	  $headers .= "Return-Path: $from_email"."\n";
	  $headers .= "Reply-To: $from_email";

	  // SEND MAIL
	  @mail($owner->user_info[user_email], $subject, $message, $headers);

	}  

	return true;
} 

// THIS FUNCTION SENDS NEW MESSAGE NOTIFICATION TO USER
// INPUT: $touser REPRESENTING THE RECIPIENT'S USER OBJECT
//	  $sender REPRESENTING THE USERNAME OF THE MESSAGE SENDER
// OUTPUT:
function send_message($touser, $sender) {
	global $setting, $url;

	// SET USER SETTINGS
	$touser->user_settings();

	// MAKE SURE USER WANTS TO BE NOTIFIED
	if($touser->usersetting_info[usersetting_notify_message] != 0) {

	  // GET SERVER INFO
	  $prefix = $url->url_base;

	  // DECODE SUBJECT AND EMAIL FOR SENDING
	  $subject = htmlspecialchars_decode($setting[setting_email_message_subject], ENT_QUOTES);
	  $message = htmlspecialchars_decode($setting[setting_email_message_message], ENT_QUOTES);

	  // REPLACE VARIABLES IN EMAIL SUBJECT AND MESSAGE
	  $subject = str_replace("[username]", $touser->user_info[user_username], $subject);
	  $message = str_replace("[username]", $touser->user_info[user_username], $message);
	  $subject = str_replace("[sender]", $sender, $subject);
	  $message = str_replace("[sender]", $sender, $message);
	  $subject = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $subject);
	  $message = str_replace("[link]", "<a href=\"$prefix"."Login.php\">$prefix"."Login.php</a>", $message);
  
	  // ENCODE SUBJECT FOR UTF8
	  $subject="=?UTF-8?B?".base64_encode($subject)."?=";

	  // REPLACE CARRIAGE RETURNS WITH BREAKS
	  $message = str_replace("\n", "<br>", $message);

	  // SET HEADERS
	  $from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	  $headers = "MIME-Version: 1.0"."\n";
	  $headers .= "Content-type: text/html; charset=utf-8"."\n";
	  $headers .= "Content-Transfer-Encoding: 8bit"."\n";
	  $headers .= "From: $from_email"."\n";
	  $headers .= "Return-Path: $from_email"."\n";
	  $headers .= "Reply-To: $from_email";

	  // SEND MAIL
	  @mail($touser->user_info[user_email], $subject, $message, $headers);

	}  

	return true;
}

// THIS FUNCTION SENDS PROFILE COMMENT NOTIFICATION TO USER
// INPUT: $owner REPRESENTING THE RECIPIENT'S USER OBJECT
//	  $commenter REPRESENTING THE COMMENTER'S USERNAME
// OUTPUT:
function send_profilecomment($owner, $commenter) {
	global $setting, $url;

	// SET USER SETTINGS
	$owner->user_settings();

	// MAKE SURE USER WANTS TO BE NOTIFIED
	if($owner->usersetting_info[usersetting_notify_profilecomment] != 0) {

	  // DECODE SUBJECT AND EMAIL FOR SENDING
	  $subject = htmlspecialchars_decode($setting[setting_email_profilecomment_subject], ENT_QUOTES);
	  $message = htmlspecialchars_decode($setting[setting_email_profilecomment_message], ENT_QUOTES);

	  // REPLACE VARIABLES IN EMAIL SUBJECT AND MESSAGE
	  $subject = str_replace("[username]", $owner->user_info[user_username], $subject);
	  $message = str_replace("[username]", $owner->user_info[user_username], $message);
	  $subject = str_replace("[commenter]", $commenter, $subject);
	  $message = str_replace("[commenter]", $commenter, $message);
	  $subject = str_replace("[link]", "<a href=\"".$url->url_create("profile", $owner->user_info[user_username])."\">".$url->url_create("profile", $owner->user_info[user_username])."</a>", $subject);
	  $message = str_replace("[link]", "<a href=\"".$url->url_create("profile", $owner->user_info[user_username])."\">".$url->url_create("profile", $owner->user_info[user_username])."</a>", $message);

	  // ENCODE SUBJECT FOR UTF8
	  $subject="=?UTF-8?B?".base64_encode($subject)."?=";

	  // REPLACE CARRIAGE RETURNS WITH BREAKS
	  $message = str_replace("\n", "<br>", $message);

	  // SET HEADERS
	  $from_email = "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>";
	  $headers = "MIME-Version: 1.0"."\n";
	  $headers .= "Content-type: text/html; charset=utf-8"."\n";
	  $headers .= "Content-Transfer-Encoding: 8bit"."\n";
	  $headers .= "From: $from_email"."\n";
	  $headers .= "Return-Path: $from_email"."\n";
	  $headers .= "Reply-To: $from_email";

	  // SEND MAIL
	  @mail($owner->user_info[user_email], $subject, $message, $headers);

	}  

	return true;
} 

// THIS FUNCTION SENDS ANNOUNCEMENT
// INPUT: $user_email REPRESENTING THE RECIPIENT'S EMAIL
//	  $from_email REPRESENTING THE SENDER'S EMAIL
//	  $subject REPRESENTING THE SUBJECT
//	  $message REPRESENTING THE MESSAGE
// OUTPUT:
function send_announcement($user_email, $from_email, $subject, $message) {

	// DECODE SUBJECT AND EMAIL FOR SENDING
	$from_email = htmlspecialchars_decode($from_email, ENT_QUOTES);
	$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
	$message = htmlspecialchars_decode($message, ENT_QUOTES);

	// ENCODE SUBJECT FOR UTF8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// REPLACE CARRIAGE RETURNS WITH BREAKS
	$message = str_replace("\n", "<br>", $message);

	// SET HEADERS
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// SEND MAIL
	@mail($user_email, $subject, $message, $headers);

	return true;
}

// THIS FUNCTION SENDS HELP EMAIL
// INPUT: $admin_email REPRESENTING THE RECIPIENT'S EMAIL ADDRESS
//	  $from_email REPRESENTING THE SENDER'S EMAIL ADDRESS
//	  $subject REPRESENTING THE SUBJECT
//	  $message REPRESENTING THE MESSAGE
// OUTPUT:
function send_helpcontact($admin_email, $from_email, $subject, $message) {

	// DECODE SUBJECT AND EMAIL FOR SENDING
	$from_email = htmlspecialchars_decode($from_email, ENT_QUOTES);
	$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
	$message = htmlspecialchars_decode($message, ENT_QUOTES);

	// ENCODE SUBJECT FOR UTF8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// REPLACE CARRIAGE RETURNS WITH BREAKS
	$message = str_replace("\n", "<br>", $message);

	// SET HEADERS
	$headers = "MIME-Version: 1.0"."\n";
	$headers .= "Content-type: text/html; charset=utf-8"."\n";
	$headers .= "Content-Transfer-Encoding: 8bit"."\n";
	$headers .= "From: $from_email"."\n";
	$headers .= "Return-Path: $from_email"."\n";
	$headers .= "Reply-To: $from_email";

	// SEND MAIL
	@mail($admin_email, $subject, $message, $headers);

	return true;
} 
?>