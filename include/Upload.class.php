<?php

/**
 * Upload class. Used in uploading cases
 *
 */

class PHPS_Upload {

	/**
	 * Error flag
	 *
	 * @var integer
	 */
	public $is_error = 0;

	/**
	 * Error message
	 *
	 * @var string
	 */
	public $error_message = '';	

	/**
	 * Uploaded filename
	 *
	 * @var string
	 */
	public $file_name;
	
	/**
	 * Uploaded file mime tipy
	 * 
	 * @var string
	 */
	public $file_type;

	/**
	 * Uploaded filesize
	 *
	 * @var integer
	 */
	public $file_size;

	/**
	 * Temporary filename
	 *
	 * @var string
	 */
	public $file_tempname;

	/**
	 * Uploaded file error
	 *
	 * @var string
	 */
	public $file_error;

	/**
	 * Uploaded file extension
	 *
	 * @var string
	 */
	public $file_ext;

	/**
	 * Uploaded image width
	 *
	 * @var integer
	 */
	public $file_width;

	/**
	 * Uploaded image height
	 * 
	 * @var integer
	 */
	public $file_height;

	/**
	 * Chekc is it image or not
	 * 
	 * @var boolean
	 */
	public $is_image;

	/**
	 * Max width 
	 * 
	 * @var integer
	 */
	public $file_maxwidth;

	/**
	 * Max height
	 * 
	 * @var integer
	 */
	public $file_maxheight;

	/**
	 * Set initial variables such as filename
	 *
	 * @global array $Application
	 * @param string $file
	 * @param integer $file_maxsize
	 * @param boolean $file_exts
	 * @param array $file_types
	 * @param integer $file_maxwidth
	 * @param integer $file_maxheight
	 */
	function new_upload($file, $file_maxsize, $file_exts, $file_types, $file_maxwidth = '', $file_maxheight = '') {
	  global $Application;

	  // get file variables
	  $this->file_name = $_FILES[$file]['name'];
	  $this->file_type = strtolower($_FILES[$file]['type']);
	  $this->file_size = $_FILES[$file]['size'];
	  $this->file_tempname = $_FILES[$file]['tmp_name'];
	  $this->file_error = $_FILES[$file]['error'];
	  $this->file_ext = strtolower(str_replace(".", "", strrchr($this->file_name, "."))); 

	  $file_dimensions = @getimagesize($this->file_tempname);
	  $this->file_width = $file_dimensions[0];
	  $this->file_height = $file_dimensions[1];
	  if($file_maxwidth == "") { $file_maxwidth = $this->file_width; }
	  if($file_maxheight == "") { $file_maxheight = $this->file_height; }
	  $this->file_maxwidth = $file_maxwidth;
	  $this->file_maxheight = $file_maxheight;

	  // ensure that file is an uploaded one
	  if(!is_uploaded_file($this->file_tempname)) { $this->is_error = 1; $this->error_message = $Application[29]; }

	  // check that file size is less max file size
	  if($this->file_size > $file_maxsize) { $this->is_error = 1; $this->error_message = $Application[30]; }

	  // check extension
	  if(!in_array($this->file_ext, $file_exts)) { $this->is_error = 1; $this->error_message = $Application[31]; }

	  // check mime type
	  if(!in_array($this->file_type, $file_types)) { $this->is_error = 1; $this->error_message = $Application[31]; }

	  // determine if file is photo (and if gd can be used)
	  if($file_dimensions !== FALSE & in_array($this->file_ext, Array('gif', 'jpg', 'jpeg', 'png', 'bmp')) !== FALSE) {
	    $this->is_image = 1;
	    if(!$this->image_resize_on()) {
	      $this->is_image = 0;
	      if($file_width > $file_maxwidth OR $file_height > $file_maxheight) { $this->is_error = 1; $this->error_message = $Application[32]; }
	    }
	  } else {
	    $this->is_image = 0;
	  }


	}

