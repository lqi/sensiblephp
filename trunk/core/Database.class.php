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
		$conn = "mysql:host=" . $this->host . $this->port . ";dbname=" . $this->dbname;	
		try {
			$this->dbh = new PDO($conn, $this->user, $this->password);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
	
	function db() {
		return $this->dbh;
	}
	
	function valueObject($row) {
		return $this->getValueObjectFromPDOResultRowArray($row);
	}
	
	private function getValueObjectFromPDOResultRowArray($row) {
		$model = substr(get_class($this), 0, -2);
		$valueObject = new $model;
		foreach($row as $key=>$value) {
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
}
?>