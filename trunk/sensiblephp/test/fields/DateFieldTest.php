<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class DateFieldTest extends PHPUnit_Framework_TestCase
{
	private $dateField;
	
	protected function setUp() {
		$this->dateField = new DateField;
	}
	
	public function testGetYearByDefineDate() {
		$this->dateField = new DateField(2009, 1, 2);
		$this->assertEquals(2009, $this->dateField->getYear_Y());
	}

	public function testGetMonthByDefineDate() {
		$this->dateField = new DateField(2009, 1, 2);
		$this->assertEquals(1, $this->dateField->getMonth_n());
	}

	public function testGetDayByDefineDate() {
		$this->dateField = new DateField(2009, 1, 2);
		$this->assertEquals(2, $this->dateField->getDay_j());
	}
	
	public function testGetYearOfToday() {
		$this->assertEquals((int) date("Y"), $this->dateField->getYear_Y());
	}
	
	public function testGetMonthOfToday() {
		$this->assertEquals((int) date("n"), $this->dateField->getMonth_n());
	}
	
	public function testGetDayOfToday() {
		$this->assertEquals((int) date("j"), $this->dateField->getDay_j());
	}

	public function testGetYearOfTodayByDefault() {
		$this->dateField = new DateField(0, 0, 0);
		$this->assertEquals((int) date("Y"), $this->dateField->getYear_Y());
	}

	public function testGetMonthOfTodayByDefault() {
		$this->dateField = new DateField(0, 0, 0);
		$this->assertEquals((int) date("n"), $this->dateField->getMonth_n());
	}

	public function testGetDayOfTodayByDefault() {
		$this->dateField = new DateField(0, 0, 0);
		$this->assertEquals((int) date("j"), $this->dateField->getDay_j());
	}
	
	public function testErrorInput() {
		try {
			$this->dateField = new DateField("abc", 0, 32);
			$this->fail("Exception expected: Error Input!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testErrorDateInput() {
		try {
			$this->dateField = new DateField(2009, -1, 32);
			$this->fail("Exception expected: Error Date!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testDateOfLeapYear() {
		$this->dateField = new DateField(2008, 2, 29);
		$this->assertEquals(29, $this->dateField->getDay_j());
	}
	
	public function testGetValueOfToday() {
		$this->assertEquals(date("Y-m-d"), $this->dateField->getValue());
	}
	
	public function testGetValueOfDefineDate() {
		$this->dateField = new DateField(2009, 11, 22);
		$this->assertEquals("2009-11-22", $this->dateField->getValue());
	}
	
	public function testProcessingPROValue() {
		$now = "2009-11-22";
		$this->dateField->processingPDOValue($now);
		$this->assertEquals("2009-11-22", $this->dateField->getValue());
	}
	
	public function testProcessingErrorPROValue() {
		$errorDate = "2009-12-32";
		try {
			$this->dateField->processingPDOValue($errorDate);
			$this->fail("Exception expected: Suffer error date when processing PRO value!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testCreateTableSqlStmt() {
		$this->assertEquals("date NOT NULL", $this->dateField->createTableSqlStmt());
	}
}
?>