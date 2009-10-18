<?php
require_once 'init.php';
 
class DateFieldTest extends PHPUnit_Framework_TestCase
{
	private $dateField;
	
	protected function setUp() {
		$this->dateField = new DateField;
	}
	
	public function testGetType() {
		$this->assertEquals("DateField", $this->dateField->getFieldType());
	}
	
	public function testSetDate() {
		$this->dateField = new DateField(2009, 1, 1);
		$this->assertEquals(2009, $this->dateField->getYear_Y());
		$this->assertEquals(1, $this->dateField->getMonth_n());
		$this->assertEquals(1, $this->dateField->getDay_j());
	}
	
	public function testDateOfToday() {
		$this->assertEquals((int) date("Y"), $this->dateField->getYear_Y());
		$this->assertEquals((int) date("n"), $this->dateField->getMonth_n());
		$this->assertEquals((int) date("j"), $this->dateField->getDay_j());
	}
	
	public function testErrorInput() {
		try {
			$this->dateField = new DateField("abc", 0, 32);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error Input!");
	}
	
	public function testErrorDateInput() {
		try {
			$this->dateField = new DateField(2009, -1, 32);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error Date!");
	}
	
	public function testDateOfLeapYear() {
		$this->dateField = new DateField(2008, 2, 29);
		$this->assertEquals(29, $this->dateField->getDay_j());
	}
	
	public function testGetValue() {
		$this->assertEquals(date("Y-m-d"), $this->dateField->getValue());
	}
}
?>