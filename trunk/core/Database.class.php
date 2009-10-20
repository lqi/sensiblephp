<?php
class Database {
	private $host;
	private $port;
	private $user;
	private $password;
	private $dbname;
	private $dbh;
	
	function Database() {
		$dbConf = new DbConf;
		$this->host = ($dbConf->host != null) ? $dbConf->host : "localhost";
		$this->port = ($dbConf->port != null) ? ":" . $dbConf->port : null;
		$this->user = ($dbConf->user != null) ? $dbConf->user : null;
		$this->password = ($dbConf->password != null) ? $dbConf->password : null;
		$this->dbname = ($dbConf->dbname != null) ? $dbConf->dbname : null;
		$this->connection();
	}
	
	function connection() {
		$conn = "mysql:host=" . $this->host . $this->port . ";dbname=" . $this->dbname;	
		try {
			$this->setDbConnection(new PDO($conn, $this->user, $this->password));
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
	
	function db() {
		return $this->dbh;
	}
	
	function setDbConnection($dbh) {
		$this->dbh = $dbh;
	}
	
	function valueObject($array) {
		return $this->getValueObjectFromPDOResultRowArray($array);
	}
	
	private function getValueObjectFromPDOResultRowArray($array) {
		$model = substr(get_class($this), 0, -2);
		$valueObject = new $model;
		foreach($array as $key=>$value) {
			if (is_int($key))
				continue;
			if ($valueObject->$key->getFieldType() == "IntegerField") {
				$valueObject->$key->setValue((int) $value);
				continue;
			}
			if ($valueObject->$key->getFieldType() == "StringField" ||
				$valueObject->$key->getFieldType() == "TextField") {
					$valueObject->$key->setValue($value);
					continue;
			}
			if ($valueObject->$key->getFieldType() == "DateField") {
				$year = substr($value, 0, 4);
				$month = substr($value, 5, 2);
				$day = substr($value, 8, 2);
				$valueObject->$key->setValue($year, $month, $day);
				continue;
			}
			if ($valueObject->$key->getFieldType() == "TimeField") {
				$hour = substr($value, 0, 2);
				$minute = substr($value, 3, 2);
				$second = substr($value, 6, 2);
				$valueObject->$key->setValue($hour, $minute, $second);
				continue;
			}
			if ($valueObject->$key->getFieldType() == "DatetimeField") {
				$year = substr($value, 0, 4);
				$month = substr($value, 5, 2);
				$day = substr($value, 8, 2);
				$hour = substr($value, 11, 2);
				$minute = substr($value, 14, 2);
				$second = substr($value, 17, 2);
				$valueObject->$key->setValue($year, $month, $day, $hour, $minute, $second);
				continue;
			}
		}
		return $valueObject;
	}
	
	function query($statement) {
		return $this->db()->query($statement);
	}
	
	function execute($statement) {
		return $this->db()->exec($statement);
	}
	
	function getTableName() {
		return strtolower(substr(get_class($this), 0, -2));
	}
	
	function getPKName() {
		$sql = "DESCRIBE `" . $this->getTableName() . "`";
		$rs = $this->query($sql)->fetchAll();
		foreach($rs as $row) {
			if($row["Key"] == "PRI") {
				return $row["Field"];
			}
		}
		throw Exception ("Exception: No Primary Key found!");
	}
	
	function all() {
		$sql = "SELECT * FROM `" . $this->getTableName() . "` ORDER BY `" . $this->getPKName() . "` DESC";
		$array = array();
		foreach($this->query($sql) as $row) {
			$array[] = $this->valueObject($row);
		}
		return $array;
	}
	
	function get($pk) {
		$sql = "SELECT * FROM `" . $this->getTableName() . "` ORDER BY `" . $this->getPKName() . "` = " . $pk;
		foreach($this->query($sql) as $row) {
			$array = $this->valueObject($row);
		}
		return $array;
	}
	
	function filter($left = -1, $right = -1) { // Thinking about how to rename these two
		if ($left <= -1 && $right <= -1)
			return $this->all();
		elseif ($left > -1 && $right <= -1) {
			if (!is_int($left))
				throw new Exception("Exception: Filter length must be an integer!");
			$start = 0;
			$length = $left;
		}
		elseif ($left > -1 && $right > -1) {
			if (!(is_int($left)&&is_int($right)))
				throw new Exception("Exception: Filter start point and length must be integer!");
			$start = $left;
			$length = $right;
		}
		else {
			throw new Exception("Exception: Unhandled exception!");
			// TODO!!!
		}
		$sql = "SELECT * FROM `" . $this->getTableName() . "` ORDER BY `" . $this->getPKName() . "` DESC LIMIT " . $start . ", " . $length;
		$array = array();
		foreach($this->query($sql) as $row) {
			$array[] = $this->valueObject($row);
		}
		return $array;
	}
	
	function rm($pk) {
		$sql = "DELETE FROM `" . $this->getTableName() . "` WHERE `" . $this->getPKName() . "`=" . $pk;
		$rs = $this->execute($sql);
		return $rs;
	}
	
	function create($confirmMessage = null) {
		if ($confirmMessage == null) {
			throw new Exception("Exception: `CREATE TABLE` confirm Message needed!");
		}
		if ($confirmMessage == "CREATE") {
			return "SUCCESS";
		}
		throw new Exception("Exception: Illigal `CREATE TABLE` confirm message!");
	}
	
	function drop($confirmMessage = null) {
		if ($confirmMessage == null) {
			throw new Exception("Exception: `DROP TABLE` confirm Message needed!");
		}
		if ($confirmMessage == "DROP") {
			return "SUCCESS";
		}
		throw new Exception("Exception: Illigal `DROP TABLE` confirm message!");
	}
	
	function save() {
		//
	}
}
?>