	/**
	 * Upload file
	 *
	 * @global array $Application
	 * @param string $file_dest
	 * @return boolean
	 */
	function upload_file($file_dest) { 
	  global $Application;

	  // try moving uploaded file
          if(!move_uploaded_file($this->file_tempname, $file_dest)) { 
	    $this->is_error = 1; $this->error_message = $Application[29];
	    return false;
	  } else {
	    chmod($file_dest, 0777);
	    return true;
	  }

	}

	/**
	 * Upload a photo
	 *
	 * @param string $photo_dest
	 * @param string $file_maxwidth
	 * @param string $file_maxheight
	 * @return boolean
	 */
	function upload_photo($photo_dest, $file_maxwidth = "", $file_maxheight = "") { 
	  if($file_maxwidth == "") { $file_maxwidth = $this->file_maxwidth; }
	  if($file_maxheight == "") { $file_maxheight = $this->file_maxheight; }

	  if($this->file_width > $file_maxwidth | $this->file_height > $file_maxheight) { 
	    if($this->file_height > $file_maxheight) {
	      $width = ($this->file_width)*$file_maxheight/($this->file_height);
	      $height = $file_maxheight;
	    }
	    if($this->file_width > $file_maxwidth) {
	      $height = ($this->file_height)*$file_maxwidth/($this->file_width);
	      $width = $file_maxwidth;
	    }
	  } else {
	    $width = $this->file_width;
	    $height = $this->file_height;
	  }


	  // resize image and put in user directory
	  switch($this->file_ext) {
	    case "gif":
	      $file = imagecreatetruecolor($width, $height);
	      $new = imagecreatefromgif($this->file_tempname);
	      $kek=imagecolorallocate($file, 255, 255, 255);
	      imagefill($file,0,0,$kek);
	      imagecopyresampled($file, $new, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height);
	      imagejpeg($file, $photo_dest);
	      ImageDestroy($new);
	      ImageDestroy($file);
	      break;
	    case "bmp":
	      $file = imagecreatetruecolor($width, $height);
	      $new = $this->imagecreatefrombmp($this->file_tempname);
	      for($i=0; $i<256; $i++) { imagecolorallocate($file, $i, $i, $i); }
	      imagecopyresampled($file, $new, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height); 
	      imagejpeg($file, $photo_dest);
	      ImageDestroy($new);
	      ImageDestroy($file);
	      break;
	    case "jpeg":
	    case "jpg":
	      $file = imagecreatetruecolor($width, $height);
	      $new = imagecreatefromjpeg($this->file_tempname);
	      for($i=0; $i<256; $i++) { imagecolorallocate($file, $i, $i, $i); }
	      imagecopyresampled($file, $new, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height);
	      imagejpeg($file, $photo_dest);
	      ImageDestroy($new);
	      ImageDestroy($file);
	      break;
	    case "png":
	      $file = imagecreatetruecolor($width, $height);
	      $new = imagecreatefrompng($this->file_tempname);
	      for($i=0; $i<256; $i++) { imagecolorallocate($file, $i, $i, $i); }
	      imagecopyresampled($file, $new, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height); 
	      imagejpeg($file, $photo_dest);
	      ImageDestroy($new);
	      ImageDestroy($file);
	      break;
	  } 

	  chmod($photo_dest, 0777);

	  return true;

	}

	/**
	 * check for neccessary image resizing support
	 *
	 * @return boolean
	 */
	function image_resize_on() {

	  // check for GD
	  if( !is_callable('gd_info') ) return FALSE;
	
	  $gd_info = gd_info();
	  preg_match('/\d/', $gd_info['GD Version'], $match);
	  $gd_ver = $match[0];

	  if($gd_ver >= 2 AND $gd_info['GIF Read Support'] == TRUE AND $gd_info['JPG Support'] == TRUE AND $gd_info['PNG Support'] == TRUE) {
	    return true;
	  } else {
	    return false;
	  }
	} 

