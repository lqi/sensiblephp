<?php
require_once 'init.php';

/*
CREATE TABLE `mock` (
 `integer` int(11) NOT NULL AUTO_INCREMENT,
 `date` date NOT NULL,
 `time` time NOT NULL,
 `datetime` datetime NOT NULL,
 `string` varchar(30) NOT NULL,
 `text` text NOT NULL,
 PRIMARY KEY (`integer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

INSERT INTO `cents`.`mock` (`integer`, `date`, `time`, `datetime`, `string`, `text`) 
VALUES (NULL, '2008-8-8', '8:8:8', '2008-8-8 8:8:8', 'First', 'This is the first item.');

INSERT INTO `cents`.`mock` (`integer`, `date`, `time`, `datetime`, `string`, `text`) 
VALUES (NULL, '2009-9-9', '9:9:9', '2009-9-9 9:9:9', 'Second', 'This is the second item.')
*/

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
		try {
			$this->setDbConnection(new PDO($conn, "root", "root"));
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}	
}
 
class DatabaseTest extends PHPUnit_Framework_TestCase {
	private $mockDb;
	
	protected function setUp() {
		$this->mockDb = new MockDb;
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
	
	function testRemove() {
		$this->assertEquals(0, $this->mockDb->rm(99));
	} // Only negative test case at the moment, need more
	
	function testCreate() {
		$this->assertEquals("SUCCESS", $this->mockDb->create("CREATE"));
	}
	
	function testCreateWithoutConfirmMessage() {
		try {
			$this->mockDb->create();
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: without confirm message.");
	}
	
	function testCreateWithIlligalConfirmMessage() {
		try {
			$this->mockDb->create("somethingElse");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: with illigal confirm message");
	}
	
	function testDrop() {
		$this->assertEquals("SUCCESS", $this->mockDb->drop("DROP"));
	}
	
	function testDropWithoutConfirmMessage() {
		try {
			$this->mockDb->drop();
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: without confirm message.");
	}
	
	function testDropWithIlligalConfirmMessage() {
		try {
			$this->mockDb->drop("somethingElse");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: with illigal confirm message");
	}
	
	function testInsertNewItem() {
		$mock = new Mock;
		$mock->datetime->setValue(date("Y"),date("m"),date("d"),
								date("H"),date("i"),date("s"));
		$mock->date->setValue(date("Y"),date("m"),date("d"));
		$mock->time->setValue(date("H"),date("i"),date("s"));
		$mock->string->setValue("String Test");
		$mock->text->setValue("Text Test");
		$this->assertTrue($this->mockDb->save($mock));
	}
	
	function testUpdateCurrentItem() {
		$mock = new Mock;
		$mock->integer->setValue(1);
		$mock->datetime->setValue(date("Y"),date("m"),date("d"),
								date("H"),date("i"),date("s"));
		$mock->date->setValue(date("Y"),date("m"),date("d"));
		$mock->time->setValue(date("H"),date("i"),date("s"));
		$mock->string->setValue("String Test");
		$mock->text->setValue("Text Test");
		$this->assertTrue($this->mockDb->save($mock));
	}
}