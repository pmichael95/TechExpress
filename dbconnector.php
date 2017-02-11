<?php 
	//DATABASE CONNECTION CLASS TO INCLUDE EVERYWHERE
	class Database {
	var $mysqli = null;
	var $number = 0;

	//Convert to escaped format
	function getEscaped($text){
		return $this->mysqli->real_escape_string($text);
	}
	//return the number of records
	function getNumRows() {
		return $this->number;
	}
	//return the ID of the last successful "insert" query
	function getLastId() {
		return $this->mysqli->insert_id;
	}
	//return the MySql version
	function getVersion() {
		return $this->mysqli->server_info; 
	}

	public function __construct(){//constructor
		$host = 'localhost'; $db = 'techexpress';
		$user = 'techexpress'; $pass = 'lamepassword';
		$this->mysqli = new mysqli($host, $user, $pass, $db); //connect to DBMS
		if ($this->mysqli->connect_error) { die('Connection error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error); }
		$this->mysqli->set_charset("utf8"); //everything utf-8
	}

	function __destruct() {
		if ($this->mysqli != null)
		$this->mysqli->close(); //close the connection
	}

	public function query($sql = '') {
		if(empty($sql)) return false;
			$array = array(); $this->number = 0;
			$cursor = $this->mysqli->query($sql); //get query result
			if ($cursor == false) return false;
				//assign the rows to array elements to allow direct indexing
				while($row = $cursor->fetch_assoc()) {
					foreach($row as $key=>$value) $row[$key] = stripslashes($value); //unescape
					$array[] = $row;
					$this->number = $this->number + 1;
				}
			$cursor ->free();
		return $array;
		}

		public function modify($sql = '') {
		if(empty($sql)) return false;
			$this->mysqli->query($sql);
		}
	}
?>