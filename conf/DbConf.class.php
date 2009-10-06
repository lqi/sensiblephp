<?php
class DbConf {
	private $host = "fazey.org";
	private $port = "";
	private $user = "cents";
	private $password = "pl0x88!";
	private $dbname = "cents";
	
	public function __get($key) {
		return $this->$key;
	}
}
?>
