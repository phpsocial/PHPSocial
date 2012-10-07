<?php

/**
 * Actions class is used to output and update recent activity actions.
 *
 */

class PHPS_Actions {

	/**
	 * Adds a new action
	 *
	 * @global string $database
	 * @global string $setting
	 * @param User $user
	 * @param string $actiontype_name
	 * @param string $search
	 * @param string $replace
	 * @param string $timeframe
	 */
	public function add($user, $actiontype_name, $search = "", $replace = "", $timeframe = 0) {
		global $database, $setting;
		$publish = 1;
		$nowdate = time();
		$actiontype_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_actiontypes WHERE actiontype_name='$actiontype_name' LIMIT 1"));
		$user->user_settings();
		$dontpublish_array = explode(",", $user->usersetting_info[usersetting_actions_dontpublish]);
		if($setting[setting_actions_privacy] == 1 AND in_array($actiontype_info[actiontype_id], $dontpublish_array)) {
			$publish = 0;
		}
		if($actiontype_info[actiontype_enabled] != 1) {
			$publish = 0;
		}
		if($publish == 1) {
			// delete oldest action(s) for this user if max axtions stored per user reached
			$totalactions = $database->database_num_rows($database->database_query("SELECT action_id FROM phps_actions WHERE action_user_id='".$user->user_info[user_id]."'"));
			while($totalactions >= $setting[setting_actions_actionsonprofile]) {
				$oldest_action = $database->database_fetch_assoc($database->database_query("SELECT action_id FROM phps_actions WHERE action_user_id='".$user->user_info[user_id]."' ORDER BY action_id ASC LIMIT 1"));
				$database->database_query("DELETE FROM phps_actions WHERE action_user_id='".$user->user_info[user_id]."' AND action_id='$oldest_action[action_id]' LIMIT 1");
				$totalactions--;
			}
			$text = $actiontype_info[actiontype_text];
			$replace = str_replace(Array("&amp;#039;", "&amp;quot;"), Array("'", "\""), $replace);
			$replace = array_map("htmlspecialchars", $replace);
			$text = str_replace($search, $replace, $text);
			$text = str_replace("'", "\'", $text);
			if($nowdate-$timeframe < 0) { $difference = 0; } else { $difference = $nowdate-$timeframe; }
			$prev_query = $database->database_query("SELECT action_id FROM phps_actions WHERE action_user_id='".$user->user_info[user_id]."' AND action_actiontype_id='$actiontype_info[actiontype_id]' AND action_date>'$difference' ORDER BY action_actiontype_id DESC LIMIT 1");
			if($database->database_num_rows($prev_query) == 1) {
				$prev = $database->database_fetch_assoc($prev_query);
				$update = 1;
			} else {
				$update = 0;
			}

			//update old action
			if($update == 1) {
				$database->database_query("UPDATE phps_actions SET action_date='$nowdate',
									action_subnet_id='".$user->user_info[user_subnet_id]."',
									action_icon='$actiontype_info[actiontype_icon]',
									action_text='$text'
									WHERE action_id='$prev[action_id]' AND action_user_id='".$user->user_info[user_id]."' AND action_actiontype_id='$actiontype_info[actiontype_id]'");


			}
			else {
				$database->database_query("INSERT INTO phps_actions (action_actiontype_id,
									action_date,
									action_user_id,
									action_subnet_id,
									action_icon,
									action_text) VALUES (
									'$actiontype_info[actiontype_id]',
									'$nowdate',
									'".$user->user_info[user_id]."',
									'".$user->user_info[user_subnet_id]."',
									'$actiontype_info[actiontype_icon]',
									'$text')");
			}

		}

	}

	/**
	 * Displays a list of recent updates
	 *
	 * @global string $database
	 * @global User $user
	 * @global User $owner
	 * @global string $setting
	 * @return array
	 */
	function display($filter = null) {
	  global $database, $user, $owner, $setting;
	  $nowdate = time();
	  $actions_query = "SELECT phps_actions.* FROM phps_actions";
	  if($owner->user_exists != 0) {
	    $actions_query .= " WHERE action_user_id='".$owner->user_info[user_id]."'";

	  // HIDE VIEWING USER'S ACTIONS (FOR DISPLAY ON USER HOME PAGE)
	  } else {

	    // LIMIT RESULTS TO ADMIN'S VISIBILITY SETTING
	    switch($setting[setting_actions_visibility]) {

	      // ONLY MY FRIENDS AND EVERYONE IN MY SUBNETWORK
	      case 2:
	        $actions_query .= " LEFT JOIN phps_friends ON phps_friends.friend_user_id2=phps_actions.action_user_id AND phps_friends.friend_user_id1='".$user->user_info[user_id]."' AND phps_friends.friend_status='1' WHERE (phps_friends.friend_id <> 'NULL' OR phps_actions.action_subnet_id='".$user->user_info[user_subnet_id]."') AND";
	        break;

	      // ONLY MY FRIENDS
	      case 4:
	        $actions_query .= " RIGHT JOIN phps_friends ON phps_friends.friend_user_id2=phps_actions.action_user_id AND phps_friends.friend_user_id1='".$user->user_info[user_id]."' AND phps_friends.friend_status='1' WHERE";
	        break;

	      // DEFAULT
	      default:
		$actions_query .= " WHERE";
	    }

	    // EXCLUDE OWN USER ACTIONS AND LIMIT RESULTS TO TIME PERIOD SPECIFIED BY ADMIN
	    $actions_query .= " phps_actions.action_user_id<>'".$user->user_info[user_id]."' AND phps_actions.action_date>'".($nowdate-$setting[setting_actions_showlength])."'";

	  }

      if ($filter !== null) {
          $actions_query .= " AND phps_actions.action_actiontype_id IN (".$filter.")";
      }

	  // ORDER BY ACTION ID DESCENDING
	  $actions_query .= " ORDER BY action_date DESC";

	  // LIMIT RESULTS TO MAX NUMBER SPECIFIED BY ADMIN
	  $actions_query .= " LIMIT $setting[setting_actions_actionsinlist]";

	  // GET RECENT ACTIVITY FEED
	  $actions = $database->database_query($actions_query);
	  $actions_array = Array();
	  $actions_users_array = Array();
	  $action_text = "";
	  $action_icon = "";
	  while($action = $database->database_fetch_assoc($actions)) {

	    // ONLY DISPLAY THIS ACTION IF MAX OCCURRANCES PER USER HAS NOT YET BEEN REACHED
	    if($owner->user_info[user_id] == 0) {
	      $actions_users_array[] = $action[action_user_id];
	      $occurrances = array_count_values($actions_users_array);
	    }
	    if($occurrances[$action[action_user_id]] <= $setting[setting_actions_actionsperuser]) {
	    
 	      // DECODE HTML OF ACTION STRING
	      $action_text = htmlspecialchars_decode($action[action_text], ENT_QUOTES);

	      // ADD THIS ACTION TO OUTPUT ARRAY
  	      $actions_array[] = Array('action_id' => $action[action_id],
					'action_date' => $action[action_date],
					'action_text' => $action_text,
					'action_user_id' => $action[action_user_id],
					'action_username' => $action_username_info[user_username],
					'action_icon' => $action[action_icon]);
	    }
	  }

	  // RETURN LIST OF ACTIONS
	  return $actions_array;

	} // END display() METHOD







}
?>