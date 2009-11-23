<?php
abstract class Database {
	private $host;
	private $port;
	private $user;
	private $password;
	private $dbname;
	private $dbh;
	
	function Database() {
		$dbConf = new Settings;
		$this->host = ($dbConf->host != null) ? $dbConf->host : "localhost";
		$this->port = ($dbConf->port != null) ? ":" . $dbConf->port : null;
		$this->user = ($dbConf->user != null) ? $dbConf->user : null;
		$this->password = ($dbConf->password != null) ? $dbConf->password : null;
		$this->dbname = ($dbConf->dbname != null) ? $dbConf->dbname : null;
		$this->connection();
	}
	
	protected function connection() {
		$conn = "mysql:host=" . $this->host . $this->port . ";dbname=" . $this->dbname;
		try {
			$this->setDbConnection(new PDO($conn, $this->user, $this->password));
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
	
	protected function db() {
		return $this->dbh;
	}
	
	protected function setDbConnection($dbh) {
		$this->dbh = $dbh;
	}
	
	protected function valueObject($array) {
		$model = $this->getModelName();
		$valueObject = new $model;
		foreach($array as $key=>$value) {
			if (is_int($key))
				continue;
			$valueObject->$key->processingPDOValue($value);
		}
		return $valueObject;
	}
	
	protected function getModelName() {
		return substr(get_class($this), 0, -2);
	}

	protected function getTableName() {
		return strtolower($this->getModelName());
	}
	
	protected function query($statement) {
		return $this->db()->query($statement);
	}
	
	protected function execute($statement) {
		return $this->db()->exec($statement);
	}
	
	protected function getPKName() {
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
	
	function createTableSqlStmt() {
		$modelName = $this->getModelName();
		$model = new $modelName;
		$sqlStmt = "CREATE TABLE `" . $this->getTableName() . "` (";
		$pkName = $model->getPKField();
		$sqlStmt = $sqlStmt . "`" . $pkName . "` " . $model->$pkName->createTableSqlStmt() . " AUTO_INCREMENT,";
		foreach($model->getVarsWithoutPK() as $attribute) {
			$sqlStmt = $sqlStmt . "`" . $attribute . "` " . $model->$attribute->createTableSqlStmt() . ",";
		}
		$sqlStmt = $sqlStmt . "PRIMARY KEY (`" . $pkName . "`))";
		return $sqlStmt;
	}
	
	function create() {
		$sqlStmt = $this->createTableSqlStmt();
		if(!$this->execute($sqlStmt)) {
			return true;
		}
		throw new Exception("Exception: Error in creating table in the remote database.");
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