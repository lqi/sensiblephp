<?php
class DbConf {
	private $host = "localhost";
	private $port = "";
	private $user = "root";
	private $password = "root";
	private $dbname = "sensible";
	
	public function __get($key) {
		return $this->$key;
	}
}
?>