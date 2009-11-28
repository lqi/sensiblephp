<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class IntegerFieldTest extends PHPUnit_Framework_TestCase
{
	private $integerField;
	
	protected function setUp() {
		$this->integerField = new IntegerField;
	}
	
	function testGetValue() {
		$this->integerField->setValue(1);
		$this->assertEquals(1, $this->integerField->getValue());
	}
	
	function testSetChar() {
		try {
			$this->integerField->setValue("a");
			$this->fail("Exception expected: Set Characters to Integer Field.");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	function testSetFloat() {
		try {
			$this->integerField->setValue(1.11);
			$this->fail("Exception expected: Set Float to Integer Field.");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	function testProcessingPDOValue() {
		$this->integerField->processingPDOValue(123);
		$this->assertEquals(123, $this->integerField->getValue());
	}
	
	function testProcessingPDOStringValue() {
		$this->integerField->processingPDOValue("123");
		$this->assertEquals(123, $this->integerField->getValue());
	}
}
?>