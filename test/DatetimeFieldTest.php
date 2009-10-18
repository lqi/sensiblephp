<?php
require_once 'init.php';
 
class DatetimeFieldTest extends PHPUnit_Framework_TestCase
{
	private $datetimeField;
	
	protected function setUp() {
		$this->datetimeField = new DatetimeField;
	}
	
	function testGetFieldType() {
		$this->assertEquals("DatetimeField", $this->datetimeField->getFieldType());
	}
	
	public function testSetDatetime() {
		$this->datetimeField = new DatetimeField(2008, 8, 8, 20, 8, 8);
		$this->assertEquals(date("Y-m-d H:i:s", mktime(20, 8, 8, 8, 8, 2008)), $this->datetimeField->getValue());
	}
	
	public function testSetErrorInput() {
		try {
			$this->datetimeField = new DatetimeField("abc", 0, 0, 0, 0, -1);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception exptected: Inpur error!");
	}
}