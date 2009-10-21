<?php
require_once 'init.php';

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
	}
}
 
class ModelTest extends PHPUnit_Framework_TestCase {
	private $mock;
	
	protected function setUp() {
		$this->mock = new Mock;
	}
	
	function testSetValue() {
		$this->mock->integer->setValue(1);
		$this->assertEquals(1, $this->mock->integer->getValue());
	}
	
	function testSetPKName() {
		$this->mock->setPKField("integer");
		$this->assertEquals("integer", $this->mock->getPKField());
	}

	function testSetErrorAttributeToPKName() {
		try {
			$this->mock->setPKField("id");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: set error attribute to primary key.");
	}
	
	function testGetPKDirectly() {
		try {
			$this->mock->primaryKey;
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: no priviledge to get primary key directly!");
	}
	
	function testGetPKWithoutDefineIt() {
		try {
			$this->mock->getPKField();
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Get primary key without define it.");
	}
	
	function testGetVars() {
		$testArray = $this->mock->getVars();
		$this->assertEquals("integer", $testArray[0]);
		$this->assertEquals("date", $testArray[1]);
		$this->assertEquals("text", $testArray[5]);
	}
	
	function testGetVarsWithoutPK() {
		$this->mock->setPKField("integer");
		$testArray = $this->mock->getVarsWithoutPK();
		$this->assertEquals("date", $testArray[0]);
		$this->assertEquals("text", $testArray[4]);
		$this->mock->setPKField("text");
		$testArray = $this->mock->getVarsWithoutPK();
		$this->assertEquals("integer", $testArray[0]);
		$this->assertEquals("string", $testArray[4]);
	}
	
	function testGetModelName() {
		$this->assertEquals("Mock", $this->mock->getModelName());
	}
	
	function testGetTableName() {
		$this->assertEquals("mock", $this->mock->getTableName());
	}
	
	function testGetPK() {
		$this->mock->setPKField("integer");
		$this->assertEquals("IntegerField", $this->mock->pk->getFieldType());
		$this->mock->setPKField("date");
		$this->assertEquals("DateField", $this->mock->pk->getFieldType());
	}
}