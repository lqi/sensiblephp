<?php
class Database {
	private $host;# = (isset($dbConf->host)) ? $dbConf->host : "localhost";
	private $port;# = (isset($dbConf->port)) ? $dbConf->port : "3306";
	private $user;# = (isset($dbConf->user)) ? $dbConf->port : null;
	private $password;# = (isset($dbConf->password)) ? $dbConf->password : null;
	private $dbname;# = (isset($dbConf->dbname)) ? $dbConf->dbname : null;
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