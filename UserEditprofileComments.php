<?php
$page = "UserEditprofileComments";
include "Header.php";

if(isset($_POST['comment_id'])) { $comment_id = $_POST['comment_id']; } elseif(isset($_GET['comment_id'])) { $comment_id = $_GET['comment_id']; } else { $comment_id = 0; }

// delete comment
$database->database_query("DELETE FROM `phps_profilecomments` WHERE `profilecomment_user_id` = ".$user->user_info['user_id']." AND `profilecomment_id` = ".$comment_id);
//$database->database_query("DELETE FROM `phps_profilecomments` WHERE `profilecomment_authoruser_id` = ".$user->user_info['user_id']." AND `profilecomment_id` = ".$comment_id);
//echo "DELETE FROM `phps_profilecomments` WHERE `profilecomment_authoruser_id` = ".$user->user_info['user_id']." AND `profilecomment_id` = ".$comment_id;
header("location: /".$user->user_info['user_username']);
die();

?>