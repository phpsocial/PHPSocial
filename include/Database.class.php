<?php
/**
 * Database class.
 *
 */

class PHPS_Database {

	/**
	 * database link identifier
	 *
	 * @var mysql
	 */
	public $database_connection;

	/**
	 * Query logged flag
	 *
	 * @var boolean
	 */
	public $log_stats;

	/**
	 * Query run info
	 *
	 * @var array
	 */
	public $query_stats;


	function  __construct($database_host, $database_username, $database_password, $database_name) {
	  $this->database_connection = $this->database_connect($database_host, $database_username, $database_password);
	  $this->database_select($database_name);
	
	  $this->log_stats = 1;
	  $this->query_stats = array();

	} 

	/**
	 * Connect to database
	 *
	 * @param string $database_host
	 * @param string $database_username
	 * @param string $database_password
	 * @return mysql_connection link
	 */
	public function database_connect($database_host, $database_username, $database_password) {
		if ($c = mysql_connect($database_host, $database_username, $database_password, TRUE)) {
		    return $c;
		} else {
		    if (file_exists(dirname(__FILE__) . "/../Install.php")) {
		        header("location: Install.php"); die();
		    } else {
		        echo "Database connection error"; die();
		    }
		}
	}

	/**
	 * select a db
	 *
	 * @param string $database_name
	 * @return mysql link
	 */
	public function database_select($database_name) {

	  return mysql_select_db($database_name, $this->database_connection);

	}

	/**
	 * Make query to the database
	 *
	 * @param string $database_query
	 * @return mixed
	 */
	public function database_query($database_query) {
	  $query_timer_start = getmicrotime();
	  $query_result = mysql_query($database_query, $this->database_connection); 
	  
	  if($this->log_stats != 0) {
	    $query_time = round(getmicrotime()-$query_timer_start, 5);
	    $this->query_stats[] = Array('query' => $database_query,
					'time' => $query_time);
	  }

	  return $query_result;

	}

    /**
     * Executes query and returns query result
     *
     * @param string $query   SQL query text
     *          bool $get_errors (optional)   show SQL errors? FALSE by default
     * @access public
     * @return bool
     */
    public function get_one($query) {
        if (!($res = mysql_query($query)) and $this->get_errors){
            echo "Database error: ".mysql_error()."<br/>In query: ".$query;
        }
        $row  = @mysql_fetch_row($res);
        $keys = @array_keys($row);
        return $row[$keys[0]];
    }

    /**
     * Executes query and returns query result (row, array)
     *
     * @param string $query   SQL query text
     *          bool $get_errors (optional)   show SQL errors? FALSE by default
     * @access public
     * @return array
     */
    public function get_row($query) {
        if (!strstr(strtoupper($query), "LIMIT")) $query .= " LIMIT 0,1";
        if (!($res = mysql_query($query)) and $this->get_errors){
            echo "Database error: ".mysql_error()."<br/>In query: ".$query;
        }
        return @mysql_fetch_assoc($res);
    }

    /**
     * Executes query and returns query result (table, array of array)
     *
     * @param string $query   SQL query text
     *          bool $get_errors (optional)   show SQL errors? FALSE by default
     * @access public
     * @return bool
     */
    public function get_all($query) {
        if (!($res = mysql_query($query)) and $this->get_errors){
            echo "Database error: ".mysql_error()."<br/>In query: ".$query;
        }
        while ($result[] = @mysql_fetch_assoc($res)) {}
        $result = array_slice($result, 0, count($result)-1);
        return $result;
    }

    /**
     * Executes query and returns query result (column, array)
     *
     * @param string $query   SQL query text
     *          bool $get_errors (optional)   show SQL errors? FALSE by default
     * @access public
     * @return bool
     */
    public function get_col($query) {
        if (!($res = mysql_query($query)) and $this->get_errors){
            echo "Database error: ".mysql_error()."<br/>In query: ".$query;
        }
        while ($table[] = @mysql_fetch_assoc($res)) {}
        $table  = array_slice($table, 0, count($table)-1);
        $result = array();
        foreach ($table as $row){
            $keys = array_keys($row);
            $key  = $keys[0];
            unset($keys);
            $result[] = $row[$key];
        }
        return $result;
    }  

	/**
	 * Fetch row as numeric array
	 *
	 * @param mixed $database_result
	 * @return array
	 */
	public function database_fetch_array($database_result) {

	  return mysql_fetch_array($database_result);

	}

	/**
	 * Fetch row as associative array
	 *
	 * @param mixed $database_result
	 * @return array
	 */
	function database_fetch_assoc($database_result) {

	  return mysql_fetch_assoc($database_result);

	}

	/**
	 * Returns number of rows in the result
	 *
	 * @param mixed $database_result
	 * @return integer
	 */
	function database_num_rows($database_result) {

	  return mysql_num_rows($database_result);

	} 

	/**
	 * Returns number of rows in the result
	 *
	 * @param mixed $database_result
	 * @return integer
	 */
	function database_affected_rows($database_result) {

	  return mysql_affected_rows($database_result);

	}

	/**
	 * Returns the last inserted id
	 *
	 * @return integer
	 */
	function database_insert_id() {

	  return mysql_insert_id($this->database_connection);

	}

	/**
	 * Get db error
	 *
	 * @return string
	 */
	function database_error() {

	  return mysql_error($this->database_connection);

	}

	/**
	 * Close db connection
	 * 
	 */
	function database_close() {
	  mysql_close($this->database_connection);
	} 



}
?>