<?php
/**
 * Datatime class. Contains date time related methods
 *
 * Using to work with date, time, timestamps
 *
 */


class PHPS_Datetime {

	/**
	 * There is error or not
	 *
	 * @var boolean
	 */
	public $is_error;

	/**
	 * Create formated date (multilanguage)
	 *
	 * @global boolean $multi_language
	 * @param string $format
	 * @param string $time
	 * @return string
	 */
	function cdate($format, $time = "") {
	  global $multi_language;

	  if($time == "") { $time = time(); }

	  if($multi_language != "yes") {
	    return date($format, $time);
	  } else {
	    $date_letters = Array("a", "A", "B", "c", "D", "d", "F", "m", "M", "I", "i", "g", "h", "H", "G", "j", "l", "L", "n", "O", "r", "S", "s", "t", "U", "W", "w", "Y", "y", "z", "Z", "T");
	    $strftime_letters = Array("%p", "%p", "", "", "%a", "%d", "%B", "%m", "%b", "", "%M", "%I", "%I", "%H", "%H", "%e", "%A", "", "%m", "", "", "", "%S", "", "", "%V", "%w", "%Y", "%y", "%j", "", "%Z");
	    $new_format = str_replace($date_letters, $strftime_letters, $format);
	    return strftime($new_format, $time);
	  }

	}

	/**
	 * Returns a timestamp in correct timezone
	 *
	 * @param string $time
	 * @param string $timezone
	 * @return string
	 */
	function timezone($time, $timezone) {

	  $time = $time-(date("Z")-(date("I")*3600));

	  switch($timezone) {
	    case -12: $new_time = $time - 43200; break;
	    case -11: $new_time = $time - 39600; break;
	    case -10: $new_time = $time - 33000; break;
	    case -9: $new_time = $time - 32400; break;
	    case -8: $new_time = $time - 28800; break;
	    case -7: $new_time = $time - 25200; break;
	    case -6: $new_time = $time - 21600; break;
	    case -5: $new_time = $time - 18000; break;
	    case -4: $new_time = $time - 14400; break;
	    case -3.3: $new_time = $time - 11880; break;
	    case -3: $new_time = $time - 10800; break;
	    case -2: $new_time = $time - 7200; break;
	    case -1: $new_time = $time - 3600; break;
	    case 0: $new_time = $time; break;
  	    case 1: $new_time = $time + 3600; break;
  	    case 2: $new_time = $time + 7200; break;
  	    case 3: $new_time = $time + 10800; break;
  	    case 3.3: $new_time = $time + 11880; break;
  	    case 4: $new_time = $time + 14400; break;
  	    case 4.3: $new_time = $time + 15480; break;
  	    case 5: $new_time = $time + 18000; break;
  	    case 5.5: $new_time = $time + 19800; break;
  	    case 6: $new_time = $time + 21600; break;
  	    case 7: $new_time = $time + 25200; break;
  	    case 8: $new_time = $time + 28800; break;
  	    case 9: $new_time = $time + 32400; break;
  	    case 9.3: $new_time = $time + 33480; break;
  	    case 10: $new_time = $time + 33000; break;
  	    case 11: $new_time = $time + 39600; break;
  	    case 12: $new_time = $time + 43200; break;
	  }

	  return $new_time;
  
	}

