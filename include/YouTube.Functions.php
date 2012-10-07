<?php

function extract_youtube_code($video_url)
{
  $video_code_start = strpos($video_url, "v=");
  if ($video_code_start === FALSE) { 
    $is_error = 5500189;
    return FALSE;
  }
  $video_code = substr($video_url, $video_code_start + 2);
  if (empty($video_code)) 
  {
    return FALSE;
  }
  $video_code_end = strpos($video_code, '&');
  if ($video_code_end) {
    $video_code = substr($video_code, 0, $video_code_end);
  }

  return $video_code;
}



  function video_update_youtube_thumb()
  {
    global $setting, $url, $user;
    
    $width = $setting['setting_video_thumb_width'];
    $height = $setting['setting_video_thumb_height'];
    $video_youtube_code = $this->video_info['video_youtube_code'];
    $thumb_source_path = "http://img.youtube.com/vi/{$video_youtube_code}/default.jpg";
    
    $video_directory = $this->video_dir($video_info['video_user_id'], TRUE);
    
    $thumb_dimensions = @getimagesize($thumb_source_path);
    
    $thumb_width = $thumb_dimensions[0];
    $thumb_height = $thumb_dimensions[1];
    
    $destination = $video_directory . $this->video_info['video_id'] . '_thumb.jpg';
    $file = imagecreatetruecolor($width, $height);
    $new = imagecreatefromjpeg($thumb_source_path);
    for($i=0; $i<256; $i++) { imagecolorallocate($file, $i, $i, $i); } 
    imagecopyresampled($file, $new, 0, 0, 0, 0, $width, $height, $thumb_width, $thumb_height); 
    @imagejpeg($file, $destination, 100);
    ImageDestroy($new);
    $media_link = str_replace($url->url_base, '', $url->url_create('video', $user->user_info['user_username'], $this->video_info['video_id']));
    ImageDestroy($file);
    return array(
      'media_link' => $media_link,
      'media_path' => $destination,
      'media_width' => $thumb_width,
      'media_height' => $thumb_height
    );
  }

