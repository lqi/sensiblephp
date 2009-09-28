<?php
class Database {
	private $host;
	private $port;
	private $user;
	private $password;
	private $dbname;
	public $dbh;
	
	function __construct() {
		$dbConf = new DbConf;
		$this->host = ($dbConf->host != null) ? $dbConf->host : "localhost";
		$this->port = ($dbConf->port != null) ? ":" . $dbConf->port : null;
		$this->user = ($dbConf->user != null) ? $dbConf->user : null;
		$this->password = ($dbConf->password != null) ? $dbConf->password : null;
		$this->dbname = ($dbConf->dbname != null) ? $dbConf->dbname : null;
		$conn = "mysql:host=" . $this->host . $this->port . ";dbname=" . $this->dbname;	
		try {
			$this->dbh = new PDO($conn, $this->user, $this->password);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
}
?>