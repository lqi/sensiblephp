<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");

class MockModel extends Model {
	protected $integer;
	protected $datetime;
	protected $text;
	
	public function __construct() {
		$this->integer = new IntegerField;
		$this->datetime = new DatetimeField;
		$this->text = new TextField;
	}
}
 
class ModelTest extends PHPUnit_Framework_TestCase {
	private $mock;
	
	protected function setUp() {
		$this->mock = new MockModel;
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
	
	function testGetPKFieldDirectly() {
		try {
			$this->mock->primaryKey;
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: no priviledge to get primary key directly!");
	}
	
	function testGetPKFieldWithoutDefineIt() {
		try {
			$this->mock->getPKField();
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Get primary key without define it.");
	}

	function testGetPKObject() {
		$this->mock->integer->setValue(1);
		$this->mock->setPKField("integer");
		$this->assertEquals(1, $this->mock->pk->getValue());
	}
	
	function testGetPKObjectWithoutDefineIt() {
		try {
			$this->mock->pk;
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Get PK Object without define it.");
	}
	
	function testGetVars() {
		$testArray = $this->mock->getVars();
		$this->assertEquals("integer", $testArray[0]);
		$this->assertEquals("datetime", $testArray[1]);
		$this->assertEquals("text", $testArray[2]);
	}
	
	function testGetVarsWithoutPK() {
		$this->mock->setPKField("integer");
		$testArray = $this->mock->getVarsWithoutPK();
		$this->assertEquals("datetime", $testArray[0]);
		$this->assertEquals("text", $testArray[1]);
	}
	
	function testGetModelName() {
		$this->assertEquals("MockModel", $this->mock->getModelName());
	}
	
	function testGetTableName() {
		$this->assertEquals("mockmodel", $this->mock->getTableName());
	}
}