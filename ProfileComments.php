<?php
$page = "ProfileComments";
include "Header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

if($user->user_exists == 0 & $setting[setting_permission_profile] == 0) {
  $page = "error";
  $smarty->assign('error_header', $profile_comments[20]);
  $smarty->assign('error_message', $profile_comments[22]);
  $smarty->assign('error_submit', $profile_comments[23]);
  include "Footer.php";
}

if($owner->user_exists == 0) {
  $page = "error";
  $smarty->assign('error_header', $profile_comments[20]);
  $smarty->assign('error_message', $profile_comments[21]);
  $smarty->assign('error_submit', $profile_comments[23]);
  include "Footer.php";
}

// get privacy level
$privacy_level = $owner->user_privacy_max($user, $owner->level_info[level_profile_privacy]);
$allowed_privacy = true_privacy($owner->user_info[user_privacy_profile], $owner->level_info[level_profile_privacy]);
if($privacy_level < $allowed_privacy) { header("Location: ".$url->url_create('profile', $owner->user_info[user_username])); exit(); }


$is_error = 0;
$refresh = 0;
$allowed_to_comment = 1;


// check if user is allowed to comment
$comment_level = $owner->user_privacy_max($user, $owner->level_info[level_profile_comments]);
$allowed_comment = true_privacy($owner->user_info[user_privacy_comments], $owner->level_info[level_profile_comments]);
if($comment_level < $allowed_comment) { $allowed_to_comment = 0; }