	/**
	 * this method returns a string specifying the time since specified timestamp
	 *
	 * @global array $Application
	 * @param string $time
	 * @return string
	 */
	function time_since($time) {
	  global $Application;

	  $now = time();
	  $now_day = date("j", $now);
	  $now_month = date("n", $now);
	  $now_year = date("Y", $now);

	  $time_day = date("j", $time);
	  $time_month = date("n", $time);
	  $time_year = date("Y", $time);
	  $time_since = "";

	  switch(TRUE) {
	  
	    case ($now-$time < 60):
	      // seconds
	      $seconds = $now-$time;
	      $time_since = "$seconds ".$Application[22];
	      break;
	    case ($now-$time < 3600):
	      // minutes
	      $minutes = round(($now-$time)/60);
	      $time_since = "$minutes ".$Application[23];
	      break;
	    case ($now-$time < 86400):
	      // hours
	      $hours = round(($now-$time)/3600);
	      $time_since = "$hours ".$Application[24];
	      break;
	    case ($now-$time < 1209600):
	      // days
	      $days = round(($now-$time)/86400);
	      $time_since = "$days ".$Application[25];
	      break;
	    case (mktime(0, 0, 0, $now_month-1, $now_day, $now_year) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // weeks
	      $weeks = round(($now-$time)/604800);
	      $time_since = "$weeks ".$Application[26];
	      break;
	    case (mktime(0, 0, 0, $now_month, $now_day, $now_year-1) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // retunr months
	      if($now_year == $time_year) { $subtract = 0; } else { $subtract = 12; }
	      $months = round($now_month-$time_month+$subtract);
	      $time_since = "$months ".$Application[27];
	      break;
	    default:
	      // return years
	      if($now_month < $time_month) { 
	        $subtract = 1; 
	      } elseif($now_month == $time_month) {
	        if($now_day < $time_day) { $subtract = 1; } else { $subtract = 0; }
	      } else { 
	        $subtract = 0; 
	      }
	      $years = $now_year-$time_year-$subtract;
	      $time_since = "$years ".$Application[28];
	      break;

	  }

	  if($time_since == "0 years ago") { $time_since = ""; }

	  return $time_since;
  
	}

	/**
	 * Returns age based on current timestamp
	 *
	 * @param string $time
	 * @return string
	 */
	function age($time) {

	  $now = time();
	  $now_day = date("j", $now);
	  $now_month = date("n", $now);
	  $now_year = date("Y", $now);

	  $time_day = date("j", $time);
	  $time_month = date("n", $time);
	  $time_year = date("Y", $time);

	  // RETURNS YEARS
	  if($now_month < $time_month) { 
	    $subtract = 1; 
	  } elseif($now_month == $time_month) {
	    if($now_day < $time_day) {
	      $subtract = 1;
	    } else {
	      $subtract = 0;
	    }
	  } else { 
	    $subtract = 0; 
	  }
	  $years = $now_year-$time_year-$subtract;
	  return $years;
  
	} 

	/**
	 * Make a negative timestamp
	 *
	 * @return string
	 */
	function MakeTime() {
	  $objArgs = func_get_args();
	  $nCount = count($objArgs);
	  if($nCount < 7) {
	    $objDate = getdate();
	    if($nCount < 1)
	      $objArgs[] = $objDate["hours"];
	    if($nCount < 2)
	      $objArgs[] = $objDate["minutes"];
	    if($nCount < 3)
	      $objArgs[] = $objDate["seconds"];
	    if($nCount < 4)
	      $objArgs[] = $objDate["mon"];
	    if($nCount < 5)
	      $objArgs[] = $objDate["mday"];
	    if($nCount < 6)
	      $objArgs[] = $objDate["year"];
	    if($nCount < 7)
	      $objArgs[] = -1;
	  }
	  $nYear = $objArgs[5];
	  $nOffset = 0;

	  if($nYear < 1970) {
	    $nOffset = -2019686400;
	    $objArgs[5] += 64;
	    if($nYear < 1942) {
	      $objArgs[6] = 0;
	    }
	  }

	  return call_user_func_array("mktime", $objArgs) + $nOffset;
	}

	/**
	 * Convert negative timestamp to date
	 *
	 * @global PHPS_Database $datetime
	 * @param string $time
	 * @return string
	 */
	function MakeDate($time) {
	  global $datetime;

	  $date = Array();

	  if($time < 0) {
	    $nOffset = -2019686400;
	    $time = $time - $nOffset;
	    $date[0] = $datetime->cdate("n", $time);
	    $date[1] = $datetime->cdate("j", $time);
	    $date[2] = $datetime->cdate("Y", $time)-64;
	    $date[3] = $datetime->cdate("F", $time);
	  } else {
	    $date[0] = $datetime->cdate("n", $time);
	    $date[1] = $datetime->cdate("j", $time);
	    $date[2] = $datetime->cdate("Y", $time);
	    $date[3] = $datetime->cdate("F", $time);
	  }
	  return $date;
	}

}
