<?php
class Settings {
	/*
		General Settings
	*/
	private $debug = true;		//Debug model, choose true or false
	private $timezone = "";		//Leave blank for "America/Los_Angeles"

	/*
		Database Settings
	*/
	private $host = "localhost";		//Host of Database, leave blank for "localhost"
	private $port = "";		//Port of Database, leave blank for null
	private $user = "root";		//Username of Database, leave blank for null
	private $password = "root";		//Password of Database, leave blank for null
	private $dbname = "tmp2opts";		//Database name, leave blank for null

	/*
		Don't modify anything below
	*/
	public function __get($key) {
		return $this->$key;
	}
}
?>