	/**
	 * Converts bmp to GD
	 *
	 * @param string $src
	 * @param string $dest
	 * @return boolean
	 */
	function ConvertBMP2GD($src, $dest = false) {
	  if(!($src_f = fopen($src, "rb"))) {
	    return false;
	  }
	  if(!($dest_f = fopen($dest, "wb"))) {
	    return false;
	  }

	  $header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f, 14));
	  $info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", fread($src_f, 40));

	  extract($info);
	  extract($header);

	  if($type != 0x4D42) {  // signature "BM"
	    return false;
	  }

	  $palette_size = $offset - 54;
	  $ncolor = $palette_size / 4;
	  $gd_header = "";
	  // true-color vs. palette
	  $gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF"; 
	  $gd_header .= pack("n2", $width, $height);
	  $gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
	  if($palette_size) {
	    $gd_header .= pack("n", $ncolor);
	  }
	  // no transparency
	  $gd_header .= "\xFF\xFF\xFF\xFF";     
	
	  fwrite($dest_f, $gd_header);
	
	  if($palette_size) {
	    $palette = fread($src_f, $palette_size);
	    $gd_palette = "";
	    $j = 0;
	    while($j < $palette_size) {
	      $b = $palette{$j++};
	      $g = $palette{$j++};
	      $r = $palette{$j++};
	      $a = $palette{$j++};
	      $gd_palette .= "$r$g$b$a";
	    }
	    $gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
	    fwrite($dest_f, $gd_palette);
	  }
	
	  $scan_line_size = (($bits * $width) + 7) >> 3;
	  $scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;
	
	  for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
	    // BMP stores scan lines starting from bottom
	    fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));
	    $scan_line = fread($src_f, $scan_line_size);
	    if($bits == 24) {
	      $gd_scan_line = "";
	      $j = 0;
	      while($j < $scan_line_size) {
	        $b = $scan_line{$j++};
	        $g = $scan_line{$j++};
	        $r = $scan_line{$j++};
	        $gd_scan_line .= "\x00$r$g$b";
	      }
	    } elseif($bits == 8) {
	      $gd_scan_line = $scan_line;
	    } elseif($bits == 4) {
	      $gd_scan_line = "";
	      $j = 0;
	      while($j < $scan_line_size) {
	        $byte = ord($scan_line{$j++});
	        $p1 = chr($byte >> 4);
	        $p2 = chr($byte & 0x0F);
	        $gd_scan_line .= "$p1$p2";
	      } 
	      $gd_scan_line = substr($gd_scan_line, 0, $width);
	    } elseif($bits == 1) {
	      $gd_scan_line = "";
	      $j = 0;
	      while($j < $scan_line_size) {
	        $byte = ord($scan_line{$j++});
	        $p1 = chr((int) (($byte & 0x80) != 0));
	        $p2 = chr((int) (($byte & 0x40) != 0));
	        $p3 = chr((int) (($byte & 0x20) != 0));
	        $p4 = chr((int) (($byte & 0x10) != 0)); 
	        $p5 = chr((int) (($byte & 0x08) != 0));
	        $p6 = chr((int) (($byte & 0x04) != 0));
	        $p7 = chr((int) (($byte & 0x02) != 0));
	        $p8 = chr((int) (($byte & 0x01) != 0));
	        $gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
	      } 
	      $gd_scan_line = substr($gd_scan_line, 0, $width);
	    }
	    
	    fwrite($dest_f, $gd_scan_line);
	  }
	
	  fclose($src_f);
	  fclose($dest_f);
	
	  return true;
	
	} 
	
	/**
	 * Create an image from bmp
	 * 
	 * @param string $filename
	 * @return image
	 */
	function imagecreatefrombmp($filename) {
	
	  $tmp_name = tempnam("/tmp", "GD");
	  if($this->ConvertBMP2GD($filename, $tmp_name)) {
	    $img = imagecreatefromgd($tmp_name);
	    unlink($tmp_name);
	    return $img;
	  } else {
	    return false;
	  }

	}
}
