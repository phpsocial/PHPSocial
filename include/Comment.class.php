<?php
/**
 * Comments class.
 * 
 */

class PHPS_Comment {

	/**
	 * Error flag
	 * 
	 * @var boolean
	 */
	public $is_error;

	/**
	 * Error message
	 * 
	 * @var string
	 */
	public $error_message;

	/**
	 * Contains the prefix corresponding to the comment type (ex: profile for phps_profilecomments)
	 * 
	 * @var string
	 */
	public $comment_type;

	/**
	 * Contains the identifying column in the table (ex: user_id for phps_profilecomments)
	 * 
	 * @var string
	 */
	public $comment_identifier;	// CONTAINS THE IDENTIFYING COLUMN IN THE TABLE (EX: USER_ID FOR phps_profilecomments)

	/**
	 * Contains the value to match to the identifier
	 * 
	 * @var string
	 */
	public $comment_identifying_value;	// CONTAINS THE VALUE TO MATCH TO THE IDENTIFIER

	
	public function  __construct($type, $identifier, $identifying_value) {
	  $this->comment_type = $type;
	  $this->comment_identifier = $identifier;
	  $this->comment_identifying_value = $identifying_value;
	}

	/**
	 * Return total number of comments
	 *
	 * @global PHPS_Database $database
	 * @return integer
	 */
	public function comment_total() {
	  global $database;

	  $comment_query = "SELECT ".$this->comment_type."comment_id FROM phps_".$this->comment_type."comments WHERE ".$this->comment_type."comment_".$this->comment_identifier."='".$this->comment_identifying_value."'";
	  $comments_total = $database->database_num_rows($database->database_query($comment_query));

	  return $comments_total;

	}

	/**
	 * Get comment info
	 *
	 * @global PHPS_Database $database
	 * @param integer $start
	 * @param integer $limit
	 * @return array
	 */
	function comment_list($start, $limit) {
	  global $database;

	  $comment_array = Array();
	  $comment_query = "SELECT phps_".$this->comment_type."comments.*, phps_users.user_id, phps_users.user_username, phps_users.user_photo FROM phps_".$this->comment_type."comments LEFT JOIN phps_users ON phps_".$this->comment_type."comments.".$this->comment_type."comment_authoruser_id=phps_users.user_id WHERE ".$this->comment_type."comment_".$this->comment_identifier."='".$this->comment_identifying_value."' ORDER BY ".$this->comment_type."comment_id DESC LIMIT $start, $limit";
	  $comments = $database->database_query($comment_query);
	  while($comment_info = $database->database_fetch_assoc($comments)) {

	    // create an object for comment
	    $author = new PHPS_User();
	    $author->user_info[user_id] = $comment_info[user_id];
	    $author->user_info[user_username] = $comment_info[user_username];
	    $author->user_info[user_photo] = $comment_info[user_photo];

	    // set comments array
	    $comment_array[] = Array('comment_id' => $comment_info[$this->comment_type.'comment_id'],
					'comment_author' => $author,
					'comment_date' => $comment_info[$this->comment_type.'comment_date'],
					'comment_body' => $comment_info[$this->comment_type.'comment_body']);
	  }

	  return $comment_array;

	}

	/**
	 * Post a comment
	 *
	 * @global PHPS_Database $database
	 */
	function comment_post() {
	  global $database;

	}

	/**
	 * Delte a single comment
	 *
	 * @global PHPS_Database $database
	 * @param integer $comment_id
	 */
	function comment_delete($comment_id) {
	  global $database;
	} 

	/**
	 * Delet many comments
	 *
	 * @global PHPS_Database $database
	 * @param integer $start
	 * @param integer $limit
	 */
	function comment_delete_selected($start, $limit) {
	  global $database;

	  $delete_query = "";
	  $comment_query = "SELECT phps_".$this->comment_type."comments.".$this->comment_type."comment_id FROM phps_".$this->comment_type."comments WHERE ".$this->comment_type."comment_".$this->comment_identifier."='".$this->comment_identifying_value."' ORDER BY ".$this->comment_type."comment_id DESC LIMIT $start, $limit";
	  $comments = $database->database_query($comment_query);
	  while($comment_info = $database->database_fetch_assoc($comments)) {
	    $var = "comment_".$comment_info[$this->comment_type.'comment_id'];

	    if($_POST[$var] == 1) {
	      if($delete_query != "") { $delete_query .= " OR "; }
	      $delete_query .= $this->comment_type."comment_id='".$comment_info[$this->comment_type.'comment_id']."'";
	    }
	  }

	  if($delete_query != "") { $database->database_query("DELETE FROM phps_".$this->comment_type."comments WHERE $delete_query"); }

	}

}