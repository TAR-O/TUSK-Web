<?php

class DB_CONNECT {


	function __construct() {
		$this -> connect();
	}

	function __destruct() {
		$this -> close();
	}

	function connect() {

		require_once __DIR__ .'/db_config.php';

		// Create connection
		$conn = new mysqli(servername, username, password, dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		return $conn;

	}

	function close() {
		
		$conn->close();
	}
}

?>