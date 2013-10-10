<?php

/**
 *
 * @author Stef
 */
class Database {

	// Variables
	var $result;
	var $lastError;
	var $lastQuery;
	var $records;
	var $affected;
	var $arrayedResult;
	var $rawResult;
	var $tableName;

	// SQL variables
	var $hostname = 'localhost'; // hostname
	var $username = 'root';	// username
	var $password = '1234'; // password
	var $database = 'test_db'; //database name
	var $databaseLink; // database link

	/**
	 * Class Constructor
	 */
	function db($database, $username, $password, $hostname) {
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->hostname = $hostname;

		// establish connection
		$this->Connect();
	}

	/**
	 * Private functions
	 */
	private function Connect() {
		$this->databaseLink = mysql_connect($this->hostname, $this->username, $this->password);

		if(!$this->databaseLink) {
			$this->lastError = 'Could not connect to server : '.mysql_error( $this->databaseLink );
			return false;
		}


		if (! $this->useDB ()) {
			$this->lastError = 'could not connect to database  '.mysql_error( $this->databaseLink );
			return false;
		}
		echo "Connection established.";
		return true;
	}

	// select the database to use
	private function useDB() {
		if (! mysql_select_db ( $this->database, $this->databaseLink )) {
			$this->lastError = 'Cannot select database: ' . mysql_error ( $this->databaseLink );
			return false;
		} else {
			return true;
		}
	}

	// this bit perform a 'mysql_real_escape_string' on the entire array/string
	private function SecureData($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $val ) {
				if (! is_array ( $data[$key] )) {
					$data[$key] = mysql_real_escape_string ( $data[$key], $this->databaseLink );
				}
			}
		} else {
			$data = mysql_real_escape_string ( $data, $this->databaseLink );
		}
		return $data;
	}

	/**
	 * here we go
	 * Public Functions
	 */
	// Executes MySQL query
	function ExecuteSQL($query) {
		$this->lastQuery = $query;
		if ($this->result == mysql_query($query, $this->databaseLink))
		{
			$this->records = @mysql_num_rows ( $this->result );
			$this->affected = @mysql_affected_rows ( $this->databaseLink );

			if ($this->records > 0) {
				$this->ArrayResults ();
				return $this->arrayedResult;
			} else {
				return true;
			}
		} else {
			$this->lastError = mysql_error ( $this->databaseLink );
			return false;
		}
	}

	// insert
	function Insert($vars, $table, $exclude='') {

		// Catch Exclusions
		if($exclude == ''){
			$exclude = array();
		}

		array_push($exclude, 'MAX_FILE_SIZE');

		// prep variables
		$vars = $this->SecureData ( $vars, $exclude );

		// query
		$query = "INSERT INTO `{$table}` SET ";
		foreach ( $vars as $key => $value ) {
			if (in_array ( $key )) {
				continue;
			}
			$query .= "`{$key}` = '{$value}', ";
		}
		$query = substr ( $query, 0, - 2 );
		return $this->ExecuteSQL ( $query );
	}

	// delete function
	function Delete($table, $where = '', $limit = '') {
		$query = "DELETE FROM `{$table}` WHERE ";
		if (is_array ( $where ) && $where != '') {
			// prep variables
			$where = $this->SecureData ( $where );

			foreach ( $where as $key => $value ) {
				$query .="`{$key}` = '{$value}' AND ";
			}
			$query = substr ( $query, 0, - 5 );
		}

		if ($limit != '') {
			$query .=' LIMIT ' . $limit;
		}

		return $this->ExecuteSQL ( $query );
	}

	//select
	function Select($from, $where='', $orderBy='', $limit='', $like=false, $operand='AND', $cols='*')
	{
		if (trim($from) == '') {
			return false;
		}

		$query = "SELECT {$cols} FROM `{$from}` WHERE ";

		if(is_array($where) && $where != '')
		{
			// prep variables/ sec data
			$where = $this->SecureData($where);

			foreach ($where as $key => $value)
			{
				if ($like){
					$query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
				}
				else
				{
					$query .= "`{$key}`='{$value}' {$operand} ";
				}
			}

			$query = substr ($query, 0, -(strlen($operand)+2));
		}
		else
		{
			$query = substr($query, 0, -7);
		}

		if ($orderBy != '')
		{
			$query .=' ORDER BY ' . $orderBy;
		}

		if ($limit != '')
		{
			$query .=' LIMIT '. $limit;
		}

		return $this->ExecuteSQL($query);
	}

	function Update ($table, $set, $where, $exclude = '')
	{
		//catch excep
		if (trim($table) == '' || !is_array($set) || !is_array($where))
		{
			return false;
		}
		if ($exclude == '')
		{
			$exclude = array();
		}

		$set = $this->SecureData($set);
		$where = $this->SecureData($set);

		//Set
		$query = "UPDATE `{$table}` SET ";
		foreach ($set as $key=>$value)
		{
			if (in_array($key, $exclude))
			{
				continue;
			}
			$query .="`{$key}` = '{$value}', ";
		}

		$query = substr($query, 0, -2);

		//Where

		$query .=" WHERE ";
		foreach ($where as $key=>$value)
		{
			$query .="`{$key}` = '{$value}' AND ";
		}

		$query = substr($query, 0, -5);

		return $this->ExecuteSQL($query);
	}

	//arrays a single result
	function ArrayResult()
	{
		$this->arrayedResult = mysql_fetch_assoc($this->result) or die (mysql_error($this->databaseLink));
		return $this->arrayedResult;
	}
	// arrays multiple results
	function ArrayResults()
	{
		if ($this->records == 1){
			return $this->ArrayResult();
		}
		$this->arrayedResult = array();

// 		while ($data = mysql_fetch_assoc($this->result))
// 		{
// 			$this->arrayedResult[] = $data;
// 		}

		return $this->arrayedResult;
	}

	// returns the last inserted ID
	function LastInsertID(){
		return mysql_insert_id();
	}

	// count the rows
	function CountRows ($from, $where= '')
	{
		$result = $this->Select($from, $where, '', '', false, 'AND', 'count(*)');
		return $result["count(*)"];
	}

	function Join()
	{

	}



	//closing the connection to the database
	function CloseConnection()
	{
		if ($this->databaseLink)
		{
			mysql_close($this->databaseLink);
		}
	}

}