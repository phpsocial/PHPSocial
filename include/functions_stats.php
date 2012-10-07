<?php
/**
 * Stat related functions
 *
 */

/**
 * Updates the last row of the stat table
 *
 * @global PHPS_Database $database
 * @param mixed $type
 */
function update_stats($type) {
	global $database;

	// increase requested stat value
	$database->database_query("INSERT INTO phps_stats (stat_date, stat_$type) VALUES (UNIX_TIMESTAMP(CURDATE()), 1) 
					ON DUPLICATE KEY UPDATE stat_$type = stat_$type+1");

}


/**
 * Gets the current viewer's reffering url and adds it to ref url stats table
 *
 * @global PHPS_Database $database
 * @return mixed
 */
function update_refurls() {
	global $database;

	// IF URL IS NOT EMPTY
	$referring_url = $_SERVER["HTTP_REFERER"];
	if(strpos(strtolower($referring_url), strtolower($_SERVER["HTTP_HOST"])) !== FALSE) { return; }

	if($referring_url != "") {

	  // IS URL ALREADY IN DATABASE? IF YES, ADD TO HITS. IF NO, ADD NEW ROW
	  $referring_url = str_replace("http://www.", "http://", $referring_url);
	  $database->database_query("INSERT INTO phps_statrefs (statref_hits, statref_url) VALUES ('1', '$referring_url')
					ON DUPLICATE KEY UPDATE statref_hits=statref_hits+1");

	  // IF 1000 ROWS REACHED, DELETE ONE TO MAKE ROOM
	  $refurl_totalrows = $database->database_num_rows($database->database_query("SELECT statref_id FROM phps_statrefs"));
	  if($refurl_totalrows >= 1000) { $database->database_query("DELETE FROM phps_statrefs WHERE statref_hits='1' ORDER BY statref_id ASC LIMIT 1"); }
	}

}
?>