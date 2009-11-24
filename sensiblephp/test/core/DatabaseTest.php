<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");

class Mock extends Model {
	protected $integer;
	protected $date;
	protected $time;
	protected $datetime;
	protected $string;
	protected $text;
	
	public function __construct() {
		$this->integer = new IntegerField;
		$this->datetime = new DatetimeField;
		$this->date = new DateField;
		$this->time = new TimeField;
		$this->string = new StringField;
		$this->text = new TextField;
		$this->setPKField("integer");
	}
}

class MockDb extends Database {
	function connection() {
		$conn = "mysql:host=localhost;dbname=cents";	
		$this->setDbConnection(new PDO($conn, "root", "root"));
	}
	
	function setDbConnection($dbh) {
		parent::setDbConnection($dbh);
	}
	
	function getTableName() {
		return parent::getTableName();
	}
	
	function getPKName() {
		return parent::getPKName();
	}
	
	function getModelName() {
		return parent::getModelName();
	}
	
	function valueObject($array) {
		return parent::valueObject($array);
	}
	
	function query($stmt) {
		return parent::query($stmt);
	}
	
	function execute($stmt) {
		return parent::execute($stmt);
	}
}
 
class DatabaseTest extends PHPUnit_Framework_TestCase {
	private $mockDb;
	
	protected function setUp() {
		$this->mockDb = new MockDb;
		$this->initDatabase();
	}
	
	private function initDatabase() {
		$dropTableStmt = "DROP TABLE `mock`";
		$this->mockDb->execute($dropTableStmt);
		$this->mockDb->create();
		$insertStmt1 = "INSERT INTO `cents`.`mock` (`integer`, `date`, `time`, `datetime`, `string`, `text`) 
			VALUES (NULL, '2008-8-8', '8:8:8', '2008-8-8 8:8:8', 'First', 'This is the first item.')";
		$this->mockDb->execute($insertStmt1);
		$insertStmt2 = "INSERT INTO `cents`.`mock` (`integer`, `date`, `time`, `datetime`, `string`, `text`) 
			VALUES (NULL, '2009-9-9', '9:9:9', '2009-9-9 9:9:9', 'Second', 'This is the second item.')";
		$this->mockDb->execute($insertStmt2);
	}

	function testGetModelName() {
		$this->assertEquals("Mock", $this->mockDb->getModelName());
	}
	
	function testGetTableName() {
		$this->assertEquals("mock", $this->mockDb->getTableName());
	}
	
	function testGetPrimaryKeyName() {
		$this->assertEquals("integer", $this->mockDb->getPKName());
	}
	
	function testGetValueObjectForIntegerField() {
		$array["integer"] = "1";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals(1, $valueObject->integer->getOriginalValue());
	}
	
	function testGetValueObjectForDateField() {
		$array["date"] = "2008-02-29";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals(2008, $valueObject->date->getYear_Y());
		$this->assertEquals(2, $valueObject->date->getMonth_n());
		$this->assertEquals(29, $valueObject->date->getDay_j());
	}
	
	function testGetValueObjectForTimeField() {
		$array["time"] = "23:00:59";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals(23, $valueObject->time->getHour_G());
		$this->assertEquals(0, $valueObject->time->getMinute_org());
		$this->assertEquals(59, $valueObject->time->getSecond_org());
	}
	
	function testGetValueObjectForDatetimeField() {
		$array["datetime"] = "2008-02-29 23:00:59";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals("2008-02-29 23:00:59", $valueObject->datetime->getValue());
	}
	
	function testGetValueObjectForStringField() {
		$array["string"] = "I'll be there at \nten o'clock.";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals("I'll be there at \nten o'clock.", $valueObject->string->getOriginalValue());
	}
	
	function testGetValueObjectForTextField() {
		$array["text"] = "Okay, see you \tthen!";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals("Okay, see you \tthen!", $valueObject->text->getOriginalValue());
	}
	
	function testGetValueObjectForIngoringNumberKey() {
		$array[1] = "This should be ignored!";
		$array["integer"] = "1";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals(1, $valueObject->integer->getOriginalValue());
	}
	
