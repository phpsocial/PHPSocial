<?php
$page = "Login";
include "Header.php";

// if logged - forward to user home
if($user->user_exists != 0) { header("Location: " . $user->user_info[user_username]); exit(); }

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }

$userExt = new PHPS_User(array(0, '', $_POST['email']));

// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";

// GET EMAIL
if(isset($_POST['email'])) { $email = $_POST['email']; } elseif(isset($_GET['email'])) { $email = $_GET['email']; } else { $email = ""; }

// TRY TO LOGIN
if($task == "dologin") {

  $user->user_login($email, $_POST['password'], $_POST['javascript_disabled'], $_POST['persistent']);

  // IF USER IS LOGGED IN SUCCESSFULLY, FORWARD THEM TO SPECIFIED URL
  if($user->is_error == 0) {

    // INSERT ACTION 
    $actions->add($user, "login", Array('[username]'), Array($user->user_info[user_username]));

    // CHECK FOR REDIRECTION URL
    if(isset($_POST['return_url'])) { $return_url = $_POST['return_url']; } elseif(isset($_GET['return_url'])) { $return_url = $_GET['return_url']; } else { $return_url = ""; }
    $return_url = urldecode($return_url);
    $return_url = str_replace("&amp;", "&", $return_url);
    if($return_url == "" || $return_url == "Profile.php") { $return_url = $url->url_create('profile', $user->user_info['user_username']); }

    cheader("$return_url");
    exit();
  
  // IF THERE WAS AN ERROR, SET ERROR MESSAGE
  } else {
    $error_message = $user->error_message;
    $user = new PHPS_User();
  }
}


// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('email', $email);
$smarty->assign('error_message', $error_message);
$smarty->assign('return_url', $return_url);
include "Footer.php";
?>