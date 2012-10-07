<?php

/**
 * Misc class.
 * 
 */

class PHPS_Misc {

	/**
	 * Change image proportionally
	 *
	 * @param string $photo
	 * @param integer $max_width
	 * @param integer $max_height
	 * @param string $return_value
	 * @return string
	 */
	function photo_size($photo, $max_width, $max_height, $return_value = "w") {
      global $path2Phps;
	  if (file_exists($path2Phps.substr($photo,1))) $dimensions = @getimagesize($path2Phps.substr($photo,1));
	  else $dimensions = @getimagesize($path2Phps.$photo);
	  $width = $dimensions[0];
	  $height = $dimensions[1];

	  if($width > $max_width | $height > $max_height) { 
	    if($width > $max_width) {
	      $height = $height*$max_width/$width;
	      $width = $max_width;
	    }
	    if($height > $max_height) {
	      $width = $width*$max_height/$height;
	      $height = $max_height;
	    }
	  }

	  if($return_value == "w") { $image_dimension = $width; } else { $image_dimension = $height; }
	
	  return round($image_dimension);

	}

}