	function testSelectWithNoExtraStatement() {
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "`";
		$array = array();
		foreach($this->mockDb->query($sql) as $row) {
			$array[] = $this->mockDb->valueObject($row);
		}
		$this->assertEquals($array, $this->mockDb->select());
	}
	
	function testSelectWithExtraStatement() {
		$stmt = "ORDER BY `" . $this->mockDb->getPKName() . "` DESC";
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "` " . $stmt;
		$array = array();
		foreach($this->mockDb->query($sql) as $row) {
			$array[] = $this->mockDb->valueObject($row);
		}
		$this->assertEquals($array, $this->mockDb->select($stmt));
	}
	
	function testAll() {
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "` ORDER BY `" . $this->mockDb->getPKName() . "` DESC";
		$array = array();
		foreach($this->mockDb->query($sql) as $row) {
			$array[] = $this->mockDb->valueObject($row);
		}
		$this->assertEquals($array, $this->mockDb->all());
	}
	
	function testGet() {
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "` WHERE `" . $this->mockDb->getPKName() . "` = 1";
		$this->assertEquals(1, $this->mockDb->get(1)->integer->getValue());
	}
	
	function testFilterByTwoParameters() {
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "` ORDER BY `" . 
			$this->mockDb->getPKName() . "` DESC LIMIT 1, 1";
		$array = array();
		foreach($this->mockDb->query($sql) as $row) {
			$array[] = $this->mockDb->valueObject($row);
		}
		$this->assertEquals($array, $this->mockDb->filter(1, 1));
	}
	
	function testFilterByOneParameter() {
		$sql = "SELECT * FROM `" . $this->mockDb->getTableName() . "` ORDER BY `" . 
			$this->mockDb->getPKName() . "` DESC LIMIT 0, 2";
		$array = array();
		foreach($this->mockDb->query($sql) as $row) {
			$array[] = $this->mockDb->valueObject($row);
		}
		$this->assertEquals($array, $this->mockDb->filter(2));
	}
	
	function testFilterByErrorParameter() {
		try {
			$this->mockDb->filter("s", 1);
		}
		catch(Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error filter input!");
	}
	
	function testRemoveWithNoExistingPrimaryKey() {
		$this->assertEquals(0, $this->mockDb->rm(99));
	}
	
	function testRemove() {
		$this->assertEquals(1, $this->mockDb->rm(1));
	}
	
	function testDeleteAll() {
		$this->assertEquals(2, $this->mockDb->delete());
	}
	
	function testDeleteWithStatement() {
		$this->assertEquals(1, $this->mockDb->delete("WHERE `integer`=1"));
	}
	
	function testCreateSqlStatement() {
		$this->assertEquals("CREATE TABLE `mock` (`integer` int(11) NOT NULL AUTO_INCREMENT,`date` date NOT NULL,`time` time NOT NULL,`datetime` datetime NOT NULL,`string` varchar(255) NOT NULL,`text` text NOT NULL,PRIMARY KEY (`integer`))", $this->mockDb->createTableSqlStmt());
	}
	/*
	function testCreateTableException() {
		try {
			$this->mockDb->create();
		}
		catch(Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error in creating Table in remote database.");
	}*/
	
	function testInsertNewItem() {
		$mock = new Mock;
		$mock->datetime->processingPDOValue(date("Y-m-d H:i:s"));
		$mock->date->processingPDOValue(date("Y-m-d"));
		$mock->time->processingPDOValue(date("H:i:s"));
		$mock->string->setValue("New item test string.");
		$mock->text->setValue("Text Test");
		$this->assertTrue($this->mockDb->save($mock));
		$this->assertEquals("New item test string.", $this->mockDb->get(3)->string->getValue());
	}
	
	function testUpdateCurrentItem() {
		$mock = new Mock;
		$mock->integer->setValue(1);
		$mock->datetime->processingPDOValue(date("Y-m-d H:i:s"));
		$mock->date->processingPDOValue(date("Y-m-d"));
		$mock->time->processingPDOValue(date("H:i:s"));
		$mock->string->setValue("String Test");
		$mock->text->setValue("Change current item test text.");
		$this->assertTrue($this->mockDb->save($mock));
		$this->assertEquals("Change current item test text.", $this->mockDb->get(1)->text->getValue());
	}
}