// if a comment is being posted
if($task == "dopost" & $allowed_to_comment != 0) {
  $comment_date = time();
  $comment_body = $_POST['comment_body'];

  // retrive and check security code if necessary
  if($setting[setting_comment_code] != 0) {
    session_start();
    $code = $_SESSION['code'];
    if($code == "") { $code = randomcode(); }
    $comment_secure = $_POST['comment_secure'];

    if($comment_secure != $code) { $is_error = 1; }
  }

  // validate comment body
  $comment_body = censor(str_replace("\r\n", "<br>", $comment_body)); 
  $comment_body = preg_replace('/(<br>){3,}/is', '<br><br>', $comment_body);
  $comment_body = ChopText($comment_body);
  if(str_replace(" ", "", $comment_body) == "" && !($_FILES['comment_mp3']['tmp_name'] || $_FILES['comment_image']['tmp_name'] || trim($_POST['comment_video']))) { $is_error = 1; $comment_body = ""; }

  if($is_error == 0) {
    $comment_body_action = $comment_body;

    if ($_FILES['comment_mp3']['tmp_name'] && $_FILES['comment_mp3']['type'] == "audio/mpeg") {
        $uploaddir = $url->url_userTRdir($owner->user_info[user_id]);
        $uploadfile = $uploaddir . mt_rand(100,999) . substr(time(), 7) . ".mp3";
        move_uploaded_file($_FILES['comment_mp3']['tmp_name'], $uploadfile);

        $myId3 = new ID3($uploadfile);
        if ($myId3->getInfo()){
          if($myId3->getArtist() != " " || $myId3->getTitle() != " "){
              $music_title = security(censor($myId3->getArtist() .' - '.  $myId3->getTitle()));
          } else {
              $music_title = $_FILES['comment_mp3']['name'];
          }
        }else{
          if($myId3->last_error_num != 0){
              $music_title = $_FILES['comment_mp3']['name'];
          } else {
              $music_title = $myId3->last_error_num;
          }
        }	      
                
        $comment_body = addslashes('<object type="application/x-shockwave-flash" data="images/mp3.swf" width="200" height="20"><param name="movie" value="images/mp3.swf" /><param name="bgcolor" value="#ffffff" /><param name="FlashVars" value="mp3='.$uploadfile.'&amp;bgcolor=ffffff&amp;buttoncolor=717171&amp;slidercolor=919191" /></object><br/><span style="color:#999">'.$music_title.'</span><br/><br/>').$comment_body;
        
    } elseif ($_FILES['comment_image']['tmp_name'] && ($_FILES['comment_image']['type'] == "image/jpeg" || $_FILES['comment_image']['type'] == "image/pjpeg" || $_FILES['comment_image']['type'] == "image/gif" || $_FILES['comment_image']['type'] == "image/png")) {
        $new_media = new PHPS_Upload();
        $new_media->new_upload('comment_image', 16*1024*1024, array('jpg','jpeg','gif','png'), array("image/jpeg","image/pjpeg","image/gif","image/png"));
	    $media_id = mt_rand(100, 999) . substr(time(), 7);
	    $file_dest = $url->url_userTRdir($owner->user_info[user_id]).$media_id.".jpg";
	    $thumb_dest = $url->url_userTRdir($owner->user_info[user_id]).$media_id."_thumb.jpg";
	    
        $new_media->upload_photo($file_dest);
        $new_media->upload_photo($thumb_dest, 300, 200);
	    
        $comment_body = addslashes('<img src="'.$thumb_dest.'" alt="" /><br/><br/>').$comment_body;
	    
    } elseif ($_POST['comment_video']) {
        if ($code = extract_youtube_code($_POST['comment_video'])) {
            $comment_body = addslashes('<object width="300" height="200"><param name="wmode" value="transparent"></param><param name="movie" value="http://www.youtube.com/v/'.$code.'&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed wmode="transparent" src="http://www.youtube.com/v/'.$code.'&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="300" height="200"></embed></object><br/><br/>').$comment_body;
        }
    }
    

    $database->database_query("INSERT INTO phps_profilecomments (profilecomment_user_id, profilecomment_authoruser_id, profilecomment_date, profilecomment_body) VALUES ('".$owner->user_info[user_id]."', '".$user->user_info[user_id]."', '$comment_date', '$comment_body')");

    $comment_id = mysql_insert_id();

    // insert action if user exists
    if($user->user_exists != 0) {
      $commenter = $user->user_info[user_username];
      $comment_body_encoded = $comment_body_action;
      if(strlen($comment_body_encoded) > 250) { 
        $comment_body_encoded = substr($comment_body_encoded, 0, 240);
        $comment_body_encoded .= "...";
      }
      $comment_body_encoded = htmlspecialchars(str_replace("<br>", " ", $comment_body_encoded), ENT_QUOTES, 'UTF-8');
      $actions->add($user, "postcomment", Array('[username1]', '[username2]', '[comment]'), Array($commenter, $owner->user_info[user_username], $comment_body_encoded));
    } else { 
      $commenter = $profile_comments[12]; 
    }

    if($owner->user_info[user_id] != $user->user_info[user_id]) { send_profilecomment($owner, $commenter); }
  }

  echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type=\"text/javascript\">";
  echo "window.parent.addComment('$is_error', '$comment_body', '$comment_date', '$comment_id');";
  echo "</script></head><body></body></html>";
  exit();
}



// create comment
$comment = new PHPS_Comment('profile', 'user_id', $owner->user_info[user_id]);

// get total comments
$total_comments = $comment->comment_total();

// make comments page
$comments_per_page = 10;
$page_vars = make_page($total_comments, $comments_per_page, $p);

//get profile comments
$comments = $comment->comment_list($page_vars[0], $comments_per_page);


// get custom profile style if allowed
if($user->level_info[level_profile_style] != 0) { 
  $profilestyle_info = $database->database_fetch_assoc($database->database_query("SELECT profilestyle_css FROM phps_profilestyles WHERE profilestyle_user_id='".$owner->user_info[user_id]."' LIMIT 1")); 
  $global_css = $profilestyle_info[profilestyle_css];
}


$smarty->assign('comments', $comments);
$smarty->assign('allowed_to_comment', $allowed_to_comment);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('total_comments', $total_comments);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($comments));
include "Footer.php";
?>