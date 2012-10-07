<?php

/**
 * Class for Ad campaign banners
 * 
 */

class PHPS_Ads {

	/**
	 * Page to banner html
	 * 
	 * @var string
	 */
	public $ad_top;

	/**
	 * Below banner html
	 * 
	 * @var string
	 */
	public $ad_belowmenu;

	/**
	 * Leftside banner html
	 * 
	 * @var html
	 */
	public $ad_left;

	/**
	 * Right side banner html
	 * 
	 * @var string
	 */
	public $ad_right;

	/**
	 * Page bottom banner html
	 * 
	 * @var string
	 */
	public $ad_bottom;

	/**
	 * Custom banner html
	 * 
	 * @var array
	 */
	public $ad_custom;


	public function  __construct() {
	  global $database, $datetime, $setting, $user, $page, $pluginname;

	  // get current time in admin's timezone
	  $nowtime = $datetime->timezone(time(), $setting[setting_timezone]);

	  // ad query
	  $ad_querystring = "SELECT ad_id, ad_position, ad_html FROM phps_ads WHERE ad_date_start<'$nowtime' AND (ad_date_end>'$nowtime' OR ad_date_end='0')";

	  // make sure the ad is not paused
	  $ad_querystring .= " AND ad_paused!='1'";

	  // ad not reached its view limits
	  $ad_querystring .= " AND (ad_limit_views=0 OR ad_limit_views>ad_total_views)";

	  // ad has not reached its click limits
	  $ad_querystring .= " AND (ad_limit_clicks=0 OR ad_limit_clicks>ad_total_clicks)";

	  // ad has not reached its ctr limits
          $ad_querystring .= " AND (ad_limit_ctr=0 OR ad_limit_ctr<(ad_total_clicks/(ad_total_views+1))*100)";

	  // if viewer is not logged in show only public campigns
          if($user->user_exists == 0) {
	    $ad_querystring .= " AND ad_public='1'";

	  } else { 
	    $level_id = $user->level_info[level_id];
	    $subnet_id = $user->subnet_info[subnet_id];
	    $ad_querystring .= " AND (ad_levels LIKE '%,$level_id,%' AND ad_subnets LIKE '%,$subnet_id,%')";
	  }

	  // randomize query results
	  $ad_querystring .= " ORDER BY RAND()";

	  // wich ads should be shown
	  $ad_query = $database->database_query($ad_querystring);

	  // prepare stat update query
	  $stats_string = "";

	  // ad html for each position
	  while($ad_info = $database->database_fetch_assoc($ad_query)) {

	    $ad_info[ad_html] = htmlspecialchars_decode($ad_info[ad_html], ENT_QUOTES);
	    $ad_info[ad_html] = "<div onClick=\"document.getElementById('doclickimage$ad_info[ad_id]').src='Ad.php?ad_id=$ad_info[ad_id]';\">$ad_info[ad_html]<img src='images/trans.gif' border='0' id='doclickimage$ad_info[ad_id]' style='display: none;'></div>";

	    $this->ad_custom[$ad_info[ad_id]] = $ad_info[ad_html];

	    if($ad_info[ad_position] == "top" AND $this->ad_top == "") {
	        $this->ad_top = $ad_info[ad_html];
	        if($stats_string != "") { $stats_string .= " OR"; }
		$stats_string .= " ad_id=$ad_info[ad_id]";
	    }
	    elseif($ad_info[ad_position] == "belowmenu" AND $this->ad_belowmenu == "") {
	        $this->ad_belowmenu = $ad_info[ad_html];
	        if($stats_string != "") { $stats_string .= " OR"; }
		$stats_string .= " ad_id=$ad_info[ad_id]";
	    }
	    elseif($ad_info[ad_position] == "left" AND $this->ad_left == "") {
	        $this->ad_left = $ad_info[ad_html];
	        if($stats_string != "") { $stats_string .= " OR"; }
		$stats_string .= " ad_id=$ad_info[ad_id]";
	    }
	    elseif($ad_info[ad_position] == "right" AND $this->ad_right == "") {
	        $this->ad_right = $ad_info[ad_html];
	        if($stats_string != "") { $stats_string .= " OR"; }
		$stats_string .= " ad_id=$ad_info[ad_id]";
	    }
	    elseif($ad_info[ad_position] == "bottom" AND $this->ad_bottom == "") {
	        $this->ad_bottom = $ad_info[ad_html];
	        if($stats_string != "") { $stats_string .= " OR"; }
		$stats_string .= " ad_id=$ad_info[ad_id]";
	    }

	  }

	  // update the ads view stats
	  if($stats_string != "") {
		   if(
		      $page != 'Chat'
		      && $page != 'ProfileEventCalendar'
		      && $page != 'ChatFrame'
		      && $page != 'UserEvent' 
		      ){
		     $database->database_query("UPDATE phps_ads SET ad_total_views=ad_total_views+1 WHERE ".$stats_string);
		   }
		}

	}

	/**
	 * Display the custom ads
	 *
	 * @global PHPS_Database $database
	 * @param integer $ad_id
	 * @return array
	 */
	function ads_display($ad_id) {
	  global $database;

	  // update the ads view stat
          $database->database_query("UPDATE phps_ads SET ad_total_views=ad_total_views+1 WHERE ad_id=$ad_id");
	  
	  // display ads
	  return $this->ad_custom[$ad_id];

	} 
}
