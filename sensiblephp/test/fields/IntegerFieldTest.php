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
	
	function testProcessingPDOValue() {
		$this->integerField->processingPDOValue(123);
		$this->assertEquals(123, $this->integerField->getValue());
	}
	
	function testProcessingPDOStringValue() {
		$this->integerField->processingPDOValue("123");
		$this->assertEquals(123, $this->integerField->getValue());
	}
	
	/* PAY ATTENTION: this test cannot pass at the moment, need modification! - assign to L. Qi
	function testProcessingPDOErrorString() {
		try {
			$this->integerField->processingPDOValue("a");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Set characters to Integer Field when processing the Php Database Object.");
	}
	*/
}
?>