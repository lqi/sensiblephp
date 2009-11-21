<?php
abstract class Database {
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
	
	private function connection() {
		$conn = "mysql:host=" . $this->host . $this->port . ";dbname=" . $this->dbname;	
		try {
			$this->setDbConnection(new PDO($conn, $this->user, $this->password));
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
	
	private function db() {
		return $this->dbh;
	}
	
	private function setDbConnection($dbh) {
		$this->dbh = $dbh;
	}
	
	private function valueObject($array) {
		return $this->getValueObjectFromPDOResultRowArray($array);
	}
	
	private function getModelName() {
		return substr(get_class($this), 0, -2);
	}

	private function getTableName() {
		return strtolower($this->getModelName());
	}
	
	private function getValueObjectFromPDOResultRowArray($array) { //need refactor
		$model = $this->getModelName();
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
	
	private function query($statement) {
		return $this->db()->query($statement);
	}
	
	private function execute($statement) {
		return $this->db()->exec($statement);
	}
	
	private function getPKName() {
		$sql = "DESCRIBE `" . $this->getTableName() . "`";
		$rs = $this->query($sql)->fetchAll();
		foreach($rs as $row) {
			if($row["Key"] == "PRI") {
				return $row["Field"];
			}
		}
		throw Exception ("Exception: No Primary Key found!");
	}
	
	function select($statement = null) {
		$sql = "SELECT * FROM `" . $this->getTableName() . "`";
		if ($statement != null) {
			$sql = $sql . " " . $statement;
		}
		$array = array();
		foreach($this->query($sql) as $row) {
			$array[] = $this->valueObject($row);
		}
		return $array;
	}
	
	function all() {
		return $this->select("ORDER BY `" . $this->getPKName() . "` DESC");
	}
	
	function get($pk) {
		$array = $this->select("WHERE `" . $this->getPKName() . "` = " . $pk);
		return $array[0];
	}
	
	function filter($left = null, $right = null) { // Thinking about how to rename these two
		if ($left == null && $right == null)
			return $this->all();
		elseif ($left != null && $right == null) {
			if (!is_int($left))
				throw new Exception("Exception: Filter length must be an integer!");
			$start = 0;
			$length = $left;
		}
		elseif ($left != null && $right != null) {
			if (!(is_int($left)&&is_int($right)))
				throw new Exception("Exception: Filter start point and length must be integer!");
			$start = $left;
			$length = $right;
		}
		else {
			throw new Exception("Exception: Unhandled exception!");
		}
		return $this->select("ORDER BY `" . $this->getPKName() . "` DESC LIMIT " . $start . ", " . $length);
	}
	
	function delete($statement = null) {
		if ($statement == null) {
			$statement = "";
		}
		return $this->execute("DELETE FROM `" . $this->getTableName() . "` " . $statement);
	}
	
	function rm($pk) {
		return $this->delete("WHERE `" . $this->getPKName() . "`=" . $pk);
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
	
	function save($model) {
		if ($model->pk->getValue() == null) { // insert new item
			$keyString = "";
			$valueString = "";
			foreach($model->getVarsWithoutPK() as $attribute) {
				$keyString = $keyString . "`" . $attribute . "`, ";
				$valueString = $valueString . "'" . $model->$attribute->getValue() . "', ";
			}
			$keyString = substr($keyString, 0, -2);
			$valueString = substr($valueString, 0, -2);
			$sql = "INSERT INTO `" . $model->getTableName() . "` (" . $keyString . ") " .
				   "VALUES (" . $valueString . ")";
			if ($this->execute($sql)) {
				return true;
			}
		}
		else { // update current item
			$setString = "";
			foreach($model->getVarsWithoutPK() as $attribute) {
				$setString = $setString . "`" . $attribute . "` = '" . $model->$attribute->getValue() . "', ";
			}
			$setString = substr($setString, 0, -2);
			$sql = "UPDATE `" . $model->getTableName() . "` SET " . $setString . 
					" WHERE `" . $model->getPKField() . "`=" . $model->pk->getValue();
			if ($this->execute($sql)) {
				return true;
			}
		}
		throw new Exception("Exception: Error in saving item.");
	}
}
?>