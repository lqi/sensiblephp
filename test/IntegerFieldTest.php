<?php
require_once 'init.php';
 
class IntegerFieldTest extends PHPUnit_Framework_TestCase
{
	private $integerField;
	
	protected function setUp() {
		$this->integerField = new IntegerField;
	}
	
	function testGetFieldType() {
		$this->assertEquals("IntegerField", $this->integerField->getFieldType());
	}
	
	function testGetValue() {
		$this->integerField->setValue(1);
		$this->assertEquals(2, $this->integerField->getValue() + 1);
	}
	
	function testSetChar() {
		try {
			$this->integerField->setValue("a");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Set Characters to Integer Field.");
	}
	
	function testSetFloat() {
		try {
			$this->integerField->setValue(1.11);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Set Float to Integer Field.");
	}
}
?>