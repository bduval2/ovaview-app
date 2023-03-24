<?php
// Source code: https://gist.github.com/jonashansen229/4534794
class Database {
	private $_connection;
	private static $_instance; // Singleton

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// Constructor
	private function __construct() {
		
        $this-> _connection = new PDO('sqlite:database/periodTracking.db');
        if ($this-> _connection != null) {
            echo 'Successfully connected to the SQLite database.';
            echo "<br>";
        }
        else {
            echo 'Could not connect to the SQLite database.';
        }
	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}
?>