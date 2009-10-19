<?php
require_once 'init.php';

class Mock {
	private $integer;
	private $date;
	private $time;
	private $datetime;
	private $string;
	private $text;
	
	public function __construct() {
		$this->integer = new IntegerField;
		$this->datetime = new DatetimeField;
		$this->date = new DateField;
		$this->time = new TimeField;
		$this->string = new StringField;
		$this->text = new TextField;
	}
	
	public function __set($key, $value) {
		if(is_resource($key))
			throw new Exception('Exception: Attribute Not Found.');
		$key = $value;
	}

	public function __get($key) {
		return $this->$key;
	}
}

class MockDb extends Database {
	function connection() {
		// As a mock object, do not need to connect to the remote server,
		// so here, overwrite the parent methods.
	}
	
}
 
class DatabaseTest extends PHPUnit_Framework_TestCase
{
	private $mockDb;
	
	protected function setUp() {
		$this->mockDb = new MockDb;
	}
	
	function testGetMockDb() {
		$this->assertEquals(null, $this->mockDb->db());
	}
	
	function testGetTableName() {
		$this->assertEquals("mock", $this->mockDb->getTableName());
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
	
	function testGetValueObjectForStringAndTextField() {
		$array["string"] = "I'll be there at \nten o'clock.";
		$array["text"] = "Okay, see you \tthen!";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals("I'll be there at \nten o'clock.", $valueObject->string->getOriginalValue());
		$this->assertEquals("Okay, see you \tthen!", $valueObject->text->getOriginalValue());
	}
	
	function testGetValueObjectForIngoringNumberKey() {
		$array["date"] = "2008-02-29";
		$array[1] = "This should be ignored!";
		$array["integer"] = "1";
		$valueObject = $this->mockDb->valueObject($array);
		$this->assertEquals(1, $valueObject->integer->getOriginalValue());
		$this->assertEquals(2008, $valueObject->date->getYear_Y());
		$this->assertEquals(2, $valueObject->date->getMonth_n());
		$this->assertEquals(29, $valueObject->date->getDay_j());
	}
}